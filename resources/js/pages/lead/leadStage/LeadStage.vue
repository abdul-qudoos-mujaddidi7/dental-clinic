<template>
    <CreateStage v-if="LeadRepository.createDialog" />
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar mainTitle="Lead stages" sub-title="lead" />
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
                        v-model="LeadRepository.stageSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{$t('filter')}}
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click="CreateDialogShow"
                        color="primaryOld"
                        variant="flat"
                        :text="$t('create')"
                        class="px-6"
                    >
                    </v-btn>
                </div>
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden" :location="location">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        LeadRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="LeadRepository.totalItems"
                                    :items="LeadRepository.stages"
                                    :loading="LeadRepository.loading"
                                    :search="LeadRepository.stageSearch"
                                    @update:options="
                                        LeadRepository.FetchStages
                                    "
                                    :item-key="LeadRepository.stages"
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
                                                    <v-list-item-title
                                                        @click="edit(item)"
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        {{$t('edit')}}
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
                                                        {{$t('delete')}}
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
import { ref } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateStage from "./CreateStage.vue";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
import { useLeadRepository } from "@/store/LeadRepository";
const LeadRepository = useLeadRepository();
// delete and update Create
const CreateDialogShow = () => {
    LeadRepository.stage = {};
    // LeadRepository.setEditMode(false);
    LeadRepository.isEditMode=false;
    LeadRepository.createDialog = true;
};




const edit = (item) => {
    console.log(item, "me");
    // LeadRepository.setEditMode(true);
    LeadRepository.isEditMode = true;
    LeadRepository.stage = {};
    if (Object.keys(LeadRepository.stage).length === 0) {
        LeadRepository.FetchStage(item.id)
            .then(() => {
                LeadRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await LeadRepository.DeleteStage(item.id);
};
// header
const headers = [

    { title: t("name"), key: "name", align: "center", sortable: false },
    { title: t('leads'), key: "leads", align: "center", sortable: false },
    { title: t("action"), key: "action", align: "end", sortable: false },
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
