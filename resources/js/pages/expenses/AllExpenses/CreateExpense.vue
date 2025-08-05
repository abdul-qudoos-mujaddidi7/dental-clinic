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
                                    ? $t("update")
                                    : $t("create")
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
                                        format="YYYY/MM/DD"
                                        :locale-config="LocaleConfigs"
                                        @change="checkDate"
                                    />
                                </div>
                            </div>
                            <div class="flex w-100">
                                <v-autocomplete
                                    :items="ExpenseRepository.moneyAccsFor"
                                    v-model="formData.money_account_id"
                                    :return-object="false"
                                    variant="outlined"
                                    :label="t('account') + ' *'"
                                    class="pr-2 w-50 pb-4"
                                    style="width: 45%"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-autocomplete>

                                <v-text-field
                                    v-model="formData.amount"
                                    variant="outlined"
                                    :label="$t('amount')"
                                    class="pb-4 pl-2 w-50"
                                    density="compact"
                                    :rules="[rules.required, rules.number]"
                                ></v-text-field>
                            </div>

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
                            {{
                                ExpenseRepository.isEditMode
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
import { ref, reactive , watch} from "vue";
import { useExpenseRepository } from "@/store/ExpenseRepository";
import { LocaleConfigs } from "../../../LocaleConfigs";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
const ExpenseRepository = useExpenseRepository();
const formRef = ref(null);
import dayjs from "dayjs";
import { rule } from "postcss";

import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const today = dayjs().format("YYYY/MM/DD"); // Match your date format

const formData = reactive({
    id: ExpenseRepository.Expense.id,
    date: ExpenseRepository.Expense.date,
    amount: ExpenseRepository.Expense.amount,
    money_account_id: ExpenseRepository.Expense.account?.id,
    expenseCategoryId: ExpenseRepository.Expense.expenseCategory?.id,
    note: ExpenseRepository.Expense.note,
});
const rules = {
    required: (value) => !!value || t("validation.required"),

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) || t("validation.onlyLetters"),

    number: (value) => /^\d*\.?\d+$/.test(value) || t("validation.number"),

    numberLength: (value) => value.length <= 12 || t("validation.maxLength12"),

    notFutureDate: (value) => {
        if (!value) return true;
        const selected = dayjs(value, "YYYY/MM/DD");
        const now = dayjs();
        return !selected.isAfter(now, "day") || t("validation.noFutureDate");
    },
};
toast.error(t("validation.noFutureDate"))

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

ExpenseRepository.fetchMoneyAccountsFor();

watch(
  () => formData.date,
  (newDate) => {
    const today = dayjs().format("YYYY/MM/DD");
    if (dayjs(newDate).isAfter(today)) {
      formData.date = today;
      toast.error(t("validation.noFutureDate")); // Use i18n toast
    }
  }
);


formData.date = ExpenseRepository.getTodaysDate();
ExpenseRepository.Categories();
</script>
