<template>
    <CreatePatients v-if="PeopleRepository.createDialog" />
    <div class="all-expense rounded-xl" :dir="dir">
        <div class="card rounded-xl">
            <AppBar :mainTitle="$t('patients')" :sub-title="$t('people')" />
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
                        v-model="PeopleRepository.patientSearch"
                    ></v-text-field>
                </div>
                <div class="btn d-flex">
                    <!-- ====================== -->
                    <v-btn
                        color="danger"
                        variant="outlined"
                        prepend-icon="mdi mdi-file"
                        class="px-6"
                        @click="exportDialog = true"
                    >
                        {{ t("PDF") }}
                    </v-btn>

                    <!-- Export Dialog -->
                    <v-dialog v-model="exportDialog" max-width="1200px">
                        <v-card>
                            <v-card-title class="text-h6">
                                {{ t("patients Report Preview") }}
                            </v-card-title>

                            <v-card-text>
                                <!-- This is the visible preview inside dialog -->
                                <Export
                                    ref="exportRef"
                                    :table-data="flattenedExpenses"
                                    :fields="{
                                        name: t('name'),
                                        phone: t('phone'),
                                        address: t('address'),
                                        dateOfBirth: t('dateOfBirth'),
                                        gender: t('gender'),
                                    }"
                                    file-name="Patients Report"
                                    btn-color="primary"
                                    :show-button="false"
                                />
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer />
                                <v-btn @click="exportDialog = false">{{
                                    t("Close")
                                }}</v-btn>
                                <v-btn color="primary" @click="downloadPDF">
                                    {{ t("Download PDF") }}
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                    <!-- ==================== -->
                    &nbsp;
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
                            <v-col
                                id="pdf-section"
                                ref="pdfTable"
                                class="export-table"
                            >
                                <v-data-table-server
                                    :dir="dir"
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        PeopleRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="PeopleRepository.totalItems"
                                    :items="PeopleRepository.patients"
                                    :loading="PeopleRepository.loading"
                                    :search="PeopleRepository.patientSearch"
                                    @update:options="
                                        PeopleRepository.fetchPatients
                                    "
                                    :item-key="PeopleRepository.patients"
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
                                    <template v-slot:item.printBtn="{ item }">
                                        <v-btn
                                            color="primaryOld"
                                            :text="$t('print')"
                                            @click="generatePDF(item)"
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
                                            <!--  -->
                                            <v-list>
                                                <v-list-item>
                                                    <router-link
                                                        :to="
                                                            '/viewPatients/' +
                                                            item.id
                                                        "
                                                    >
                                                        <v-list-item-title
                                                            @click="
                                                                showId(item)
                                                            "
                                                            class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        >
                                                            <v-icon
                                                                color="tealColor"
                                                                >mdi-eye-outline</v-icon
                                                            >
                                                            {{ t("view") }}
                                                        </v-list-item-title>
                                                    </router-link>
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
import { ref, onMounted, computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreatePatients from "./CreatePatients.vue";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { usePeopleRepository } from "@/store/PeopleRepository";
const PeopleRepository = usePeopleRepository();
import Export from "../../../components/ExportComponent.vue";

// ===================
import html2pdf from "html2pdf.js";
import PrintPatient from "./PrintPatient.vue";
import { createApp, h } from "vue";
// const generatePDF = (patient) => {
//     const container = document.createElement("div");
//     document.body.appendChild(container);

//     let componentInstance = null;

//     const app = createApp({
//         render() {
//             return h(PrintPatient, {
//                 patient,
//                 ref: (el) => {
//                     componentInstance = el;
//                 },
//             });
//         },
//     });

//     app.mount(container);

//     // Wait a bit for rendering
//     setTimeout(() => {
//         if (componentInstance?.printContent) {
//             html2pdf()
//                 .set({
//                     margin: 0.5,
//                     filename: `${patient.name}_form.pdf`,
//                     image: { type: "jpeg", quality: 0.98 },
//                     html2canvas: { scale: 2 },
//                     jsPDF: { unit: "in", format: "a4", orientation: "portrait" },
//                 })
//                 .from(componentInstance.printContent)
//                 .save()
//                 .then(() => {
//                     app.unmount();
//                     container.remove();
//                 });
//         } else {
//             console.error("printContent not found");
//             app.unmount();
//             container.remove();
//         }
//     }, 500);
// };
// ==========================
// direction

// ==============
const generatePDF = (patient) => {
    const container = document.createElement("div");
    document.body.appendChild(container);

    let componentInstance = null;

    const app = createApp({
        render() {
            return h(PrintPatient, {
                patient,
                ref: (el) => {
                    componentInstance = el;
                },
            });
        },
    });

    app.mount(container);

    // Wait for rendering
    setTimeout(() => {
        if (componentInstance?.printContent) {
            html2pdf()
                .set({
                    margin: 0.5,
                    filename: `${patient.name}_form.pdf`,
                    image: { type: "jpeg", quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: "in", format: "a4", orientation: "portrait" },
                })
                .from(componentInstance.printContent)
                .output('bloburl') 
                .then((pdfUrl) => {
                    const printWindow = window.open(pdfUrl);
                    if (printWindow) {
                        printWindow.onload = () => {
                            printWindow.focus();
                            printWindow.print();
                        };
                    }
                    // Clean up
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

// ===================
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; 
});

// export component

const exportDialog = ref(false);
const exportRef = ref(null);

// Data you are exporting
const flattenedExpenses = computed(() =>
    PeopleRepository.patients.map((item) => ({
        name: item.name,
        phone: item.phone,
        address: item.address,
        dateOfBirth: item.dateOfBirth,
        gender: item.gender,
    }))
);

// Trigger PDF download from the child component
const downloadPDF = () => {
    exportRef.value?.exportToPDF?.();
};
// ===================
// bulk delete
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            expenseIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        PeopleRepository.bulkDeletePatient(data);
    } else {
        console.log("No IDs selected.");
    }
};
const showId = (item) => {
    PeopleRepository.patientIdForView = item.id;
    PeopleRepository.FetchPeopleAccounts(
        { page: 1, itemsPerPage: 10 },
        item.id
    );
};

// delete and update Create
const CreateDialogShow = () => {
    PeopleRepository.isEditMode = false;
    PeopleRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    PeopleRepository.setEditMode(true);
    PeopleRepository.patient = {};
    if (Object.keys(PeopleRepository.patient).length === 0) {
        PeopleRepository.fetchPatient(item.id)
            .then(() => {
                PeopleRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await PeopleRepository.DeletePatient(item.id);
};
// header
const headers = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("name"), key: "name", align: "start", sortable: false },
    { title: t("phone"), key: "phone", align: "start", sortable: false },
    { title: t("address"), key: "address", align: "start", sortable: false },
    { title: t("age"), key: "dateOfBirth", align: "center", sortable: false },
    { title: t("gender"), key: "gender", align: "center", sortable: false },
    { title: t("print"), key: "printBtn", align: "center", sortable: false },

    { title: t("action"), key: "action", align: "center", sortable: false },
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
