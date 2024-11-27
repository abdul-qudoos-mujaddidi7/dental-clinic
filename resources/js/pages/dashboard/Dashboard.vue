<template>
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl" rtl>
            <AppBar subTitle="Dashboard" class="MenuColor" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>

            <v-row class="pt-6">
                <v-col>
                    <v-card variant="flat" dir="rtl" rounded="lg">
                        <template v-slot:title>
                            <div
                                class="d-flex w-25 align-center justify-space-between"
                            >
                                <v-avatar size="40" class="mr-4">
                                    <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                    <img
                                        src="@/assets/images/dashboard/totalTourpackage.svg"
                                        class="w-4"
                                    />
                                </v-avatar>
                                <div class="font-weight-black pb-2 mr-4">
                                    {{
                                        DashboardRepository.dashboards.customers
                                    }}
                                </div>
                            </div>
                        </template>
                        <v-card-text class="pt-2 text-h5 mr-14 calibri_font">
                            مشتری
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col>
                    <v-card variant="flat" dir="rtl" rounded="lg">
                        <template v-slot:title>
                            <div
                                class="d-flex w-25 align-center justify-space-between"
                            >
                                <v-avatar size="40" class="mr-4">
                                    <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                    <img
                                        src="@/assets/images/dashboard/totalTourpackageBooket.svg"
                                        class="w-4"
                                    />
                                </v-avatar>
                                <div class="font-weight-black pb-2 mr-4">
                                    {{
                                        DashboardRepository.dashboards.earnings
                                    }}
                                </div>
                            </div>
                        </template>
                        <v-card-text class="pt-2 text-h5 mr-14 calibri_font">
                            درآمد
                        </v-card-text>
                    </v-card></v-col
                >
                <v-col>
                    <v-card variant="flat" dir="rtl" rounded="lg">
                        <template v-slot:title>
                            <div
                                class="d-flex w-25 align-center justify-space-between"
                            >
                                <v-avatar size="40" class="mr-4">
                                    <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                    <img
                                        src="@/assets/images/dashboard/totalTicket.svg"
                                        class="w-4"
                                    />
                                </v-avatar>
                                <div class="font-weight-black pb-2 mr-4">
                                    {{
                                        DashboardRepository.dashboards.expenses
                                    }}
                                </div>
                            </div>
                        </template>
                        <v-card-text class="pt-2 text-h5 mr-14 calibri_font">
                            مصارف
                        </v-card-text>
                    </v-card></v-col
                >
                <v-col>
                    <v-card variant="flat" dir="rtl" rounded="lg">
                        <template v-slot:title>
                            <div
                                class="d-flex w-25 align-center justify-space-between"
                            >
                                <v-avatar size="40" class="mr-4">
                                    <!-- <v-icon size="36">mdi-account-details</v-icon> -->
                                    <img
                                        src="@/assets/images/dashboard/totalVisa.svg"
                                        class="w-4"
                                    />
                                </v-avatar>
                                <div class="font-weight-black pb-2 mr-4">
                                    {{
                                        DashboardRepository.dashboards
                                            .activeMeters
                                    }}
                                </div>
                            </div>
                        </template>
                        <v-card-text class="pt-2 text-h5 mr-14 calibri_font">
                            میتر‌های فعال
                        </v-card-text>
                    </v-card></v-col
                >
            </v-row>
            <v-row dir="rtl">
                <v-col>
                    <TotalPayment />
                </v-col>
                <v-col>
                    <DataBar />
                </v-col>
            </v-row>
            <v-row dir="rtl">
                <v-col>
                    <v-card
                        class="bg-white rounded-xl mr-3 mt-0 h-100"
                        variant="flat"
                    >
                        <h2 class="pr-4 py-2">پنج مشتری برتر</h2>
                        <v-table>
                            <template v-slot:default>
                                <thead class="bg-white" style="border: none">
                                    <tr
                                        style="
                                            border: none;
                                            background-color: white;
                                        "
                                    >
                                        <th class="text-left">آی‌دی</th>
                                        <th class="text-left">نمایه</th>
                                        <th class="text-left">شماره تماس</th>
                                        <th class="text-left">مجموعه مصرف</th>
                                        <th class="text-left">پرداختی‌ها</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        style="border: none"
                                        v-for="item in DashboardRepository
                                            .dashboards.topFiveCustomers"
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

                <v-col>
                    <v-card
                        class="pt-4 bg-white rounded-xl pr-4"
                        variant="flat"
                    >
                        <div class="pa-3 px-4 py-5 mr-4 ml-6">
                            <!-- Header -->
                            <div class="d-flex justify-space-between mb-6">
                                <span>
                                    <p class="text-lg font-bold">
                                        AFG
                                        {{
                                            DashboardRepository.totalExpenses ||
                                            0
                                        }}
                                    </p>
                                    <p class="text-subtitle-2">
                                        تمام مصارفات بر اساس مقدار و فیصدی
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
                                                DashboardRepository.dashboards
                                                    .thisYearExpenses,
                                                'black'
                                            )
                                        "
                                    >
                                        {{ "امسال" }}
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
                                                DashboardRepository.dashboards
                                                    .thisMonthExpenses,
                                                'red'
                                            )
                                        "
                                    >
                                        {{ "این ماه" }}
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
                                                DashboardRepository.dashboards
                                                    .todayExpenses,
                                                'green'
                                            )
                                        "
                                    >
                                        {{ "امروز" }}
                                    </v-btn>
                                </span>
                            </div>

                            <!-- List of expenses with percentages and progress bars -->
                            <div
                                v-for="expense in DashboardRepository.expensesList"
                                :key="expense.id"
                                class="mb-4"
                            >
                                <div
                                    class="d-flex justify-space-between"
                                    dir="rtl"
                                >
                                    <span
                                        class="text-sm font-bold text-gray-700"
                                    >
                                        {{ expense.name }} (AFG
                                        {{ expense.expAmount || 0 }})
                                    </span>
                                    <span class="text-sm font-bold"
                                        >{{
                                            expense.percentage.toFixed(2)
                                        }}%</span
                                    >
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
            </v-row>
        </div>
        <!-- four cards of Dashboard in four columns==================== -->
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

onMounted(() => {
    DashboardRepository.fetchDashboardData();
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
.calibri_font {
    font-family: "Calibri", sans-serif;
    font-weight: bold;
    font-style: normal;
}
</style>
