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
                    <v-divider
                        class="border-opacity-100 mx-6"
                        style=""
                    ></v-divider>

                    <v-card-text>
                        <v-form ref="formRef" class="pt-4">
                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.amount"
                                    variant="outlined"
                                    label="Amount *"
                                    class="pb-4 pr-2 w-50"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                                <v-text-field
                                    v-model="formData.date"
                                    type="date"
                                    variant="outlined"
                                    label="Date"
                                    class="pb-4 pl-2 w-50"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                            </div>

                            <v-textarea
                                v-model="formData.note"
                                variant="outlined"
                                label="Details "
                                class="pb-3"
                                density="compact"
                            ></v-textarea>
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
    billExpenseId: ExpenseRepository.billExpenseId,
    id: ExpenseRepository.billExpensePayment.id,
    amount: ExpenseRepository.billExpensePayment.amount,
    date: ExpenseRepository.billExpensePayment.date,
    note: ExpenseRepository.billExpensePayment.note,
});
const rules = {
    required: (value) => !!value || "This field is required.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name.",
};
console.log(ExpenseRepository.Expense, "man");
const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        if (ExpenseRepository.isEditMode) {
            await ExpenseRepository.UpdateBillExpensePayment(
                formData.id,
                formData
            );
        } else {
            await ExpenseRepository.CreateBillExpensePayment(formData);
        }
    }
};
formData.date = ExpenseRepository.getTodaysDate();
</script>
