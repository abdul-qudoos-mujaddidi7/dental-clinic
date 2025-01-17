<script setup>
import * as echarts from "echarts";
import { onMounted, watch } from "vue";
import { useDashboardRepository } from "@/store/DashboardRepository";

let DashboardRepository = useDashboardRepository();
DashboardRepository.fetchDashboardData();

watch(
    () => DashboardRepository.dashboards.earningMonths,
    () => {
        updateChart();
    },
    { immediate: true }
);

async function updateChart() {
    var myChart = echarts.init(document.getElementById("income"), null, {
        width: 550,
        height: 200,
    });

    // Get the last month's earnings value for the title
    const lastMonthEarnings = DashboardRepository.dashboards.lastMonthEarnings;

    var option = {
        color: ["#80FFA5", "#00DDFF", "#37A2FF"],
        tooltip: {
            trigger: "axis",
            axisPointer: {
                type: "cross",
                label: {
                    backgroundColor: "#6a7985",
                },
            },
        },
        title: {
            text: `Earnings: ${lastMonthEarnings}`, // Display the value dynamically
            left: "right",
            top: "10%",
            textStyle: {
                fontSize: 16,
                fontWeight: "bold",
                color: "#333",
                fontFamily: "Calibri, sans-serif",
            },
        },
        legend: {
            show: false, // Hide the legend
        },
        grid: {
            left: "4%",
            right: "5%",
            bottom: "4%",
            containLabel: true,
        },
        xAxis: [
            {
                type: "category",
                axisTick: { show: true },
                data: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
            },
        ],
        yAxis: [
            {
                type: "value",
                show: true,
                splitLine: { show: true },
            },
        ],
        series: [
            {
                name: "Earnings",
                type: "line",
                stack: "Total",
                smooth: true,
                lineStyle: {
                    width: 0,
                },
                showSymbol: false,
                areaStyle: {
                    opacity: 0.8,
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        {
                            offset: 0,
                            color: "rgb(128, 255, 165)",
                        },
                        {
                            offset: 1,
                            color: "rgb(1, 191, 236)",
                        },
                    ]),
                },
                emphasis: {
                    focus: "series",
                },
                data: DashboardRepository.dashboards.earningMonths,
            },
        ],
    };

    option && myChart.setOption(option);
}

onMounted(updateChart);
</script>

<template>
    <div class="shadow-md pt-6 bg-white rounded-xl pb-10 d-flex justify-center">
        <canvas id="income" style="width: 34rem;"></canvas>
    </div>
</template>
