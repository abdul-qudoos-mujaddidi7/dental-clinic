<template>
    <BillExpensePayment v-if="ExpenseRepository.createDialog" />
    <ShowExpensePayment v-if="ExpenseRepository.ShowExpensePayment" />
    <div class="all-expense rounded-xl" :dir="dir">
        <div class="card rounded-xl">
            <AppBar :mainTitle="$t('billExpense')" :sub-title="$t('expense')" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>

            <div class="btn-search pt-12 pb-6">
                <div class="text-field w-25">
                    <v-text-field
                        :loading="loading"
                        color="primaryOld"
                        density="compact"
                        variant="outlined"
                        :label="$t('search')"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="ExpenseRepository.billExpenseSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <router-link to="/createBillExpense">
                        <v-btn
                            color="primaryOld"
                            variant="flat"
                            :text="$t('create')"
                            class="px-6"
                        >
                        </v-btn>
                    </router-link>
                </div>
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    :dir="dir"
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        ExpenseRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ExpenseRepository.totalItems"
                                    :items="ExpenseRepository.billExpenses"
                                    :loading="ExpenseRepository.loading"
                                    :search="
                                        ExpenseRepository.billExpenseSearch
                                    "
                                    @update:options="
                                        ExpenseRepository.fetchBillExpenses
                                    "
                                    :item-key="ExpenseRepository.billExpenses"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Checkbox for selecting rows -->

                                    <template v-slot:item.checkbox="{ item }">
                                        <v-checkbox
                                            :value="item.id"
                                            v-model="selectedIds"
                                            class="w-10 d-flex"
                                        ></v-checkbox>
                                    </template>

                                    <template v-slot:item.action="{ item }">
                                        <v-menu>
                                            <template
                                                v-slot:activator="{ props }"
                                            >
                                                <v-btn
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                    variant="text"
                                                ></v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        @click="
                                                            CreateDialogShow(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi
                                                            mdi-cash-edit</v-icon
                                                        >
                                                        Create Payment
                                                    </v-list-item-title>
                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        @click="
                                                            ViewPaymentDialog(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi
                                                            mdi-cash-sync</v-icon
                                                        >
                                                        Show Payment
                                                    </v-list-item-title>
                                                    <router-link
                                                        :to="
                                                            '/updateBillExpense/' +
                                                            item.id
                                                        "
                                                    >
                                                        <v-list-item-title
                                                            class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        >
                                                            <v-icon
                                                                color="tealColor"
                                                                >mdi-square-edit-outline</v-icon
                                                            >
                                                            {{ t("edit") }}
                                                        </v-list-item-title>
                                                    </router-link>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item)
                                                        "
                                                    >
                                                        <v-icon color="error"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        {{ t("delete") }}
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                </v-data-table-server>
                                <v-btn
                                    class="header-button"
                                    v-if="selectedIds.length > 0"
                                    @click="sendSelectedIds"
                                    color="#B71C1C"
                                    text="Delete"
                                    flat
                                >
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import BillExpensePayment from "../bill Expense Payment/BillExpensePayment.vue";
import ShowExpensePayment from "../bill Expense Payment/ShowExpensePayment.vue";
//
import { useExpenseRepository } from "@/store/ExpenseRepository";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
const ExpenseRepository = useExpenseRepository();

// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

// bulk delete
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            billExpenseIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        ExpenseRepository.bulkDeleteBillExpense(data);
    } else {
        console.log("No IDs selected.");
    }
};
// create and update
const CreateDialogShow = (id) => {
    ExpenseRepository.billExpenseId = id;

    ExpenseRepository.billExpensesPayments = {};
    ExpenseRepository.setEditMode(false);
    ExpenseRepository.createDialog = true;
};
const ViewPaymentDialog = (item) => {
    console.log(item.id, "payment id");
    const expenseId = item.id;
    ExpenseRepository.paymentId = item.id;
    // ExpenseRepository.billExpensesPayments = {};
    // if (Object.keys(ExpenseRepository.billExpensesPayments).length === 0) {
    ExpenseRepository.FetchBillExpensesPayments(expenseId)
        .then(() => {
            ExpenseRepository.ShowExpensePayment = true;
        })
        .catch((error) => {
            console.error("Error fetching data: ", error);
        });
    // }
};

const deleteItem = async (item) => {
    await ExpenseRepository.DeleteBillExpense(item.id);
};
// header
const headers = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("date"), key: "date", align: "start", sortable: false },
    {
        title: t("reference"),
        key: "reference",
        align: "center",
        sortable: false,
    },
    { title: t("addedBy"), key: "addedBy", align: "center", sortable: false },
    {
        title: t("supplier"),
        key: "supplier.name",
        align: "center",
        sortable: false,
    },
    { title: t("amount"), key: "grandTotal", align: "center", sortable: false },
    { title: t("paid"), key: "paid", align: "center", sortable: false },
    { title: t("due"), key: "due", align: "center", sortable: false },

    { title: t("action"), key: "action", align: "center", sortable: false },
];
</script>

<style scoped>
.v-data-table-server {
    position: relative;
}
.header-button {
    position: absolute;
    top: 0.7rem;
    left: 0.7rem;
    z-index: 1;
}
</style>
