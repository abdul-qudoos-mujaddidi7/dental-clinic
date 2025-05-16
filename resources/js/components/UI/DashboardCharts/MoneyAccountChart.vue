<script setup>
import * as echarts from "echarts";
import { onMounted, watch } from "vue";
import { useDashboardRepository } from "@/store/DashboardRepository";
let DashboardRepository = useDashboardRepository();

// Watch for changes in the data and update the chart
console.log("Month Incomes Data:", DashboardRepository.monthIncomes,'man');

watch(
    () => DashboardRepository.DashboardReport.netProfit,
    () => {
        updateChart();
    },
    { immediate: true }
);

async function updateChart() {
    // Create the echarts instance
    var myChart = echarts.init(document.getElementById("main"), null, {
        height: 200,
    });
    var option = {
        tooltip: {
            trigger: "item",
        },
        color: ["#B3C2D8", "#F3D9DA", "#BDD7FF", "#E4C9CA", "#DAF0FE"],
        series: [
            {
                name: "Top Selling Products",
                type: "pie",
                radius: "70%",
                center: ["50%", "50%"],
                data: DashboardRepository.monthIncomes,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 10,
                        shadowColor: "rgba(0, 0, 0, 0.5)",
                    },
                },
            },
        ],
    };

    if (option) {
        myChart.setOption(option);
    }
}

onMounted(updateChart);
</script>

<template>
    <div class="shadow-md bg-background py-7 px-4 mr-9">
        <p class="text-lg mb-4">{{$t('Money Account')}}</p>
        <canvas id="main"></canvas>
    </div>
</template>
