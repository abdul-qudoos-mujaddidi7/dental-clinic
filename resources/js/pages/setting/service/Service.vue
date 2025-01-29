<template>
    <CreatesService v-if="SettingRepository.createDialog" />
    <div>
        <AppBar mainTitle="Service" sub-title="setting" />
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
                    v-model="SettingRepository.serviceSearch"
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
                                    SettingRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="SettingRepository.totalItems"
                                :items="SettingRepository.services"
                                :loading="SettingRepository.loading"
                                :search="SettingRepository.serviceSearch"
                                @update:options="
                                    SettingRepository.FetchServices
                                "
                                :item-key="SettingRepository.services"
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
import CreatesService from "./CreatesService.vue";
import { useSettingRepository } from "@/store/SettingRepository";
const SettingRepository = useSettingRepository();
// delete and update Create
const CreateDialogShow = () => {
    SettingRepository.service = {};
    // SettingRepository.setEditMode(false);
    SettingRepository.isEditMode=false;
    SettingRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    // SettingRepository.setEditMode(true);
    SettingRepository.isEditMode=true
    SettingRepository.service = {};
    if (Object.keys(SettingRepository.service).length === 0) {
        SettingRepository.fetchService(item.id)
            .then(() => {
                SettingRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await SettingRepository.DeleteService(item.id);
};
// header
const headers = [
    { title: "Name", key: "name", align: "center", sortable: false },
    { title: "Details", key: "description", align: "center", sortable: false },
    { title: "Action", key: "action", align: "end", sortable: false },
];
</script>
