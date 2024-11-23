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
            patientReports:reactive([]),
            patientReportSearch:ref("")
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
        // meter cycle payment ================================
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
    },
});
