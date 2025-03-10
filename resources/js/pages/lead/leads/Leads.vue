<template>
    <CreateLeads v-if="LeadRepository.createDialog" />
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar mainTitle="leads" sub-title="Lead" />
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
                        v-model="LeadRepository.leadSearch"
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
                        :text="$t('create')"
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
                                    v-model:items-per-page="LeadRepository.itemsPerPage"
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
                                        <td class="py-2 pl-4">
                                            <v-btn
                                                flat
                                                fluid
                                                rounded
                                                @click="
                                                    changeStage(
                                                        item.id,
                                                        item.stage.id
                                                    )
                                                "
                                                :style="{
                                                    backgroundColor:
                                                        getStageColor(item.id),
                                                }"
                                                class="text-white px-4 py-2"
                                            >
                                                <span
                                                    class="text-[10px] tracking-wide"
                                                >
                                                    {{ item.stage.name }}
                                                </span>
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
                                                        {{ $t("edit") }}
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
                                                        {{ $t("delete") }}
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
                                    inset
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
import { ref, computed, reactive } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateLeads from "./CreateLeads.vue";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useLeadRepository } from "@/store/LeadRepository";
const LeadRepository = useLeadRepository();
// swap function

const stageIndexes = ref({}); // Track individual indexes for each item

// Computed property to get the current stage name for each item based on its ID
const getStageName = (itemId) => {
    const leadStage = LeadRepository.leadStageFor;
    if (
        !leadStage ||
        leadStage.length === 0 ||
        stageIndexes.value[itemId] === undefined
    ) {
        return "...";
    }
    const currentIndex = stageIndexes.value[itemId] % leadStage.length;
    return leadStage[currentIndex]?.name || "...";
};



// Function to get button color based on stage name
const getStageColor = (itemId) => {
    const item = LeadRepository.leads.find((lead) => lead.id === itemId);
    console.log(item);
    if (!item || !item.stage) return "#112F53"; // Default color
    if (item.stage.name) {
        switch (item.stage.name.toLowerCase()) {
            case "new":
                return "#00893F";
            case "on going":
                return "#0080FF";
            case "completed":
                return "#3C3C54";
            default:
                return "#112F53";
        }
    } else {
        return "#112F53";
    }
};

// Method to change the stage for a specific item and update the backend
const changeStage = async (itemId, currentStageId) => {
    const leadStage = LeadRepository.leadStageFor;
    if (!leadStage || leadStage.length === 0) return;

    // Find the index of the current stage
    const currentIndex = leadStage.findIndex(
        (stage) => stage.id === currentStageId
    );

    // Cycle to the next stage
    const nextIndex = (currentIndex + 1) % leadStage.length;
    const nextStage = leadStage[nextIndex];

    const formData = reactive({
        stageId: nextStage.id,
    });

    try {
        // Update backend
        await LeadRepository.UpdateLeadStages(itemId, formData);

        // Reflect the change in UI by updating the item's stage locally
        const item = LeadRepository.leads.find((lead) => lead.id === itemId);
        if (item) {
            item.stage = nextStage;
        }

        console.log(`Stage for item ${itemId} updated to: ${nextStage.name}`);
    } catch (error) {
        console.error(`Error updating stage for item ${itemId}:`, error);
    }
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
    // LeadRepository.setEditMode(false);
    LeadRepository.isEditMode = false;

    LeadRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    // LeadRepository.setEditMode(true);
    LeadRepository.isEditMode = true;

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
const headers = computed(() => {
  const baseHeaders = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("name"), key: "name", align: t('style'), sortable: false },
    { title: t("phone"), key: "phone", align: t('style'), sortable: false },
    {
      title: t("category"),
      key: "category.name",
      align: "start",
      sortable: false,
    },
    { title: t("status"), key: "stage", align: "center", sortable: false },
    { title: t("address"), key: "address", align: t('style'), sortable: false },
    { title: t("details"), key: "note", align: t('style'), sortable: false },
    { title: t("action"), key: "action", align: "center", sortable: false },
  ];

  // Reverse the headers when the language is Farsi (assuming 'fa' is the Farsi language code)
  if (locale.value === "fa") {
    return [...baseHeaders].reverse(); // Reverse the order for Farsi
  }
  return baseHeaders;
});

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
