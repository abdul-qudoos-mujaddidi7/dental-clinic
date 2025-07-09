<template>
    <CReateExpensePRoduct v-if="ExpenseRepository.createDialog" />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <AppBar
                :mainTitle="t('updateBillExpense')"
                :subTitle="t('expense')"
            />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-form ref="formRef" class="d-flex pt-12">
                <div class="pb-4 w-50 pr-2">
                    <date-picker
                        mode="single"
                        :column="1"
                        v-model="formData.billDate"
                        :styles="styles"
                        locale="fa"
                        type="date"
                        input-format="jYYYY/jMM/jDD"
                        format="YYYY/MM/DD"
                        :locale-config="LocaleConfigs"
                    />
                </div>

                <v-autocomplete
                    :items="ExpenseRepository.suppliersFor"
                    v-model="formData.supplierId"
                    :return-object="false"
                    variant="outlined"
                    :label="t('supplier') + ' *'"
                    class="pr-2 pl-2"
                    style="width: 45%"
                    item-value="id"
                    item-title="name"
                    density="compact"
                    :rules="[rules.required]"
                ></v-autocomplete>
                <v-text-field
                    v-model="formData.billNumber"
                    variant="outlined"
                    :label="t('billNumber')"
                    class="pl-2"
                    density="compact"
                    style="width: 45%"
                    :rules="[rules.required, rules.number]"
                ></v-text-field>
            </v-form>
            <v-divider></v-divider>
            <v-row no-gutters class="justify-space-between mt-16">
                <v-col cols="full" class="w-50" sm="12" md="12">
                    <div class="d-flex">
                        <v-text-field
                            v-model="ExpenseRepository.billExpenseSearch"
                            @keyup.enter="ExpenseRepository.SearchFetchData"
                            @input="ExpenseRepository.SearchFetchData"
                            @click:clear="clearSearch"
                            variant="outlined"
                            :label="t('searchProduct')"
                            density="compact"
                            append-inner-icon="mdi-magnify"
                            clearable
                            class="border-none"
                        ></v-text-field>
                    </div>
                    <div
                        class="rounded shadow-lg px-5 mb-12"
                        v-if="ExpenseRepository.searchFetch.length > 0"
                    >
                        <div>
                            <div
                                v-for="index in ExpenseRepository.searchFetch"
                                :key="index"
                            >
                                <p
                                    @click="CalcFetchProduct(index)"
                                    class="cursor-pointer px-4 p-1.5 hover-bg hover:text-bold selected-item"
                                >
                                    {{ index.name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </v-col>

                <table
                    class="text-sm text-center"
                    density="compact"
                    style="width: 150rem"
                >
                    <thead class="text-xs text-gray-700 uppercase thead">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-start">#</th>
                            <th scope="col" class="px-3 py-3 text-start">
                                {{ t("product") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                {{ t("qty") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                {{ t("cost") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-center">
                                {{ t("subTotal") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-end">
                                {{ t("action") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="product-table"
                            v-for="(pro, index) in combinedServices"
                            :key="index"
                        >
                            <td class="pl-3 text-start">
                                {{ index + 1 }}
                            </td>
                            <td class="pl-3 text-start">
                                {{ pro.name }}
                            </td>

                            <td class="pt-2 text-center pb-0 w-[14rem]">
                                <v-text-field
                                    v-model="pro.quantity"
                                    variant="outlined"
                                    density="compact"
                                    :rules="[rules.required, rules.positive]"
                                    class="w-75"
                                >
                                    <span class="span"> {{ pro.unit }}</span>
                                </v-text-field>
                            </td>

                            <td class="pt-2 pb-0 text-center w-[14rem]">
                                <v-text-field
                                    v-if="formData.peopleId !== null"
                                    v-model="pro.cost"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                    :rules="[rules.required, rules.positive]"
                                >
                                    <span class="span">
                                        {{ displayedCurrencySymbol }}
                                    </span>
                                </v-text-field>
                            </td>
                            <td class="text-center">
                                <span>{{ multiple(pro) }}</span>
                            </td>

                            <td class="px-3 text-end">
                                <v-icon
                                    color="red"
                                    @click="removeProduct(index)"
                                    class="mdi mdi-trash-can-outline"
                                ></v-icon>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </v-row>

            <div
                class="pt-12 w-100 flex justify-space-between items-center"
                dir="rtl"
            >
                <div
                    class="flex justify-between w-[14rem] border-t-[.1rem] border-b-[.1rem] border-dashed border-[#C6C6C6] p-1 text-lg font-bold"
                >
                    <span>{{ t("total") }}</span>
                    <span>Total</span>
                </div>

                <div class="w-[25rem]">
                    <v-text-field
                        v-model="formData.paid"
                        variant="outlined"
                        :label="t('paid')"
                        class="w-100"
                        density="compact"
                        :rules="[rules.positive]"
                    >
                        <div @click="changeCurrency" style="cursor: pointer">
                            <span class="paidSpan">
                                {{ currenctAccountName.name }}
                            </span>
                        </div>
                        {{ grandTotal }}</v-text-field
                    >
                </div>
            </div>

            <div class="pt-16">
                <v-textarea
                    v-model="formData.note"
                    class="textArea"
                    :label="t('details')"
                    variant="outlined"
                    density="compact"
                >
                </v-textarea>
            </div>
            <div class="d-flex flex-row-reverse mt-6">
                <v-btn color="#112F53" @click="update">
                    {{ t("update") }}</v-btn
                >
            </div>
        </div>
    </div>
</template>

<script setup>
import AppBar from "../../../components/AppBar.vue";
import { reactive, ref, watch, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
import { LocaleConfigs, styles } from "../../../LocaleConfigs";
import { useExpenseRepository } from "@/store/ExpenseRepository";

const ExpenseRepository = useExpenseRepository();
const routeParams = useRoute();

let formData = reactive({
    id: null,
    expenseDetails: [],
    grandTotal: 0,
    supplierId: null,
    deletedIds: [],
    billNumber: "",
    billDate: "",
    note: "",
    paid: 0,
});

ExpenseRepository.fetchBillExpense(routeParams.params.id).then((res) => {
    const billExpense = ExpenseRepository.billExpense;
    formData.id = billExpense.id;
    formData.expenseDetails = billExpense.expenseDetails || [];
    formData.grandTotal = billExpense.grandTotal;
    formData.supplierId = billExpense.supplier?.id;
    formData.billNumber = billExpense.billNumber;
    formData.billDate = billExpense.date;
    formData.note = billExpense.note;
    formData.paid = billExpense.paid;
    console.log(billExpense.date, "chiqa tyt ");
});

const formRef = ref(null);
const rules = {
    required: (value) => !!value || "This field is required.",
    positive: (value) => value >= 0 || "Negative values are not allowed.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) || "Invalid name.",
};

// Handle selecting a product from search results without duplicates
const CalcFetchProduct = (selectedProduct) => {
    const exists = ExpenseRepository.expenseProduct.some(
        (product) => product.id === selectedProduct.id
    );
    if (!exists) {
        console.log(selectedProduct);
        selectedProduct = { ...selectedProduct, productId: selectedProduct.id };
        ExpenseRepository.expenseProduct.push(selectedProduct);
        formData.expenseDetails = ExpenseRepository.expenseProduct;
    }
    clearSearch();
};

const combinedServices = computed(() => {
    console.log(
        "khan saib i love you",
        formData.expenseDetails,
        ...formData.expenseDetails
    );
    return [...formData.expenseDetails];
});
// Clear search results
const clearSearch = () => {
    ExpenseRepository.billExpenseSearch = "";
    ExpenseRepository.searchFetch = [];
};

// Remove product by index
const removeProduct = (index) => {
    const product = ExpenseRepository.expenseProduct[index];

    if (product.id) {
        formData.deletedIds.push(product.id); // Store the deleted product's ID
    }

    ExpenseRepository.expenseProduct.splice(index, 1);
};

// Calculate total for each product
const multiple = (pro) => pro.quantity * pro.cost || 0;

// Watch for changes in expenseProduct to recalculate subtotals
watch(
    () => ExpenseRepository.expenseProduct,
    () => {
        ExpenseRepository.expenseProduct.forEach((product) => {
            product.total = multiple(product);
        });
    },
    { deep: true }
);

// Calculate total sum
const totalSum = computed(() => {
    return ExpenseRepository.expenseProduct.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
});

// Update function to transform and submit formData
const update = async () => {
    formData.grandTotal = totalSum.value;
    formData.expenseDetails = formData.expenseDetails.map((data) => {
        return data.expenseProduct && data.expenseProduct.id
            ? { ...data, product: { id: data.expenseProduct.id } }
            : data;
    });

    const isValid = await formRef.value.validate();
    if (isValid) {
        await ExpenseRepository.UpdateBillExpense(formData.id, formData);
    }
};

const accountIndex = ref(0);

const currenctAccountName = computed(() => {
    const accounts = ExpenseRepository.account;

    if (!accounts || accounts.length === 0) {
        return { moneyAccountId: "...", id: null };
    }

    if (accountIndex.value >= accounts.length) {
        accountIndex.value = 0;
    }

    formData.moneyAccountId = accounts[accountIndex.value].id;

    return {
        name: accounts[accountIndex.value].name,
        id: accounts[accountIndex.value].id,
    };
});
//====================================
const changeCurrency = () => {
    const accounts = ExpenseRepository.account;
    if (!accounts || accounts.length === 0) return;
    accountIndex.value = (accountIndex.value + 1) % accounts.length;
};

ExpenseRepository.fetchAccountDataForCreate();
// Fetch suppliers for dropdown
ExpenseRepository.Suppliers();
</script>

<style scoped>
.thead {
    border-left: 4px solid #fecd07;
    background-color: #ecf1f4;
    max-width: 120rem;
}

.discount {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}
</style>
