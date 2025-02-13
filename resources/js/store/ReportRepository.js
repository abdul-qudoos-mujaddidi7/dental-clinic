import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";

export let useReportRepository = defineStore("ReportRepository", {
    state() {
        return {
            router: useRouter(),
            search: ref(""),
            serverItems: ref([]),
            loadingTable: ref(true),
            loading: ref(false),
            totalItems: ref(0),
            meta: "",
            totalItemsDOC: ref(1),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            // profit and loss
            totalAllExpense: reactive([]),
            totalAllProfit: reactive([]),
            totalAllProfit: reactive([]),
            // patients report
            patientReports: reactive([]),
            patientReportSearch: ref(""),
            // expense cat report
            expenseCatReport: reactive([]),
            expenseCatReportSearch: ref(""),
            // expense cat report
            expenseProductReport: reactive([]),
            expenseProductReportSearch: ref(""),
<<<<<<< HEAD
            // pickup report
            pickUpReportSearch: ref(""),
            pickupReport: reactive([]),
            // serviceReport
            serviceReportSearch: ref(""),
            serviceReport: reactive([]),
=======
            // pickup report 
            pickUpReportSearch:ref(""),
            pickupReport:reactive([]),
            // serviceReport
            serviceReportSearch:ref(""),
            serviceReport:reactive([]),
>>>>>>> 0f71dde860ac474288aa3805c11247124473617d
        };
    },
    actions: {
        // all the total reports of earnings
        async fetchTotalReportsOfEarnings() {
            this.loading = true;

            const response = await axios.get(`financialReport`);
            // ==
            this.totalAllExpense = response.data.totalAllExpense;
            this.totalAllProfit = response.data.totalAllProfit;
            this.totalAllPickup = response.data.totalAllPickup;
            console.log(response.data, "profit and loss ");
            this.loading = false;
        },
        // patients payment ================================
        async fetchPatientsReports({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `patientPaymentReport?page=${page}&perPage=${itemsPerPage}&search=${this.patientReportSearch}`
            );
            this.patientReports = response.data.data;
            console.log(this.patientReports, "payment report");
            this.totalItems = response.data.total;
            this.loading = false;
        },
        // expense Category report =============================
        async fetchExpenseCategoryReports({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `expenseCategoryReport?page=${page}&perPage=${itemsPerPage}&search=${this.expenseCatReportSearch}`
            );
            this.expenseCatReport = response.data.data;
            console.log(this.expenseCatReport, "expense category report");
            this.totalItems = response.data.total;
            this.loading = false;
        },
        // expense Category report =============================
        async fetchExpenseProductReports({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `expenseProductReport?page=${page}&perPage=${itemsPerPage}&search=${this.expenseProductReportSearch}`
            );
            this.expenseProductReport = response.data.data;
            console.log(this.expenseProductReport, "expense product report");
            this.totalItems = response.data.total;
            this.loading = false;
        },
<<<<<<< HEAD

        // expense Category report =============================
        async fetchPickupReports({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `pickupReport?page=${page}&perPage=${itemsPerPage}&search=${this.pickUpReportSearch}`
            );
            this.pickupReport = response.data.data;
            console.log(this.pickupReport, "pickup report");
            this.totalItems = response.data.total;
            this.loading = false;
        },
        // service  Category report =============================
        async fetchServiceReports({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `serviceReport?page=${page}&perPage=${itemsPerPage}&search=${this.serviceReportSearch}`
            );
            this.serviceReport = response.data.data;
            console.log(this.serviceReport, "pickup report");
            this.totalItems = response.data.total;
            this.loading = false;
        },
=======
        
             // expense Category report =============================
             async fetchPickupReports({ page, itemsPerPage }) {
                this.loading = true;
                const response = await axios.get(
                    `pickupReport?page=${page}&perPage=${itemsPerPage}&search=${this.pickUpReportSearch}`
                );
                this.pickupReport = response.data.data;
                console.log(this.pickupReport, "pickup report");
                this.totalItems = response.data.total;
                this.loading = false;
            },
                // service  Category report =============================
                async fetchServiceReports({ page, itemsPerPage }) {
                    this.loading = true;
                    const response = await axios.get(
                        `serviceReport?page=${page}&perPage=${itemsPerPage}&search=${this.serviceReportSearch}`
                    );
                    this.serviceReport = response.data;
                    console.log(this.serviceReport, "pickup report");
                    this.totalItems = response.data.total;
                    this.loading = false;
                },
>>>>>>> 0f71dde860ac474288aa3805c11247124473617d
    },
});
