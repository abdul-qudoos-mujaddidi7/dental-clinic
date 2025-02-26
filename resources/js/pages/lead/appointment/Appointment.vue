<template>
    <CreateAppointment v-if="LeadRepository.createDialog" />
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar mainTitle="Appointment" sub-title="appointment" />
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
                        v-model="LeadRepository.appointmentSearch"
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
                                    :items="LeadRepository.appointments"
                                    :loading="LeadRepository.loading"
                                    :search="LeadRepository.appointmentSearch"
                                    @update:options="
                                        LeadRepository.FetchAppointments
                                    "
                                    :item-key="LeadRepository.appointments"
                                    hover
                                    class="w-100 mx-auto"
                                >
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
// import CreateOwner from "./CreateOwner.vue";
import CreateAppointment from "./CreateAppointment.vue";
import { useLeadRepository } from "@/store/LeadRepository";
const LeadRepository = useLeadRepository();
// bulk delete

// delete and update Create
const CreateDialogShow = () => {
    LeadRepository.appointment = {},
    LeadRepository.isEditMode=false;
    LeadRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    LeadRepository.isEditMode=true;
    LeadRepository.appointment = {};
    if (Object.keys(LeadRepository.appointment).length === 0) {
        LeadRepository.fetchAppointment(item.id)
            .then(() => {
                LeadRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await LeadRepository.DeleteAppointment(item.id);
};
// header
const headers = [
    { title: "Patient", key: "patients.name", align: "start", sortable: false },
    { title: "Doctor", key: "dentists.name", align: "start", sortable: false },
    { title: "Date", key: "date", align: "start", sortable: false },
    { title: "Added By", key: "userName", align: "start", sortable: false },
    { title: "Time", key: "time", align: "start", sortable: false },
    { title: "Status", key: "status", align: "start", sortable: false },
    { title: "Action ", key: "action", align: "end", sortable: false },
];
</script>
