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
                    <date-picker
                        v-model:value="ReportRepository.productDateRange"
                        @change="onDateChange"
                        range
                    ></date-picker>
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
import { ref, onMounted,reactive, watch } from "vue";
import AppBar from "../../../components/AppBar.vue";
import { useReportRepository } from "@/store/ReportRepository";
const ReportRepository = useReportRepository();
import DatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";
const productDateRange = ref([new Date(), new Date()]);


const onDateChange = () => {
    const [startDate, endDate] = ReportRepository.productDateRange;
    if (startDate && endDate) {
        ReportRepository.fetchPickupReports(startDate, endDate);
    }
};

watch(
    () => ReportRepository.ProductReportSearch,
    (newSearchTerm) => {
        const [startDate, endDate] = ReportRepository.productDateRange;
        if (startDate && endDate) {
            ReportRepository.fetchPickupReports(startDate, endDate);
        }
    }
);

onMounted(() => {
    ReportRepository.productDateRange = productDateRange.value;
    ReportRepository.fetchPickupReports(
        productDateRange.value[0],
        productDateRange.value[1]
    );
    console.log(productDateRange.value[0], productDateRange.value[1], "service report");
});

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
