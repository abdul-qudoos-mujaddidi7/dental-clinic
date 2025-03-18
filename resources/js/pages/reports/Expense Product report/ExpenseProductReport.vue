<template>
    <CreatePatients v-if="ReportRepository.createDialog" />
    <div class="all-expense rounded-xl" :dir="dir">
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
                        :label="$t('search')"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="ReportRepository.expenseProductReportSearch"
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
                                :dir="dir"
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        ReportRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ReportRepository.totalItems"
                                    :items="ReportRepository.expenseProductReport"
                                    :loading="ReportRepository.loading"
                                    :search="
                                        ReportRepository.expenseProductReportSearch
                                    "
                                    @update:options="
                                        ReportRepository.fetchExpenseProductReports
                                    "
                                    :item-key="
                                        ReportRepository.expenseProductReport
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
import { ref, onMounted,reactive, watch,computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import { useReportRepository } from "@/store/ReportRepository";
const ReportRepository = useReportRepository();
import DatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";
import { useI18n } from "vue-i18n";
const { t,locale } = useI18n();
const productDateRange = ref([new Date(), new Date()]);

// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});


const onDateChange = () => {
    console.log('called');

    const startDate = ReportRepository.productDateRange[0];
    const endDate = ReportRepository.productDateRange[1];
    if (startDate && endDate) {
        ReportRepository.fetchExpenseProductReports( { page: 1, itemsPerPage: 10 },startDate, endDate);
    }
};

watch(
    () => ReportRepository.ProductReportSearch,
    (newSearchTerm) => {
        const [startDate, endDate] = ReportRepository.productDateRange;
        if (startDate && endDate) {
            ReportRepository.fetchExpenseProductReports(startDate, endDate);
        }
    }
);

onMounted(() => {
    ReportRepository.productDateRange = productDateRange.value;
    ReportRepository.fetchExpenseProductReports(
        { page: 1, itemsPerPage: 10 },
        productDateRange.value[0],
        productDateRange.value[1]
    );
    console.log(productDateRange.value[0], productDateRange.value[1], "service report");
});
// header
const headers = [
    { title: t("categoryName"), key: "name", align: "start", sortable: false },
    {
        title: t("totalAmount"),
        key: "totalAmount",
        align: "start",
        sortable: false,
    },
];
</script>
