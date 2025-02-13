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
                        v-model="ReportRepository.expenseProductReportSearch"
                    ></v-text-field>
                </div>
                <div class="d-flex">
<<<<<<< HEAD
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
                        label="To date "
                    ></v-text-field>
                    <v-btn color="primaryOld" class="px-8" @click="send"> Filter</v-btn>
=======
                    <date-picker
                        v-model:value="ReportRepository.productDateRange"
                        @change="onDateChange"
                        range
                    ></date-picker>
>>>>>>> 0f71dde860ac474288aa3805c11247124473617d
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
<<<<<<< HEAD
import { ref, onMounted,reactive } from "vue";
=======
import { ref, onMounted,reactive, watch } from "vue";
>>>>>>> 0f71dde860ac474288aa3805c11247124473617d
import AppBar from "../../../components/AppBar.vue";
import { useReportRepository } from "@/store/ReportRepository";
const ReportRepository = useReportRepository();
import DatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";
const productDateRange = ref([new Date(), new Date()]);

<<<<<<< HEAD
const formData = reactive({
    fromDate:"",
    toDate:"",
})

const send =()=>{
    ReportRepository.fetchServiceReports(formData.fromDate,formData.toDate)
    console.log(formData,'this is what jawad agha need ')

}
=======

const onDateChange = () => {
    const [startDate, endDate] = ReportRepository.productDateRange;
    if (startDate && endDate) {
        ReportRepository.fetchExpenseProductReports(startDate, endDate);
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
        productDateRange.value[0],
        productDateRange.value[1]
    );
    console.log(productDateRange.value[0], productDateRange.value[1], "service report");
});
>>>>>>> 0f71dde860ac474288aa3805c11247124473617d
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
