import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { axios } from "../axios";

export let useDashboardRepository = defineStore("DashboardRepository", {
    state() {
        return {
            dashboards: reactive([]),
            totalExpenses: 0,
            expenses: reactive([]),

            dailog: false,
            isLoading: false,
            error: null,
            loading: true,
            itemsPerPage: 10,
            page: 1,
            showSelect: true,
            totalItems: 0,
            itemKey: "id",
            visaId: reactive([]),
            symbol: ref(null),

            search: "",

            earnings: 0,
            expenses: 0,
            todayExpenses: [],
            thisMonthExpenses: [],
            thisYearExpenses: [],
            expensesList: [],
            dashboards: {
                todayExpenses: [],
                thisMonthExpenses: [],
                thisYearExpenses: [],
            },
            totalExpenses: 0,
            expensesList: [],
        };
    },
    actions: {
        // Original method for fetching dashboard data
        async fetchDashboardData() {
            try {
                const response = await axios.get("dashboards");
                const data = response.data.data;

                console.log("Fetched dashboard data:", data);

                this.$patch({
                    dashboards: data,
                    totalExpenses: data.todayExpenses.reduce(
                        (acc, expense) => acc + (expense.expAmount || 0),
                        0
                    ),
                    expensesList: this.processExpenses(
                        data.todayExpenses,
                        "green"
                    ),
                });
            } catch (error) {
                console.error("Failed to fetch dashboard data:", error);
            }
        },
        updateExpenses(expenses, color) {
            console.log("Updating expenses with:", expenses, color);
            if (!Array.isArray(expenses)) {
                console.warn("Expenses parameter is not an array");
                return;
            }
            this.totalExpenses = expenses.reduce(
                (acc, expense) => acc + (expense.expAmount || 0),
                0
            );
            this.expensesList = this.processExpenses(expenses, color);
        },
        processExpenses(expenses, color) {
            // Example processing logic
            return expenses.map((exp) => ({
                ...exp,
                percentage: ((exp.expAmount || 0) / this.totalExpenses) * 100,
                color,
            }));
        },
    },
});
