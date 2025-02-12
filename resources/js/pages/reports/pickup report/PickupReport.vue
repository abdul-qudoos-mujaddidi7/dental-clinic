<template>
    <CreatePatients v-if="ReportRepository.createDialog" />
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
                        v-model="ReportRepository.pickUpReportSearch"
                    ></v-text-field>
                </div>
                <div class="d-flex">
                    <v-text-field
                        v-model="formData.fromDate"
                        class="pl-2"
                        type="date"
                        density="compact"
                        variant="outlined"
                        label="from date "
                    ></v-text-field>
                    <v-text-field
                        v-model="formData.toDate"
                        class="px-2"
                        type="date"
                        density="compact"
                        variant="outlined"
                        label="from date "
                    ></v-text-field>
                    <v-btn color="primaryOld" class="px-8" @click="send"> Filter</v-btn>
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
                                    :items="ReportRepository.pickupReport"
                                    :loading="ReportRepository.loading"
                                    :search="
                                        ReportRepository.pickUpReportSearch
                                    "
                                    @update:options="
                                        ReportRepository.fetchPickupReports
                                    "
                                    :item-key="
                                        ReportRepository.pickupReport
                                    "
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
import { ref, onMounted,reactive } from "vue";
import AppBar from "../../../components/AppBar.vue";
import { useReportRepository } from "@/store/ReportRepository";
const ReportRepository = useReportRepository();
const formData = reactive({
    fromDate:"",
    toDate:"",
})

const send =()=>{
    ReportRepository.fetchServiceReports(formData.fromDate,formData.toDate)
    console.log(formData,'this is what jawad agha need ')

}

// header
const headers = [
    { title: "Category Name", key: "name", align: "start", sortable: false },
    {
        title: "Total Amount",
        key: "totalAmount",
        align: "start",
        sortable: false,
    },
];
</script>
