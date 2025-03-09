<template>
    <CreateMoneyAcc v-if="SettingRepository.createDialog" />
    <TransferAccount v-if="SettingRepository.transferDialog" />

    <div>
        <AppBar mainTitle="Money Account" sub-title="setting" />
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
                    v-model="SettingRepository.moneyAccSearch"
                ></v-text-field>
            </div>
            <div class="btn">
                <v-btn
                    @click="CreateTransfer"
                    variant="outlined"
                    color="primaryOld"
                    class="px-6"
                >
                    Transfer
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
                                    SettingRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="SettingRepository.totalItems"
                                :items="SettingRepository.moneyAccs"
                                :loading="SettingRepository.loading"
                                :search="SettingRepository.moneyAccSearch"
                                @update:options="
                                    SettingRepository.fetchMoneyAccounts
                                "
                                :item-key="SettingRepository.moneyAccs"
                                hover
                                class="w-100 mx-auto"
                            >
                                <!-- Checkbox for selecting rows -->

                                <template v-slot:item.action="{ item }">
                                    <v-menu>
                                        <template v-slot:activator="{ props }">
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
                                                    <v-icon color="tealColor"
                                                        >mdi-square-edit-outline</v-icon
                                                    >
                                                    Edit
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    class="cursor-pointer d-flex gap-3"
                                                    @click="deleteItem(item)"
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
                        </v-col>
                    </v-row>
                </v-main>
            </v-app>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateMoneyAcc from "./CreateMoneyAcc.vue";
import TransferAccount from "../Transfar account/TransferAccount.vue";
import { useSettingRepository } from "@/store/SettingRepository";
const SettingRepository = useSettingRepository();

// delete and update Create
const CreateDialogShow = () => {
    SettingRepository.moneyAcc = {};
    // SettingRepository.setEditMode(false);
    SettingRepository.isEditMode = false;
    SettingRepository.createDialog = true;
};
const CreateTransfer = () => {
    SettingRepository.transferDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    // SettingRepository.setEditMode(true);
    SettingRepository.isEditMode = true;
    SettingRepository.moneyAcc = {};
    if (Object.keys(SettingRepository.moneyAcc).length === 0) {
        SettingRepository.fetchMoneyAcc(item.id)
            .then(() => {
                SettingRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await SettingRepository.DeleteMoneyAcc(item.id);
};
// header
const headers = [
    { title: "Name", key: "name", align: "start", sortable: false },
    { title: "Balance", key: "balance", align: "start", sortable: false },
    { title: "Action", key: "action", align: "end", sortable: false },
];
</script>
