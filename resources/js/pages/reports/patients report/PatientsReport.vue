<template>
    <div class="all-expense rounded-xl" :dir="dir">
        <div class="card rounded-xl">
            <AppBar mainTitle="patient report " sub-title="report" />
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
                        v-model="ReportRepository.patientReportSearch"
                    ></v-text-field>
                </div>
                <div class="d-flex">
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
                                    :items="ReportRepository.patientReports"
                                    :loading="ReportRepository.loading"
                                    :search="
                                        ReportRepository.patientReportSearch
                                    "
                                    @update:options="
                                        ReportRepository.fetchPatientsReports
                                    "
                                    :item-key="ReportRepository.patientReports"
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
import { ref, onMounted, reactive, watch,computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import { useReportRepository } from "@/store/ReportRepository";
import { useI18n } from "vue-i18n";
const { t,locale } = useI18n();
const ReportRepository = useReportRepository();

// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

import { LocaleConfigs,styles } from "../../../LocaleConfigs";


const productDateRange = ref([new Date(), new Date()]);

const onDateChange = (newRange) => {
    console.log('Date range changed:', newRange);

    const [startDate, endDate] = newRange;

    if (startDate && endDate) {
        ReportRepository.fetchPatientsReports({ page: 1, itemsPerPage: 10 }, startDate, endDate);
    }
};

watch(
    () => ReportRepository.ProductReportSearch,
    (newSearchTerm) => {
        const [startDate, endDate] = ReportRepository.productDateRange;
        if (startDate && endDate) {
            ReportRepository.fetchPatientsReports(startDate, endDate);
        }
    }
);

onMounted(() => {
    ReportRepository.fetchPatientsReports();
});

// header
const headers = [
    { title: t("patient"), key: "name", align: "start", sortable: false },
    { title: t("phone"), key: "phone", align: "start", sortable: false },
    { title: t("address"), key: "address", align: "start", sortable: false },
    { title: t("due"), key: "due", align: "center", sortable: false },
];
</script>
