<template>
    <CreatePatients v-if="ReportRepository.createDialog" />
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar mainTitle="Service Report" sub-title="report" />
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
                        v-model="ReportRepository.serviceReportSearch"
                    ></v-text-field>
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
                                        ReportRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ReportRepository.totalItems"
                                    :items="ReportRepository.serviceReport"
                                    :loading="ReportRepository.loading"
                                    :search="
                                        ReportRepository.serviceReportSearch
                                    "
                                    @update:options="
                                        ReportRepository.fetchServiceReports
                                    "
                                    :item-key="ReportRepository.serviceReport"
                                    hover
                                    class="w-100 mx-auto"
                                >
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
import { useReportRepository } from "@/store/ReportRepository";
const ReportRepository = useReportRepository();

// header
const headers = [
    { title: "Service Name", key: "name", align: "start", sortable: false },
    { title: "Used", key: "totalApplied", align: "start", sortable: false },
    // { title: "Amount", key: "Amount", align: "start", sortable: false },
    // { title: "Amount", key: "idk", align: "start", sortable: false },
];
</script>
