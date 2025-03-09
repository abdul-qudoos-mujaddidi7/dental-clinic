<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="SettingRepository.transferDialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>

                        <v-divider inset></v-divider>
                        <h2 class="font-weight-bold">Create</h2>
                    </v-card-title>

                    <v-divider></v-divider>

                    <hr />

                    <v-card-text>
                        <v-form ref="formRef">
                            <!-- <v-text-field
                                variant="outlined"
                                density="compact"
                                label="Balance"
                                v-model="SettingRepository.balance1"
                                readonly
                            >
                            </v-text-field> -->
                            <div class="pb-6">
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
                            <div class="d-flex w-100 pb-2">
                                <v-autocomplete
                                    v-model="formData.from_account_id"
                                    :items="SettingRepository.moneyAccs"
                                    variant="outlined"
                                    label="From Account"
                                    class="pr-2 w-50"
                                    :return-object="false"
                                    :rules="[rules.required]"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                ></v-autocomplete>
                                <v-autocomplete
                                    v-model="formData.to_account_id"
                                    :items="SettingRepository.moneyAccs"
                                    variant="outlined"
                                    label="To Account  "
                                    class="pl-2 w-50"
                                    :return-object="false"
                                    :rules="[rules.required]"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                ></v-autocomplete>
                            </div>
                            <!-- <span class="account">{{
                            }}</span> -->

                            <div class=" d-flex w-100">
                                <v-text-field
                                    v-model="formData.amount"
                                    variant="outlined"
                                    label="Amount"
                                    class="w-50"
                                    :return-object="false"
                                    :rules="[rules.required]"
                                    density="compact"
                                >
                                </v-text-field>
                            </div>
                            <v-textarea
                                v-model="formData.description"
                               
                                label="Details"
                                variant="outlined"
                                density="compact"
                            >
                            </v-textarea>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" @click="CreateTransfer">
                            Submit</v-btn
                        >
                    </div>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useSettingRepository } from "@/store/SettingRepository";
import { LocaleConfigs } from "../../../LocaleConfigs";
const SettingRepository = useSettingRepository();

const formData = reactive({
    from_account_id: "",
    to_account_id: "",
    amount: "",
    date: "",
    description:"",

});

const CreateTransfer = async () => {
    await SettingRepository.CreateTransferAcc(formData);
};

const formRef = ref(null);
const rules = {
    required: (value) => !!value || "Field is required. ",
    name: (value) => /^[a-zA-Z\s]*$/.test(value) || "Invalid Name",
};
// SettingRepository.MoneyAccounts();
formData.date = SettingRepository.getTodaysDate();
console.log(SettingRepository.moneyAccs, "this is the need");
</script>
