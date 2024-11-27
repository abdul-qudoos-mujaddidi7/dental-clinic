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
    // Create the echarts instance
    var myChart = echarts.init(document.getElementById("bar"), null, {
        width: 750,
        height: 300,
    });
    var option;
    var option = {
    title: [
   
        {
            text: "               درآمد و مصارف امسال ",
            right: "right",
            textStyle: {
                fontSize: 16,
                fontWeight: "bold",
                color: "#333",
                fontFamily: "Calibri, sans-serif",
             
            },
           
        },
    ],
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: "shadow",
        },
    },
    legend: {
       left:"left",
        data: [ "درآمد        ","مصارف",],
        textStyle: {
                fontSize: 16,
                fontWeight: "bold",
                color: "#333",
                fontFamily: "Calibri, sans-serif",
                

                
            },
    },
    toolbox: {
        show: false,
        orient: "vertical",
        left: "right",
        top: "center",
        feature: {
            mark: { show: true },
            magicType: { show: true, type: ["line", "bar", "stack"] },
            saveAsImage: { show: true },
        },
    },
    xAxis: [
        {
            type: "category",
            axisTick: { show: true },
            data: [
                "حمل", // Hamal
                "ثور", // Sawr
                "جوزا", // Jawza
                "سرطان", // Saratan
                "اسد", // Asad
                "سنبله", // Sonbola
                "میزان", // Mizan
                "عقرب", // Aqrab
                "قوس", // Qaws
                "جدی", // Jadi
                "دلو", // Dalwa
                "حوت", // Hoot
            ],
        },
    ],
    yAxis: [
        {
            type: "value",
        },
    ],
    series: [
   
        {
            name: "درآمد        ",
            type: "bar",
            barGap: 0,
            emphasis: {
                focus: "series",
            },
            color: "#112F5326",
            data: DashboardRepository.dashboards.earningMonths,
        },
        {
            name: "مصارف",
            type: "bar",
            barGap:0,

            emphasis: {
                focus: "series",
            },
            color: "#112F53",
            data: DashboardRepository.dashboards.expenseMonths,
        },
        
    ],
};

option && myChart.setOption(option);


    option && myChart.setOption(option);
}
onMounted(updateChart);
</script>

<template>
    <div class="shadow-md pt-8 bg-white rounded-xl d-flex justify-center">
        <canvas id="bar" style="width: 36rem"></canvas>
        
    </div>
</template>
