<template>
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl" :dir="dir">
          
            <AppBar :mainTitle="$t('outboundLaboratory')" :sub-title="$t('outboundLaboratory')" />

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
                        v-model="PeopleRepository.laboratorySearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <router-link to="createLab">
                        <v-btn
                            color="primaryOld"
                            variant="flat"
                            :text="t('create')"

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
                                        PeopleRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="PeopleRepository.totalItems"
                                    :items="PeopleRepository.laboratories"
                                    :loading="PeopleRepository.loading"
                                    :search="PeopleRepository.laboratorySearch"
                                    @update:options="
                                        PeopleRepository.FetchLaboratories
                                    "
                                    :item-key="PeopleRepository.laboratories"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                <template v-slot:item.details="{ item }">
                                        <span v-if="item.details && item.details.length">{{ item.details[0].toothName }}</span>
                                        <span v-else>N/A</span>
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
                                                    <router-link
                                                        :to="
                                                            '/updateLab/' +
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
import { ref, onMounted,computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import { useI18n } from "vue-i18n";
const { t,locale } = useI18n();

import { usePeopleRepository } from "@/store/PeopleRepository";
const PeopleRepository = usePeopleRepository();
// bulk delete

// delete and update Create
const CreateDialogShow = () => {
    (PeopleRepository.laboratory = {}), PeopleRepository.setEditMode(false);
    PeopleRepository.createDialog = true;
    PeopleRepository.labId = id;
};

// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});


// const edit = (item) => {
//     console.log(item, "me");
//     PeopleRepository.setEditMode(true);
//     PeopleRepository.laboratory = {};
//     if (Object.keys(PeopleRepository.laboratory).length === 0) {
//         PeopleRepository.FetchLaboratory(item.id)
//             .then(() => {
//                 PeopleRepository.createDialog = true;
//             })
//             .catch((error) => {
//                 console.error("Error fetching data:", error);
//             });
//     }
// };

const deleteItem = async (item) => {
    await PeopleRepository.DeleteLaboratory(item.id);
};
// header
const headers = [

    { title: t("issueAt"), key: "issueAt", align: "start", sortable: false },

    {
        title: t("returnDate"),
        key: "returnDate",
        align: "start",
        sortable: false,
    },
    {
        title: t("grandTotal"),
        key: "grandTotal",
        align: "start",
        sortable: false,
    },
    { title: t("paid"), key: "paid", align: "start", sortable: false },
    { title: t("status"), key: "status", align: "start", sortable: false },
    { title: t("details"), key: "description", align: "start", sortable: false },
    { title: t("action"), key: "action", align: "end", sortable: false },
];
</script>
