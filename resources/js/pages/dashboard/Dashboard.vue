<template>
    <div
        class=" rounded-xl"
        v-if="
            AuthRepository.permissions &&
            AuthRepository.permissions.includes('viewDashboard')
        "
    >
        <AppBar
            :subTitle="$t('dashboard')"
            :main-title="$t('dashboard')"
            
            
        />
        <v-divider
            :thickness="1"
            class="border-opacity-100"
            color="success"
        ></v-divider>

        <v-row class="pt-6">
            <v-col>
                <v-card variant="elevated" rounded="lg" hover>
                    <template v-slot:title>
                        <div class="d-flex">
                            <v-avatar size="40" class="mr-4">
                                <img
                                    src="@/assets/images/dashboard/totalVisa.svg"
                                    class="w-6"
                                />
                            </v-avatar>
                            <div class="pt-1">
                                <div class="font-weight-black">
                                    {{
                                        DashboardRepository.dashboardReport
                                            .netProfit
                                    }}
                                </div>
                            </div>
                        </div>
                    </template>

                    <v-card-text
                        class="text-h6 d-flex justify-start calibri_font ml-14"
                    >
                        {{ t("profit") }}
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col>
                <v-card variant="elevated" rounded="lg" hover>
                    <template v-slot:title>
                        <div class="d-flex align-center justify-start">
                            <v-avatar size="40" class="mr-4">
                                <img
                                    src="@/assets/images/dashboard/totalTicket.svg"
                                    class="w-8"
                                />
                            </v-avatar>
                            <div class="font-weight-black">
                                {{
                                    DashboardRepository.dashboardReport
                                        .totalAllExpenses
                                }}
                            </div>
                        </div>
                    </template>
                    <v-card-text
                        class="text-h6 d-flex justify-start calibri_font ml-14"
                    >
                        {{ t("expense") }}
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col>
                <v-card variant="elevated" rounded="lg" hover>
                    <template v-slot:title>
                        <div class="d-flex align-center justify-start">
                            <v-avatar size="40" class="mr-4">
                                <img
                                    src="@/assets/images/dashboard/totalTourpackageBooket.svg"
                                    class="w-6"
                                />
                            </v-avatar>
                            <div class="font-weight-black" :dir="dir">
                                {{
                                    DashboardRepository.dashboardReport
                                        .totalEarnings
                                }}
                            </div>
                        </div>
                    </template>
                    <v-card-text
                        class="text-h6 d-flex justify-start calibri_font ml-14"
                    >
                        {{ t("sales") }}
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col>
                <v-card variant="elevated" rounded="lg" hover>
                    <template v-slot:title>
                        <div class="d-flex align-center justify-start">
                            <v-avatar size="40" class="mr-4">
                                <img
                                    src="@/assets/images/dashboard/totalTourpackage.svg"
                                    class="w-4"
                                />
                            </v-avatar>
                            <div class="font-weight-black">
                                {{
                                    DashboardRepository.dashboardReport
                                        .totalPatients
                                }}
                            </div>
                        </div>
                    </template>
                    <v-card-text
                        class="text-h6 d-flex justify-start calibri_font ml-14"
                    >
                        {{ t("patients") }}
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
                <v-card class="pt-4 bg-background rounded-xl pr-4" >
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
                                    {{
                                        t("expensesBasedOnAmountAndPercentage")
                                    }}
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
                                    {{ t("thisYear") }}
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
                                    {{ t("thisMonth") }}
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
                                    {{ t("today") }}
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
                            ></v-progress-linear>
                        </div>
                    </div>
                </v-card>
            </v-col>
            <v-col>
                <v-card  class="bg-background rounded-xl mr-3 px-4 mt-0 h-100">
                    <h2 class="pl-2 py-4">{{ t("upcomingAppointment") }}</h2>
                    <div class="flex justify-center">
                        <v-table class="rounded w-100">
                            <template v-slot:default>
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="text-left font-medium text-gray-700"
                                        >
                                            {{ t("patient") }}
                                        </th>
                                        <th
                                            class="text-center font-medium text-gray-700"
                                        >
                                            {{ t("time") }}
                                        </th>
                                        <th
                                            class="text-center font-medium text-gray-700"
                                        >
                                            {{ t("phone") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in DashboardRepository
                                            .dashboardReport
                                            .upcomingAppointments"
                                        :key="item.id"
                                        class="border-b border-gray-200"
                                    >
                                        <td class="text-left">
                                            {{ item.name }}
                                        </td>
                                        <td class="text-center">
                                            {{ item.time }}
                                        </td>
                                        <td class="text-center">
                                            {{ item.phone }}
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-table>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<!-- ============================================================================================================================= -->

<script setup>
import { computed } from "vue";
import DataBar from "@/components/UI/DashboardCharts/barChart.vue";
import TotalPayment from "@/components/UI/DashboardCharts/TotalPayment.vue";
import AppBar from "../../components/AppBar.vue";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();

// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

import { useDashboardRepository } from "@/store/DashboardRepository";
import { useAuthRepository } from "@/store/AuthRepository";
const AuthRepository = useAuthRepository();
import { onMounted, ref } from "vue";
import { use } from "echarts";

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
