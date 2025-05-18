<template>
  <div>
    <!-- Optional download button if showButton is true -->
    <v-btn
      v-if="showButton"
      :disabled="isExporting"
      @click="exportToPDF"
      :color="btnColor"
    >
      {{ isExporting ? "Exporting..." : fileName }}
    </v-btn>

    <!-- Visible PDF Preview -->
    <div
      ref="pdfTable"
      class="export-table"
      dir="rtl"
    >
      <div class="export-heading">
        <h3>{{ fileName }}</h3>
      </div>

      <table class="styled-table">
        <thead>
          <tr>
            <th v-for="(header, key) in fields" :key="key">{{ header }}</th>
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
import { ref, defineExpose, defineProps, nextTick } from "vue";
import html2pdf from "html2pdf.js";

const pdfTable = ref(null);
const isExporting = ref(false);


const props = defineProps({
  tableData: Array,
  fields: Object,
  fileName: String,
  btnColor: String,
  showButton: {
    type: Boolean,
    default: true,
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
defineExpose({ exportToPDF });

</script>
<style scoped>
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
