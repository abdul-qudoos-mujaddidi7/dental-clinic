<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="LeadRepository.createDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2 class="font-weight-bold pl-4">
                            {{
                                LeadRepository.isEditMode
                                    ? $t("update")
                                    : $t("create")
                            }}
                        </h2>
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider class="border-opacity-100 mx-6"></v-divider>

                    <v-card-text>
                        <v-form ref="formRef" class="pt-4">
                            <div class="w-100 flex">
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                    :label="$t('name')"
                                    class="pb-4 w-100"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                        
                            </div>

                            <v-text-field
                                v-model="formData.amount"
                                variant="outlined"
                                :label="$t('salary')"
                                density="compact"
                             
                                type="number"
                                class="pb-4"
                                :rules="[rules.required]"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                LeadRepository.isEditMode
                                    ? $t("update")
                                    : $t("submit")
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
import { useLeadRepository } from "@/store/LeadRepository";

const LeadRepository = useLeadRepository();
const formRef = ref(null);
console.log(LeadRepository.paySalary,'manmmm' )
const formData = reactive({
    peopleId: LeadRepository.paySalary?.people?.id,
    // name: LeadRepository.paySalary.name,
    amount: LeadRepository.paySalary.amount,
 
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
        if (LeadRepository.isEditMode) {
            await LeadRepository.UpdatePaySalary(formData.id, formData);
        } else {
            await LeadRepository.CreatePaySalary(formData);
        }
    }
};
</script>
