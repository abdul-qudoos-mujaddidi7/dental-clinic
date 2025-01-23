<template>
    <div class="bg-[#f8f8f8] rounded-xl" rtl>
        <AppBar subTitle="Dashboard" main-title="dashboard" class="MenuColor" />
        <v-divider
            :thickness="1"
            class="border-opacity-100"
            color="success"
        ></v-divider>

        <v-row class="pt-6">
            <v-col>
                <v-card variant="flat" dir="rtl" rounded="lg">
                    <template v-slot:title>
                        <div class="d-flex align-center justify-end">
                            <div class="font-weight-black">
                                {{
                                    DashboardRepository.dashboardReport
                                        .netProfit
                                }}
                            </div>
                            <v-avatar size="40" class="mr-4">
                                <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                <img
                                    src="@/assets/images/dashboard/totalVisa.svg"
                                    class="w-6"
                                />
                            </v-avatar>
                        </div>
                    </template>
                    <v-card-text
                        class="text-h6 d-flex justify-end calibri_font ml-14"
                    >
                        Profit
                    </v-card-text>
                </v-card></v-col
            >

            <v-col>
                <v-card variant="flat" dir="rtl" rounded="lg">
                    <template v-slot:title>
                        <div class="d-flex align-center justify-end">
                            <div class="font-weight-black">
                                {{
                                    DashboardRepository.dashboardReport
                                        .totalAllExpenses
                                }}
                            </div>
                            <v-avatar size="40" class="mr-4">
                                <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                <img
                                    src="@/assets/images/dashboard/totalTicket.svg"
                                    class="w-8"
                                />
                            </v-avatar>
                        </div>
                    </template>
                    <v-card-text
                        class="text-h6 d-flex justify-end calibri_font ml-14"
                    >
                        Expense
                    </v-card-text>
                </v-card></v-col
            >
            <v-col>
                <v-card variant="flat" dir="rtl" rounded="lg">
                    <template v-slot:title>
                        <div class="d-flex align-center justify-end">
                            <div class="font-weight-black">
                                {{
                                    DashboardRepository.dashboardReport
                                        .totalEarnings
                                }}
                            </div>
                            <v-avatar size="40" class="mr-4">
                                <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                <img
                                    src="@/assets/images/dashboard/totalTourpackageBooket.svg"
                                    class="w-6"
                                />
                            </v-avatar>
                        </div>
                    </template>
                    <v-card-text
                        class="text-h6 d-flex justify-end calibri_font ml-14"
                    >
                        Sales
                    </v-card-text>
                </v-card></v-col
            >

            <v-col>
                <v-card variant="flat" dir="rtl" rounded="lg">
                    <template v-slot:title>
                        <div class="d-flex align-center justify-end">
                            <div class="font-weight-black">
                                {{
                                    DashboardRepository.dashboardReport
                                        .totalPatients
                                }}
                            </div>
                            <v-avatar size="40" class="mr-4">
                                <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                <img
                                    src="@/assets/images/dashboard/totalTourpackage.svg"
                                    class="w-4"
                                />
                            </v-avatar>
                        </div>
                    </template>
                    <v-card-text
                        class="text-h6 d-flex justify-end calibri_font ml-14"
                    >
                        Patients
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-row dir="rtl">
            <v-col>
                <TotalPayment />
            </v-col>
            <v-col>
                <DataBar />
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-card class="pt-4 bg-white rounded-xl pr-4" variant="flat">
                    <div class="pa-3 px-4 py-5 mr-4 ml-6">
                        <!-- Header -->
                        <div class="d-flex justify-space-between mb-6">
                            <span>
                                <p class="text-lg font-bold">
                                    AFG
                                    {{
                                        DashboardRepository.dashboardReport
                                            .totalAllExpenses || 0
                                    }}
                                </p>
                                <p class="text-subtitle-2">
                                    Expenses based on amount and percentage
                                </p>
                            </span>
                            <span class="flex flex-col gap-1">
                                <!-- Filter buttons for switching between expense views -->
                                <v-btn
                                    size="x-small"
                                    :style="{
                                        backgroundColor:
                                            activeButton === 'black'
                                                ? '#112F53'
                                                : '',
                                        color:
                                            activeButton === 'black'
                                                ? '#fff'
                                                : '',
                                    }"
                                    @click="
                                        updateExpenses(
                                            DashboardRepository.dashboardReport
                                                .yearlyExpenses,
                                            'black'
                                        )
                                    "
                                >
                                    {{ "this year" }}
                                </v-btn>
                                <v-btn
                                    size="x-small"
                                    :style="{
                                        backgroundColor:
                                            activeButton === 'red'
                                                ? '#112F53'
                                                : '',
                                        color:
                                            activeButton === 'red'
                                                ? '#fff'
                                                : '',
                                    }"
                                    @click="
                                        updateExpenses(
                                            DashboardRepository.dashboardReport
                                                .monthlyExpenses,
                                            'red'
                                        )
                                    "
                                >
                                    {{ "this month" }}
                                </v-btn>
                                <v-btn
                                    size="x-small"
                                    :style="{
                                        backgroundColor:
                                            activeButton === 'green'
                                                ? '#112F53'
                                                : '',
                                        color:
                                            activeButton === 'green'
                                                ? '#fff'
                                                : '',
                                    }"
                                    @click="
                                        updateExpenses(
                                            DashboardRepository.dashboardReport
                                                .dailyExpenses,
                                            'green'
                                        )
                                    "
                                >
                                    {{ "today" }}
                                </v-btn>
                            </span>
                        </div>

                        <!-- List of expenses with percentages and progress bars -->
                        <div
                            v-for="expense in DashboardRepository.expensesList"
                            :key="expense.id"
                            class="mb-4"
                        >
                            <div class="d-flex justify-space-between" dir="rtl">
                                <span class="text-sm font-bold"
                                    >{{ expense.percentage }}%</span
                                >
                                <span class="text-sm font-bold text-gray-700">
                                    {{ expense.categoryName }}(AFG
                                    {{ expense.totalExpense || 0 }})
                                </span>
                            </div>

                            <v-progress-linear
                                :model-value="Number(expense.percentage)"
                                height="6"
                                :color="randomColor()"
                                class="rounded-lg"
                                reverse
                            ></v-progress-linear>
                        </div>
                    </div>
                </v-card>
            </v-col>
            <v-col>
                <v-card
                    class="bg-white rounded-xl mr-3 mt-0 h-100"
                    variant="flat"
                >
                    <h2 class="pl-4 py-4">Upcoming Appointment</h2>
                    <v-table>
                        <template v-slot:default>
                            <thead class="bg-white" style="border: none">
                                <tr
                                    style="
                                        border: none;
                                        background-color: white;
                                    "
                                >
                                    <th class="text-left">Customer</th>
                                    <th class="text-left">Time</th>
                                    <th class="text-left">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    style="border: none"
                                    v-for="item in DashboardRepository
                                        .dashboardReport.upcomingAppointments"
                                    :key="item.id"
                                >
                                    <td>{{ item.customerId }}</td>
                                    <td class="d-flex align-center">
                                        <v-avatar class="mr-2" size="36px">
                                            <img
                                                :src="item.photo"
                                                alt="Avatar"
                                            />
                                        </v-avatar>
                                        {{ item.customerName }}
                                    </td>
                                    <td>{{ item.customerPhone }}</td>
                                    <td>{{ item.totalSpentKW }}</td>
                                    <td>{{ item.paid }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-table>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<!-- ============================================================================================================================= -->

<script setup>
import DataBar from "@/components/UI/DashboardCharts/barChart.vue";
import MoneyAccountChart from "@/components/UI/DashboardCharts/MoneyAccountChart.vue";
import TotalPayment from "@/components/UI/DashboardCharts/TotalPayment.vue";
import AppBar from "../../components/AppBar.vue";

import { useDashboardRepository } from "@/store/DashboardRepository";
import { onMounted, ref } from "vue";

let DashboardRepository = useDashboardRepository();

onMounted(async () => {
    await DashboardRepository.fetchDashboardData();
});
const activeButton = ref("");

// Method to update expenses based on button clicks
const updateExpenses = (expenses, color) => {
    DashboardRepository.updateExpenses(expenses, color);
    activeButton.value = color; // Set the active button to the clicked color
};

// Array of colors to choose from
const colors = [
    "blue",
    "darkRed",
    "primary",
    "green",
    "GreenLight",
    "darkGreen",
];

// Function to select a random color
const randomColor = () => {
    return colors[Math.floor(Math.random() * colors.length)];
};
</script>
<style scoped>
.MenuColor {
    background-color: #f8f8f8 !important;
}
</style>
