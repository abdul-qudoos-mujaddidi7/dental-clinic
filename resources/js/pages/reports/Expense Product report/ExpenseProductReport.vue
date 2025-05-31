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
import { LocaleConfigs, styles } from "../../../LocaleConfigs";
import { useI18n } from "vue-i18n";
const { t,locale } = useI18n();

// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

const productDateRange = ref([new Date(), new Date()]);

const onDateChange = (newRange) => {
    console.log('Date range changed:', newRange);

    const [startDate, endDate] = newRange;

    if (startDate && endDate) {
        ReportRepository.fetchServiceReports({ page: 1, itemsPerPage: 10 }, startDate, endDate);
    }
};

watch(
    () => ReportRepository.ProductReportSearch,
    (newSearchTerm) => {
        const [startDate, endDate] = ReportRepository.productDateRange;
        if (startDate && endDate) {
            ReportRepository.fetchServiceReports(startDate, endDate);
        }
    }
);

onMounted(() => {
    ReportRepository.fetchExpenseProductReports();
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
