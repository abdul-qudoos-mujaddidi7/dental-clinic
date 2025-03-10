<template>
    <CreateExpense v-if="ExpenseRepository.createDialog" />
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar :mainTitle="$t('expenses')" :sub-title="$t('expense')" />
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
                        :label="t('search')"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="ExpenseRepository.ExpenseSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click="CreateDialogShow"
                        color="primaryOld"
                        variant="flat"
                        :text="t('create')"
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
                                            class="w-6 d-flex"
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
                                                        {{ t("edit") }}
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
                                    flat
                                    text="delete"
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
import { ref, onMounted ,computed} from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateExpense from "./CreateExpense.vue";
import { useExpenseRepository } from "@/store/ExpenseRepository";
const ExpenseRepository = useExpenseRepository();
// bulk delete
import { useI18n } from "vue-i18n";
const {t} = useI18n();
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            expenseIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        ExpenseRepository.bulkDeleteExpense(data);
    } else {
        console.log("No IDs selected.");
    }
};

// delete and update Create
const CreateDialogShow = () => {
    ExpenseRepository.Expenses = {};
    ExpenseRepository.Expense = {};
    ExpenseRepository.setEditMode(false);
    ExpenseRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    ExpenseRepository.setEditMode(true);
    ExpenseRepository.Expense = {};
    if (Object.keys(ExpenseRepository.Expense).length === 0) {
        ExpenseRepository.fetchExpense(item.id)
            .then(() => {
                ExpenseRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await ExpenseRepository.DeleteExpense(item.id);
};
// header
const headers = computed(()=>[
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("date"), key: "date", align: "start", sortable: false },
    { title: t("reference"), key: "reference", align: "center", sortable: false },
    { title: t("addedBy"), key: "addedBy", align: "center", sortable: false },
    {
        title: t("category"),
        key: "expenseCategory.name",
        align: "center",
        sortable: false,
    },
    { title: t("amount"), key: "amount", align: "center", sortable: false },
    { title: t("action"), key: "action", align: "center", sortable: false },
])
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
