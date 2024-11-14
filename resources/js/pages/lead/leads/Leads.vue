<template>
    <CreateLeads v-if="LeadRepository.createDialog" />
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar mainTitle="Owner Pickups" sub-title="people" />
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
                        v-model="LeadRepository.leadSearch"
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
                                        LeadRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="LeadRepository.totalItems"
                                    :items="LeadRepository.leads"
                                    :loading="LeadRepository.loading"
                                    :search="LeadRepository.leadSearch"
                                    @update:options="LeadRepository.FetchLeads"
                                    :item-key="LeadRepository.leads"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <template v-slot:item.stage="{ item }">
                                        <td class="px-4 py-2 font-semibold">
                                            <v-btn
                                                flat
                                                fluid
                                                @click="changeCurrency"
                                                :style="{
                                                    backgroundColor: 'gray',
                                                    color: 'white',
                                                }"
                                            >
                                                <p class="text-gray-200">
                                                    {{
                                                        currentCurrencySymbol.name
                                                    }}
                                                </p>
                                            </v-btn>
                                        </td>
                                    </template>
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
import { ref, computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateLeads from "./CreateLeads.vue";
import { useLeadRepository } from "@/store/LeadRepository";
const LeadRepository = useLeadRepository();
// swap function
const currencyIndex = ref(0);

const currentCurrencySymbol = computed(() => {
    const leadStage = LeadRepository.leadStageFor;
    if (!leadStage || leadStage.length === 0) {
        return { name: "...", id: null };
    }
    if (currencyIndex.value >= leadStage.length) {
        currencyIndex.value = 0;
    }
    LeadRepository.leadStageFor = leadStage[currencyIndex.value]?.id;

    return {
        name: leadStage[currencyIndex.value]?.name,
        id: leadStage[currencyIndex.value]?.id,
    };
});
let Stage = [];
const changeCurrency = () => {
    Stage = leadStage;
    console.log(currencyIndex, Stage, "chia tyt");
    currencyIndex.value = (currencyIndex.value + 1) % Stage.length;
};
// bulk delete
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            leadsIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        LeadRepository.bulkDeleteLead(data);
    } else {
        console.log("No IDs selected.");
    }
};

// delete and update Create
const CreateDialogShow = () => {
    LeadRepository.lead = {};
    LeadRepository.setEditMode(false);
    LeadRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    LeadRepository.setEditMode(true);
    LeadRepository.lead = {};
    if (Object.keys(LeadRepository.lead).length === 0) {
        LeadRepository.FetchLead(item.id)
            .then(() => {
                LeadRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await LeadRepository.DeleteLead(item.id);
};
// header
const headers = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: "Name", key: "name", align: "start", sortable: false },
    { title: "Phone", key: "phone", align: "start", sortable: false },
    {
        title: "Category",
        key: "category.name",
        align: "start",
        sortable: false,
    },
    { title: "Status", key: "stage", align: "start", sortable: false },
    { title: "Address", key: "address", align: "start", sortable: false },
    { title: "Details", key: "note", align: "start", sortable: false },
    { title: "Action", key: "action", align: "center", sortable: false },
];
LeadRepository.leadStages();
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
