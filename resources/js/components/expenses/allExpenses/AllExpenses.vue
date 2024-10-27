<template>
    <CreateAllExpense v-if="ExpenseRepository.createDialog" />
    <UpdateAllExpense v-if="ExpenseRepository.updateDialog" />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <Menu mainTitle="مصارف" sub-title=" مصارف بدون بل" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>

            <div class="btn-search pt-12 pb-6">
                <div class="text-field">
                    <v-text-field
                        :loading="loading"
                        color="#D3E2F8"
                        density="compact"
                        variant="outlined"
                        label="جستجو"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        dir="rtl"
                        v-model="ExpenseRepository.ExpenseSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="#112F53"
                        >&nbsp; &nbsp; فیلتر &nbsp; &nbsp;</v-btn
                    >
                    &nbsp;
                    <v-btn
                    
                        @click="CreateDialogShow"
                        color="#112F53"
                        variant="flat"
                    >
                        &nbsp; &nbsp; ایجاد &nbsp; &nbsp;</v-btn
                    >
                </div>
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    ref="dataTable"
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
                                            class="d-flex justify-end"
                                        ></v-checkbox>
                                    </template>

                                    <template
                                        v-slot:item.action="{ item }"
                           
                                    >
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
                                                        <v-icon color="gray"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        ویرایش
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                  
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item)
                                                        "
                                                    >
                                                        <v-icon color="gray"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        حذف
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
import { useExpenseRepository } from "@/store/ExpenseRepository";
// import { useAuthRepository } from "@/store/AuthRepository";

// ignore
// import CreateAllExpense from "./createallexpense.vue";
// import UpdateAllExpense from "./UpdateAllExpense.vue";
// import Menu from "../../components/UI/Menu.vue";

const ExpenseRepository = useExpenseRepository();
// const AuthRepository = useAuthRepository();

// delete and update
const deleteItem = async (item) => {
    await ExpenseRepository.DeleteExpense(item.id);
};


const selectedIds = ref([]); // Array to store selected row IDs

// Function to send selected IDs to backend
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
const dataTable = ref(null);

onMounted(() => {
    // Access the DOM element containing the "items per page" text
    const paginationText = dataTable.value.$el.querySelector(
        ".v-data-table-footer .v-data-table-footer__items-per-page span"
    );

    if (paginationText) {
        paginationText.textContent = "سطر در هر صفحه"; // Change to Dari
    }
});

const headers = [
    { title: "عمل", key: "action", align: "center", sortable: false },
    {
        title: "جزئيات",
        align: "center",
        sortable: false,
        key: "note",
    },
 
    { title: "مقدار", key: "amount", align: "center", sortable: false },
    { title: "خریداری شده توسط ", key: "people.name", align: "center", sortable: false },

    {
        title: "دسته‌بندی ",
        key: "expenseCategory.name",
        align: "center",
        sortable: false,
    },
    {
        title: "ایجاد شده توسط",
        key: "addedBy.name",
        align: "center",
        sortable: false,
    },
    { title: "کد مرجع ", key: "reference", align: "center", sortable: false },
    // { title: "  عرضه کننده", key: "supplier.name", align: "center", sortable: false },
    { title: "تاریخ خریداری ", key: "date", align: "center", sortable: false },
    { title: "تاریخ ثبت", key: "recordDate", align: "center", sortable: false },
    { title: "", key: "checkbox", align: "center", sortable: false },
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
    top: .7rem; /* Adjust to place the button correctly */
    right: 1.4rem; /* Adjust to align with the checkbox column */
    z-index: 1;
}
.card {
    /* background-color: green; */
    margin: 1.4rem;
    padding: 1.4rem;
}
.all-expense {
    width: 83.2%;
}
</style>
