<template>
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar mainTitle="Expense" sub-title="expense" />
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
                        label="Search ..."
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="ExpenseRepository.ExpenseSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        Filter
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click="CreateDialogShow"
                        color="primaryOld"
                        variant="flat"
                        text="Create"
                        class="px-6"
                    >
                    </v-btn>
                </div>
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        ExpenseRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ExpenseRepository.totalItems"
                                    :items="ExpenseRepository.Expenses"
                                    :loading="ExpenseRepository.loading"
                                    :search="ExpenseRepository.ExpenseSearch"
                                    @update:options="
                                        ExpenseRepository.fetchExpensesData
                                    "
                                    :item-key="ExpenseRepository.Expenses"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Checkbox for selecting rows -->

                                    <template v-slot:item.checkbox="{ item }">
                                        <v-checkbox
                                            :value="item.id"
                                            v-model="selectedIds"
                                            class="w-1 d-flex"
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
                                                        @click="edit(item)"
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        Edit
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item)
                                                        "
                                                    >
                                                        <v-icon color="error"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        Delete
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
                                    small
                                    flat
                                >
                                    حذف
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
import { ref, onMounted } from "vue";
import AppBar from "../../../components/AppBar.vue";
import { useExpenseRepository } from "@/store/ExpenseRepository";
const ExpenseRepository = useExpenseRepository();
// delete and update
const deleteItem = async (item) => {
    await ExpenseRepository.DeleteExpense(item.id);
};

const selectedIds = ref([]);

const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        // Create a simple object with the selected IDs
        const data = {
            earningIds: selectedIds.value,
        };

        // Log the object to verify
        console.log("Sending data:", data);

        // Send the object to the backend
        EarningRepository.bulkDeleteExpense(data);
    } else {
        console.log("No IDs selected.");
    }
};
// const dataTable = ref(null);

// onMounted(() => {
//     // Access the DOM element containing the "items per page" text
//     const paginationText = dataTable.value.$el.querySelector(
//         ".v-data-table-footer .v-data-table-footer__items-per-page span"
//     );

//     if (paginationText) {
//         paginationText.textContent = "سطر در هر صفحه"; // Change to Dari
//     }
// });

const headers = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: "Date", key: "date", align: "start", sortable: false },
    { title: "Reference", key: "reference", align: "center", sortable: false },
    { title: "Added By", key: "addedBy", align: "center", sortable: false },
    {
        title: "Category",
        key: "expenseCategory.name",
        align: "center",
        sortable: false,
    },
    { title: "Amount", key: "amount", align: "center", sortable: false },
    { title: "Action", key: "action", align: "center", sortable: false },
];

const CreateDialogShow = () => {
    ExpenseRepository.createDialog = true;
};

const edit = (item) => {
    ExpenseRepository.Expense = {};
    if (Object.keys(ExpenseRepository.Expense).length === 0) {
        ExpenseRepository.fetchExpense(item.id)
            .then(() => {
                ExpenseRepository.updateDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};
</script>

<style scoped>
.v-data-table-server {
    position: relative; /* Required for absolute positioning of the button */
}
.header-button {
    position: absolute;
    top: 0.7rem; /* Adjust to place the button correctly */
    left: 0.7rem; /* Adjust to align with the checkbox column */
    z-index: 1;
}
</style>
