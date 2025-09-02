<template>
    <CreateAppointment v-if="LeadRepository.createDialog" />
    <div class="all-expense rounded-xl" :dir="dir">
        <div class="card rounded-xl">
            <AppBar
                :mainTitle="$t('appointment')"
                :sub-title="$t('appointment')"
            />
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
                        v-model="LeadRepository.appointmentSearch"
                    ></v-text-field>
                </div>
                <div class="btn d-flex">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ $t("filter") }}
                    </v-btn>
                    &nbsp;
                    <div
                        
                    >
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
            </div>

            <!-- v-table server -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    :dir="dir"
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
                                    <template v-slot:item.printBtn="{ item }">
                                        <v-btn
                                            color="primaryOld"
                                            @click="
                                                generateAppointmentPrint(
                                                    item
                                                )
                                            "
                                        >
                                            {{ $t("print") }}
                                        </v-btn>
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
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
    <PrintAppointment
        v-if="showPrint"
        :appointment="selectedAppointment"
        @close="showPrint = false"
    />
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateAppointment from "./CreateAppointment.vue";
import { useLeadRepository } from "@/store/LeadRepository";
import { useAuthRepository } from "../../../store/AuthRepository";
const AuthRepository = useAuthRepository();

import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
const LeadRepository = useLeadRepository();
import PrintAppointment from "./PrintAppointment.vue";
const showPrint = ref(false);
const selectedAppointment = ref(null);
import { createApp, h } from "vue";
import html2pdf from "html2pdf.js";


const generateAppointmentPrint = async (appointment) => {
    if (!appointment) {
        console.error("Appointment not found!");
        return;
    }

    const container = document.createElement("div");
    document.body.appendChild(container);

    let componentInstance = null;

    const app = createApp({
        render() {
            return h(PrintAppointment, {
                appointment: appointment,
                ref: (el) => {
                    componentInstance = el;
                },
            });
        },
    });

    app.mount(container);

    setTimeout(() => {
        if (componentInstance?.printContent) {
            html2pdf()
                .set({
                    margin: 0.5,
                    filename: `${appointment.patients?.name || "appointment"}_detail.pdf`,
                    image: { type: "jpeg", quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: {
                        unit: "in",
                        format: "a4",
                        orientation: "portrait",
                    },
                })
                .from(componentInstance.printContent)
                .output("bloburl")
                .then((pdfUrl) => {
                    const printWindow = window.open(pdfUrl);
                    if (printWindow) {
                        printWindow.onload = () => {
                            printWindow.focus();
                            printWindow.print();
                        };
                    }
                    app.unmount();
                    container.remove();
                });
        } else {
            console.error("printContent not found");
            app.unmount();
            container.remove();
        }
    }, 500);
};

// bulk delete

// delete and update Create
const CreateDialogShow = () => {
    LeadRepository.appointment = {};
    LeadRepository.isEditMode = false;
    LeadRepository.createDialog = true;
};

const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

const edit = (item) => {
    console.log(item, "me");
    LeadRepository.isEditMode = true;
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
    {
        title: t("patient"),
        key: "patients.name",
        align: "start",
        sortable: false,
    },
    {
        title: t("doctor"),
        key: "dentists.name",
        align: "start",
        sortable: false,
    },
    { title: t("date"), key: "date", align: "start", sortable: false },
    { title: t("addedBy"), key: "userName", align: "start", sortable: false },
    { title: t("time"), key: "time", align: "start", sortable: false },
    { title: t("status"), key: "status", align: "start", sortable: false },
    { title: t("print"), key: "printBtn", align: "center", sortable: false },
    { title: t("action"), key: "action", align: "end", sortable: false },
];
</script>
