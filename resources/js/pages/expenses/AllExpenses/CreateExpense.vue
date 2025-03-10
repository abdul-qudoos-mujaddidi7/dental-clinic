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
                            {{ ExpenseRepository.isEditMode ? $t("update") : $t("create") }}

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
                            <div class="d-flex w-100 pb-3">
                                <v-autocomplete
                                    v-model="formData.expenseCategoryId"
                                    :items="ExpenseRepository.categories"
                                    variant="outlined"
                                    :label="$t('category')"

                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                    :rules="[rules.required]"
                                    class="w-50 pr-2"
                                ></v-autocomplete>
                                <div class="pb-4 w-50 pl-2">
                                    <date-picker
                                        mode="single"
                                        :column="1"
                                        v-model="formData.date"
                                        :styles="styles"
                                        locale="fa"
                                        type="date"
                                        format="jYYYY/jMM/jDD"
                                        :locale-config="LocaleConfigs"
                                    />
                                </div>
                            </div>

                            <v-text-field
                                v-model="formData.amount"
                                variant="outlined"
                                :label="$t('amount')"

                                class="pb-3"
                                density="compact"
                                :rules="[rules.required, rules.number]"
                            ></v-text-field>

                            <v-textarea
                                v-model="formData.note"
                                density="compact"
                                variant="outlined"
                                :label="$t('details')"

                            ></v-textarea>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn
                            color="#112F53"
                            class="px-4"
                            @click="saveExpense"
                        >
                        {{ ExpenseRepository.isEditMode ? $t("update") : $t("submit") }}

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
import { LocaleConfigs } from "../../../LocaleConfigs";
const ExpenseRepository = useExpenseRepository();
const formRef = ref(null);

const formData = reactive({
    id: ExpenseRepository.Expense.id,
    date: ExpenseRepository.Expense.date,
    amount: ExpenseRepository.Expense.amount,
    expenseCategoryId: ExpenseRepository.Expense.expenseCategory?.id,
    note: ExpenseRepository.Expense.note,
});
const rules = {
    required: (value) => !!value || "This field is required.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name with letters only.",

    number: (value) =>
        /^\d*\.?\d+$/.test(value) || "Please enter a valid number.",

    numberLength: (value) =>
        value.length <= 12 || "Must be 12 characters or fewer.",
};
console.log(ExpenseRepository.Expense, "man");
const saveExpense = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        if (ExpenseRepository.isEditMode) {
            await ExpenseRepository.UpdateExpense(formData.id, formData);
        } else {
            await ExpenseRepository.CreateExpense(formData);
        }
    }
};
formData.date = ExpenseRepository.getTodaysDate();
ExpenseRepository.Categories();
</script>
