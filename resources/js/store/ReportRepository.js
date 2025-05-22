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
            // pickup report
            pickUpReportSearch: ref(""),
            pickupReport: reactive([]),
            // serviceReport
            serviceReportSearch: ref(""),
            serviceReport: reactive([]),
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
        async fetchPatientsReports(
            { page, itemsPerPage },
            startDate = null,
            endDate = null
        ) {
            const formatDate = (date) => {
                if (!date) return null;
                const d = new Date(date);
                return `${d.getMonth() + 1}/${d.getDate()}/${d.getFullYear()}`;
            };

            const formattedStartDate = formatDate(startDate);
            const formattedEndDate = formatDate(endDate);

            console.log(
                `Start Date: ${formattedStartDate}, End Date: ${formattedEndDate} in the repository for patients report`
            );

            this.loading = true;
            try {
                const response = await axios.get(`patientPaymentReport`, {
                    params: {
                        page,
                        perPage: itemsPerPage,
                        search: this.patientReportSearch,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate,
                    },
                });

                this.patientReports = response.data.data;
                console.log(this.patientReports, "payment report");
                this.totalItems = response.data.total;
            } catch (error) {
                console.error("Error fetching patients reports:", error);
            } finally {
                this.loading = false;
            }
        },

        // expense Category report =============================
        async fetchExpenseCategoryReports(
            { page, itemsPerPage },
            startDate = null,
            endDate = null
        ) {
            const formatDate = (date) => {
                if (!date) return null;
                const d = new Date(date);
                return `${d.getMonth() + 1}/${d.getDate()}/${d.getFullYear()}`;
            };

            const formattedStartDate = formatDate(startDate);
            const formattedEndDate = formatDate(endDate);

            console.log(
                `Start Date: ${formattedStartDate}, End Date: ${formattedEndDate} in the repository for expense cat reports`
            );

            this.loading = true;
            try {
                const response = await axios.get(`expenseCategoryReport`, {
                    params: {
                        page,
                        perPage: itemsPerPage,
                        search: this.expenseCatReportSearch,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate,
                    },
                });

                this.expenseCatReport = response.data.data;
                console.log(this.expenseCatReport, "expense category report");
                this.totalItems = response.data.total;
            } catch (error) {
                console.error(
                    "Error fetching expense category reports:",
                    error
                );
            } finally {
                this.loading = false;
            }
        },

        // expense Category report =============================
        async fetchExpenseProductReports(
            { page, itemsPerPage },
            startDate = null,
            endDate = null
        ) {
            const formatDate = (date) => {
                if (!date) return null;
                const d = new Date(date);
                return `${d.getMonth() + 1}/${d.getDate()}/${d.getFullYear()}`;
            };

            const formattedStartDate = formatDate(startDate);
            const formattedEndDate = formatDate(endDate);

            console.log(
                `Start Date: ${formattedStartDate}, End Date: ${formattedEndDate} in the repository for expense product report`
            );

            this.loading = true;
            try {
                const response = await axios.get(`expenseProductReport`, {
                    params: {
                        page,
                        perPage: itemsPerPage,
                        search: this.expenseProductReportSearch,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate,
                    },
                });

                this.expenseProductReport = response.data.data;
                console.log(
                    this.expenseProductReport,
                    "expense product report"
                );
                this.totalItems = response.data.total;
            } catch (error) {
                console.error("Error fetching expense product reports:", error);
            } finally {
                this.loading = false;
            }
        },
        // expense Category report =============================
        async fetchPickupReports(
            { page, itemsPerPage },
            startDate = null,
            endDate = null
        ) {
            const formatDate = (date) => {
                if (!date) return null;
                const d = new Date(date);
                return `${d.getMonth() + 1}/${d.getDate()}/${d.getFullYear()}`;
            };

            const formattedStartDate = formatDate(startDate);
            const formattedEndDate = formatDate(endDate);

            console.log(
                `Start Date: ${formattedStartDate}, End Date: ${formattedEndDate} in the repository for pickup`
            );

            this.loading = true;
            try {
                const response = await axios.get(`pickupReport`, {
                    params: {
                        page,
                        perPage: itemsPerPage,
                        search: this.pickUpReportSearch,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate,
                    },
                });

                this.pickupReport = response.data.data;
                console.log(this.pickupReport, "pickup report");
                this.totalItems = response.data.total;
            } catch (error) {
                console.error("Error fetching pickup reports:", error);
            } finally {
                this.loading = false;
            }
        },
        // service  Category report =============================
        async fetchServiceReports(
            { page, itemsPerPage },
            startDate = null,
            endDate = null
        ) {
            const formatDate = (date) => {
                if (!date) return null;
                const d = new Date(date);
                return `${d.getMonth() + 1}/${d.getDate()}/${d.getFullYear()}`;
            };

            const formattedStartDate = startDate;
            const formattedEndDate = endDate;

            console.log(
                `Start Date: ${formattedStartDate}, End Date: ${formattedEndDate}`
            );

            this.loading = true;
            try {
                const response = await axios.get(`serviceReport`, {
                    params: {
                        page,
                        perPage: itemsPerPage,
                        search: this.serviceReportSearch,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate,
                    },
                });

                this.serviceReport = response.data.data;
                console.log(this.serviceReport, "pickup report");
                this.totalItems = response.data.total;
            } catch (error) {
                console.error("Error fetching service reports:", error);
            } finally {
                this.loading = false;
            }
        },
    },
});
