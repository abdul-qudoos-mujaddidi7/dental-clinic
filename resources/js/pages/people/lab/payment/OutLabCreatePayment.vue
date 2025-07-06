<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="PeopleRepository.labCreatePaymentDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2 class="font-weight-bold pl-4">
                            {{
                                PeopleRepository.isEditMode
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
                                <div class="pb-4 w-50 pr-2">
                                    <date-picker
                                        mode="single"
                                        :column="1"
                                        v-model="formData.date"
                                        :styles="styles"
                                        locale="fa"
                                        type="date"
                                        format="YYYY/MM/DD"
                                        :locale-config="LocaleConfigs"
                                    />
                                </div>
                                <v-autocomplete
                                    :items="PeopleRepository.AccsForCreate"
                                    v-model="formData.accountId"
                                    variant="outlined"
                                    :label="t('account') + ' *'"
                                    class="pl-2 w-50 pb-4"
                                    style="width: 45%"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                    :return-object="false"
                                    :rules="[rules.required]"
                                ></v-autocomplete>
                            </div>
                            <v-text-field
                                v-model="formData.amount"
                                variant="outlined"
                                label="Amount *"
                                class="pb-4"
                                density="compact"
                                :rules="[rules.required]"
                            ></v-text-field>

                            <v-textarea
                                v-model="formData.description"
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
                                PeopleRepository.isEditMode
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
import { usePeopleRepository } from "@/store/PeopleRepository";
import { useI18n } from "vue-i18n";
import { LocaleConfigs } from "../../../../LocaleConfigs";
const { t } = useI18n();
const PeopleRepository = usePeopleRepository();
const formRef = ref(null);

const formData = reactive({
    people_id:
        PeopleRepository.peopleId || PeopleRepository.paymentLab?.people?.id,
    parent_record_id: PeopleRepository.labIdForPayment,
    id: PeopleRepository.paymentLab.id,
    amount: PeopleRepository.paymentLab.amount,
    accountId: PeopleRepository.paymentLab.accountId,
    date: PeopleRepository.paymentLab.date,
    description: PeopleRepository.paymentLab.note,
});
const rules = {
    required: (value) => !!value || "This field is required.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name.",
};
console.log(PeopleRepository.Expense, "man");
const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        if (PeopleRepository.isEditMode) {
            await PeopleRepository.UpdateLabPayment(formData.id, formData);
        } else {
            await PeopleRepository.CreateLabPayment(formData);
        }
    }
};
PeopleRepository.MoneyAccountsForCreate();
console.log(PeopleRepository.AccsForCreate, "compy");
formData.date = PeopleRepository.getTodaysDate();
</script>
