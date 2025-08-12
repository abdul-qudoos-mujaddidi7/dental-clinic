<template>
  <div class="all-expense rounded-xl m-4">
    <!-- ✅ AppBar فقط برای صفحه، نه برای PDF -->
    <AppBar mainTitle="View Cure Cycle" sub-Title="Cure Cycle" />

    <div ref="printSection" class="card rounded-xl mt-4" rtl>
      <v-divider :thickness="1" class="border-opacity-100" color="success" />

      <!-- ✅ Cure Info -->
      <div class="pb-24">
        <div class="border-t-2 border-b-2 border-dashed border-[#ECF1F4] mt-4 w-25 py-1 flex justify-between">
          <span>Date</span>
          <span>{{ CureRepository.cure.start_date }}</span>
        </div>
        <div class="border-b-2 border-dashed border-[#ECF1F4] w-25 py-1 flex justify-between">
          <span>patient</span>
          <span>{{ CureRepository.cure.patient?.name }}</span>
        </div>
        <div class="border-b-2 border-dashed border-[#ECF1F4] w-25 py-1 flex justify-between">
          <span>Doctor</span>
          <span>{{ CureRepository.cure.dentist?.name }}</span>
        </div>
      </div>

      <!-- ✅ Services Table -->
      <div class="overflow-x-hidden">
        <v-table>
          <thead>
            <tr>
              <th class="text-left">Service</th>
              <th class="text-left">Cost</th>
              <th class="text-left">QTY</th>
              <th class="text-left">Sub Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="index in CureRepository.cure.servicesDetails" :key="index.id">
              <td>{{ index.serviceName }}</td>
              <td>{{ index.cost }}</td>
              <td>{{ index.quantity }}</td>
              <td>{{ index.total }} AFG</td>
            </tr>
          </tbody>
        </v-table>
      </div>

      <!-- ✅ Notes & Totals -->
      <div class="pt-24 flex justify-space-between">
        <div>
          <span>Note:</span> <span>{{ CureRepository.cure.description }}</span>
        </div>
        <div class="w-25">
          <div class="border-t-2 border-b-2 border-dashed border-[#ECF1F4] mt-4 py-1 flex justify-between">
            <span>Grand Total</span>
            <span>{{ CureRepository.cure.grand_total }} AFG</span>
          </div>
          <div class="border-b-2 border-dashed border-[#ECF1F4] py-1 flex justify-between">
            <span>Paid</span>
            <span>{{ CureRepository.cure.paid }} AFG</span>
          </div>
          <div class="border-b-2 border-dashed border-[#ECF1F4] py-1 flex justify-between">
            <span>Due</span>
            <span>{{ CureRepository.cure.due }} AFG</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Download Button -->
    <div class="mt-4 text-left">
      <button
        @click="downloadPDF"
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded"
      >
        Download Cure Cycle PDF
      </button>
    </div>
  </div>
</template>

<script setup>
import { useCureRepository } from "@/store/CureRepository";
import html2pdf from "html2pdf.js";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import AppBar from "../../../components/AppBar.vue";

const CureRepository = useCureRepository();
const route = useRoute();
const printSection = ref(null);

onMounted(() => {
  CureRepository.FetchCure(route.params.id);
});
onMounted(() => {
  CureRepository.FetchCure(route.params.id);

  if (route.query.print === "true") {
    setTimeout(() => {
      window.print();
    }, 1000); // small delay to allow data to render
  }
});


const downloadPDF = () => {
  html2pdf()
    .from(printSection.value)
    .set({
      margin: 0.5,
      filename: `Cure_Cycle_${CureRepository.cure.patient?.name || "Unknown"}.pdf`,
      html2canvas: { scale: 2 },
      jsPDF: { unit: "in", format: "a4", orientation: "portrait" },
    })
    .save();
};
</script>
