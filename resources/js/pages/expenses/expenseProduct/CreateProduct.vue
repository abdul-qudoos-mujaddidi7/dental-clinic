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
                                    ? t('update')
                                    : t('create')
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
                            <v-text-field
                                v-model="formData.name"
                                variant="outlined"
                                :label="t('product')"
                                class="pb-4"
                                density="compact"
                                :rules="[rules.required]"
                            ></v-text-field>

                            <v-text-field
                                v-model="formData.unit"
                                variant="outlined"
                                :label="t('unit')"
                                class="pb-3"
                                density="compact"
                                :rules="[rules.required]"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                ExpenseRepository.isEditMode
                                    ? t('update')
                                    : t('submit')
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
import { useI18n } from "vue-i18n";
const { t } = useI18n();
import { useExpenseRepository } from "@/store/ExpenseRepository";

const ExpenseRepository = useExpenseRepository();
const formRef = ref(null);

const formData = reactive({
    id: ExpenseRepository.expenseProduct.id,
    name: ExpenseRepository.expenseProduct.name,
    unit: ExpenseRepository.expenseProduct.unit,
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
            await ExpenseRepository.UpdateExpenseProduct(formData.id, formData);
        } else {
            await ExpenseRepository.CreateExpenseProduct(formData);
        }
    }
};
formData.date = ExpenseRepository.getTodaysDate();
</script>
