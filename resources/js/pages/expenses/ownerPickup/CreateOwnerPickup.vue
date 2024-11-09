<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="ExpenseRepository.createDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2 class="font-weight-bold pl-4">
                            {{
                                ExpenseRepository.isEditMode
                                    ? "Update"
                                    : "Create"
                            }}
                        </h2>
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider class="border-opacity-100 mx-6"></v-divider>

                    <v-card-text>
                        <v-form ref="formRef" class="pt-4">
                            <div class="d-flex w-100">
                                <v-text-field
                                    v-model="formData.date"
                                    variant="outlined"
                                    label="Date"
                                    class="pb-4 w-50 pr-2"
                                    density="compact"
                                    :rules="[rules.required]"
                                    type="date"
                                ></v-text-field>
                                <v-autocomplete
                                    v-model="formData.ownerId"
                                    :items="ExpenseRepository.owner"
                                    :return-object="false"
                                    variant="outlined"
                                    label="owners *"
                                    item-value="id"
                                    item-title="first_name"
                                    density="compact"
                                    :rules="[rules.required]"
                                    class="w-50 pl-2 pb-4"
                                >
                                </v-autocomplete>
                            </div>

                            <v-text-field
                                v-model="formData.amount"
                                variant="outlined"
                                label="Amount "
                       
                                density="compact"
                                :rules="[rules.required]"
                            ></v-text-field>

                            <v-textarea
                                v-model="formData.note"
                                variant="outlined"
                                label="Description "
                                density="compact"
                            >
                            </v-textarea>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                ExpenseRepository.isEditMode
                                    ? "Update"
                                    : "Submit"
                            }}
                        </v-btn>
                    </div>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useExpenseRepository } from "@/store/ExpenseRepository";

const ExpenseRepository = useExpenseRepository();
const formRef = ref(null);

const formData = reactive({
    id: ExpenseRepository.ownerPickup.id,
    amount: ExpenseRepository.ownerPickup.amount,
    date: ExpenseRepository.ownerPickup.date,
    note: ExpenseRepository.ownerPickup.description,
    ownerId: ExpenseRepository.ownerPickup.owner?.ownerID,
});
const rules = {
    required: (value) => !!value || "This field is required.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name.",
};

const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        if (ExpenseRepository.isEditMode) {
            await ExpenseRepository.UpdateOwnerPickup(formData.id, formData);
        } else {
            await ExpenseRepository.CreateOwnerPickup(formData);
        }
    }
};
ExpenseRepository.fetchOwners();
formData.date = ExpenseRepository.getTodaysDate()
</script>
