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

                    <!-- Fix for date range picker -->
                    <date-picker
                        mode="range"
                        v-model="ReportRepository.productDateRange" 
                        :styles="styles"
                        @update:modelValue="onDateChange" 
                        locale="fa"
                        type="date"
                        :locale-config="LocaleConfigs"
                        input-format="jYYYY/jMM/jDD"
                        format="YYYY-MM-DD"
                    />
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
import { LocaleConfigs, styles } from "../../../LocaleConfigs";
const productDateRange = ref([new Date(), new Date()]);


const onDateChange = () => {
    console.log('called');

const startDate = ReportRepository.productDateRange[0];
const endDate = ReportRepository.productDateRange[1];
    if (startDate && endDate) {
        ReportRepository.fetchPickupReports({ page: 1, itemsPerPage: 10 },startDate, endDate);
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
        { page: 1, itemsPerPage: 10 },

        productDateRange.value[0],
        productDateRange.value[1]
    );
    console.log(productDateRange.value[0], productDateRange.value[1], "pick up report");
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
