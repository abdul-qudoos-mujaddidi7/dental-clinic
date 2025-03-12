<template>
    <div class="all-expense rounded-xl" :dir="dir">
        <div class="card rounded-xl">
            <AppBar :mainTitle="$t('rolePermission')" :sub-title="$t('setting')"  />
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
                        v-model="SettingRepository.permissionSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <router-link to="/createPermissions">
                        <v-btn
                            @click="CreateDialogShow"
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
                    <v-main class="main" :dir="dir">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                :class="
                                        dir === 'rtl'
                                            ? 'rtl-border'
                                            : 'ltr-border'
                                    "
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        SettingRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="SettingRepository.totalItems"
                                    :items="SettingRepository.permissions"
                                    :loading="SettingRepository.loading"
                                    :search="SettingRepository.permissionSearch"
                                    @update:options="
                                        SettingRepository.fetchRolePermissions
                                    "
                                    :item-key="SettingRepository.permissions"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Checkbox for selecting rows -->

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
                                                    <router-link
                                                        :to="
                                                            '/updatePermissions/' +
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
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref,computed } from "vue";
import AppBar from "../../../components/AppBar.vue";

import { useSettingRepository } from "@/store/SettingRepository";
const SettingRepository = useSettingRepository();
import { useI18n } from "vue-i18n";
const { t,locale } = useI18n();

// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

// delete and update Create
const CreateDialogShow = () => {
    SettingRepository.permission = {};
    SettingRepository.setEditMode(false);
    SettingRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    SettingRepository.setEditMode(true);
    SettingRepository.permission = {};
    if (Object.keys(SettingRepository.permission).length === 0) {
        SettingRepository.fetchRolePermission(item.id)
            .then(() => {
                SettingRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await SettingRepository.DeleteRolePermission(item.id);
};
// header
const headers = [
    { title: t("name"), key: "name", align: "center", sortable: false },
    {
        title: t("details"),
        key: "description",
        align: "center",
        sortable: false,
    },
    { title: t("action"), key: "action", align: "end", sortable: false },
];
</script>

<style scoped></style>
