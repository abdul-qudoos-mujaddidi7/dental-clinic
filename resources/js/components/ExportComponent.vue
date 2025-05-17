<template>
    <div>
        <v-btn :disabled="isExporting" @click="exportToPDF" :color="btnColor">
            {{ isExporting ? "Exporting..." : fileName }}
        </v-btn>

        <div
            ref="pdfTable"
            :class="{ hidden: !isExporting, 'export-table': isExporting }"
            dir="rtl"
        >
            <!-- Heading Section -->
            <div
                :class="{
                    hidden: fileName !== 'Meter Reading List',
                    'export-heading': true,
                }"
            >
                <h3>
                    {{
                        `Meter Reading List for Junction ${junction}, from Box ${fromBox} to Box ${toBox}, Reading Period: ${period}, Print Date: ${printDate}`
                    }}
                </h3>
            </div>

            <div
                :class="{
                    hidden: fileName !== 'Meter Reading Report',
                    'export-heading': true,
                }"
            >
                <h3>
                    {{
                        `Reading Report for Junction ${junction}, from Box ${fromBox} to Box ${toBox}, Period: ${period}, Reading Date: ${date}, Price per kW: ${kwPrice}, Maintenance: ${maintenanceCosts}`
                    }}
                </h3>
            </div>

            <div
                :class="{
                    hidden: fileName !== 'Commitment PDF Report',
                    'export-heading': true,
                }"
            >
                <h3>Subscribers Commitment Report</h3>
            </div>

            <!-- Table -->
            <table class="styled-table">
                <thead>
                    <tr>
                        <th v-for="(header, key) in fields" :key="key">
                            {{ header }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in tableData" :key="index">
                        <td
                            v-for="(header, key) in fields"
                            :key="key"
                            :style="key === 'initialAmount' ? { color: item.color } : {}"
                        >
                            {{ item[key] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, nextTick } from "vue";
import html2pdf from "html2pdf.js";

const pdfTable = ref(null);
const isExporting = ref(false);

const props = defineProps({
    tableData: Array,
    fields: Object,
    fileName: String,
    junction: String,
    fromBox: String,
    toBox: String,
    date: String,
    period: String,
    maintenanceCosts: String,
    kwPrice: String,
    btnColor: String,
    printDate: {
        type: String,
        default: new Date().toLocaleDateString("fa-IR"),
    },
});

const exportToPDF = async () => {
    if (pdfTable.value) {
        try {
            isExporting.value = true;
            await nextTick();

            await html2pdf()
                .from(pdfTable.value)
                .set({
                    margin: [10, 10, 10, 10],
                    filename: `${props.fileName}.pdf`,
                    image: { type: "jpeg", quality: 1 },
                    html2canvas: { scale: 3, useCORS: true },
                    jsPDF: {
                        unit: "mm",
                        format: "a4",
                        orientation: "landscape",
                    },
                })
                .save();
        } catch (error) {
            console.error("PDF export failed", error);
        } finally {
            isExporting.value = false;
        }
    }
};
</script>

<style scoped>
.hidden {
    visibility: hidden;
    position: absolute;
    left: -9999px;
}
.export-table {
    direction: rtl;
    font-family: "Tahoma", sans-serif;
    background: white;
    padding: 15px;
}
.export-heading {
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 10px;
}
.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    margin-top: 25px;
}
.styled-table th,
.styled-table td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}
.styled-table thead {
    background-color: #dce6f1;
    font-weight: bold;
}
</style>
