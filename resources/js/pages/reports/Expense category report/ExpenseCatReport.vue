<template>
    <CreatePatients v-if="ReportRepository.createDialog" />
    <div class="all-expense rounded-xl" :dir="dir">
        <div class="card rounded-xl">
            <AppBar mainTitle="Expense Product Report" sub-title="reports" />
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
                        v-model="ReportRepository.expenseCatReportSearch"
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
                    <v-main class="main" :dir="dir">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                :class="
                                        dir === 'rtl'
                                            ? 'rtl-border'
                                            : 'ltr-border'
                                    "
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        ReportRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ReportRepository.totalItems"
                                    :items="ReportRepository.expenseCatReport"
                                    :loading="ReportRepository.loading"
                                    :search="
                                        ReportRepository.expenseCatReportSearch
                                    "
                                    @update:options="
                                        ReportRepository.fetchExpenseCategoryReports
                                    "
                                    :item-key="
                                        ReportRepository.expenseCatReport
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
import { ref, onMounted,watch,computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import { useReportRepository } from "@/store/ReportRepository";
const ReportRepository = useReportRepository();
import DatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";
import { useI18n } from "vue-i18n";
const { t ,locale} = useI18n();
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
        ReportRepository.fetchExpenseCategoryReports({ page: 1, itemsPerPage: 10 },startDate, endDate);
    }
};

watch(
    () => ReportRepository.ProductReportSearch,
    (newSearchTerm) => {
        const [startDate, endDate] = ReportRepository.productDateRange;
        if (startDate && endDate) {
            ReportRepository.fetchExpenseCategoryReports( startDate, endDate);
        }
    }
);

onMounted(() => {
    ReportRepository.productDateRange = productDateRange.value;
    ReportRepository.fetchExpenseCategoryReports(
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
