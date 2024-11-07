<template>
    <CReateExpensePRoduct v-if="ExpenseRepository.createDialog" />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <AppBar mainTitle="Create Bill Expense" subTitle="expense" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-form ref="formRef" class="d-flex pt-12">
                <v-text-field
                    type="date"
                    v-model="formData.billDate"
                    variant="outlined"
                    label="Date *"
                    class="pr-2"
                    style="width: 45%"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>

                <v-autocomplete
                    :items="ExpenseRepository.suppliersFor"
                    v-model="formData.supplierId"
                    :return-object="false"
                    variant="outlined"
                    label="Supplier *"
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
                    label="Bill Number"
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
                            label="Search Product"
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
                                Product
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                Qty
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                Cost
                            </th>
                            <th scope="col" class="px-3 py-3 text-center">
                                Grand Total
                            </th>
                            <th scope="col" class="px-3 py-3 text-end">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="product-table"
                            v-for="(
                                pro, index
                            ) in ExpenseRepository.expenseProduct"
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
                    <span>{{ totalSum }}</span>
                    <span>Total</span>
                </div>

                <div>
                    <v-text-field
                        v-model="formData.paid"
                        variant="outlined"
                        label="Paid"
                        type="number"
                        density="compact"
                    >
                    </v-text-field>
                </div>
            </div>

            <div class="pt-16">
                <v-textarea
                    v-model="formData.note"
                    class="textArea"
                    label="Details"
                    variant="outlined"
                    density="compact"
                >
                </v-textarea>
            </div>
            <div class="d-flex flex-row-reverse mt-6">
                <v-btn color="#112F53" @click="createEarning"> Submit</v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppBar from "../../../components/AppBar.vue";
import { reactive, computed, ref, watch, onMounted } from "vue";

import { useExpenseRepository } from "@/store/ExpenseRepository";

const ExpenseRepository = useExpenseRepository();
const CalcFetchProduct = (index) => {
    console.log(index, "man of the match");
    ExpenseRepository.fetchProduct(index.id);
    clearSearch();
};

// ======================
const clearSearch = () => {
    ExpenseRepository.billExpenseSearch = ""; // Clear repository's search
    ExpenseRepository.searchFetch = [];
};
const removeProduct = (index) => {
    ExpenseRepository.expenseProduct.splice(index, 1);
    console.log(ExpenseRepository.expenseProduct);
};
const createExpenseProduct = () => {
    ExpenseRepository.createDialog = true;
};

const formData = reactive({
    expenseDetails: ExpenseRepository.expenseProduct,
    grandTotal: "",
    supplierId: "",
    billNumber: "",
    billDate: "",
    note: "",
    paid: "",
});
const formRef = ref(null);
const rules = {
    required: (value) => !!value || "This field is required.",
    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) || "Invalid name.",
};

const multiple = (pro) => {
    console.log(pro);
    const add = pro.quantity * pro.cost;
    console.log(add);
    return add || 0;
};

watch(
    () => ExpenseRepository.expenseProduct,
    () => {
        ExpenseRepository.expenseProduct.forEach((expenseProduct) => {
            // Update the 'subtotal' property for each service
            expenseProduct.total = multiple(expenseProduct);
            console.log(expenseProduct);
        });
    },
    { deep: true }
);

const totalSum = computed(() => {
    const total = ExpenseRepository.expenseProduct.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
    formData.grandTotal = total;
    return total;
});
// Computed Duo (remaining balance)
const Duo = computed(() => {
    return totalSum.value - formData.paid || 0;
});

const createEarning = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        formData.expenseDetails.map((data) => (data.expenseProduct = data.id));
        await ExpenseRepository.CreateBillExpense(formData);
    }
};

const saveData = async (id) => {
    await ExpenseRepository.fetchProduct(id);
};

const deleteItem = async (item) => {
    await ExpenseRepository.deleteEarning(item.id);
};
formData.billDate = ExpenseRepository.getTodaysDate();

ExpenseRepository.Suppliers();
// ====================
// =====================================
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
