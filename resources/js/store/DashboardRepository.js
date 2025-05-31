import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { axios } from "../axios";

export const useDashboardRepository = defineStore("DashboardRepository", {
  state: () => ({
    // Dashboard data
    dashboards: reactive([]),
    totalExpenses: 0,
    expenses: reactive([]),

    // UI state
    dialog: false,
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

    // Search
    search: "",

    // API-specific data
    earnings: 0,
    todayExpenses: [],
    thisMonthExpenses: [],
    thisYearExpenses: [],
    expensesList: [],
    dashboardReport: reactive({
      thisMonthProfit: 0,
      lastMonthProfit: 0,
      todayEarning: 0,
      totalTodayExpense: 0,
      newPatients: 0,
      totalPatients: 0,
      totalEarnings: 0,
      totalAllExpenses: 0,
      netProfit: 0,
      dailyExpenses: [],
      monthlyExpenses: [],
      yearlyExpenses: [],
      upcomingAppointments: [],
      monthExpenses: [],
      monthIncomes: [],
      monthProfits: [],
    }),
    monthExpenses: reactive([]),
    monthIncomes: reactive([]),
    monthProfits: reactive([]),
  }),

  actions: {
    // Fetch data from the API
    async fetchDashboardData() {
      this.isLoading = true;
      try {
        const response = await axios.get("dashboardReport");
        const data = response.data;

        console.log("Fetched dashboard data:", data);

        // Ensure numeric values are converted to numbers
        this.$patch({
          dashboardReport: data,
          dashboards: data,
          totalExpenses: parseFloat(data.totalAllExpenses) || 0,
          todayExpenses: data.dailyExpenses || [],
          thisMonthExpenses: data.monthlyExpenses || [],
          thisYearExpenses: data.yearlyExpenses || [],
          monthExpenses: data.monthExpenses || [],
          monthIncomes: data.monthIncomes || [],
          monthProfits: data.monthProfits|| [],
          earnings: parseFloat(data.totalEarnings) || 0,
          expensesList: this.processExpenses(data.monthlyExpenses, "green"),
        });

        this.isLoading = false;
      } catch (error) {
        console.error("Failed to fetch dashboard data:", error);
        this.error = "Failed to load dashboard data.";
        this.isLoading = false;
      }
    },

    // Update expenses dynamically
    updateExpenses(expenses, color) {
      console.log("Updating expenses with:", expenses, color);
      if (!Array.isArray(expenses)) {
        console.warn("Expenses parameter is not an array");
        return;
      }
      this.totalExpenses = expenses.reduce(
        (acc, expense) => acc + (parseFloat(expense.totalExpense) || 0),
        0
      );
      this.expensesList = this.processExpenses(expenses, color);
    },

    // Process expenses to add percentage and color
    processExpenses(expenses, color) {
      return expenses.map((exp) => ({
        ...exp,
        percentage: ((parseFloat(exp.totalExpense) || 0) / this.totalExpenses) * 100,
        color,
      }));
    },
  },
});
