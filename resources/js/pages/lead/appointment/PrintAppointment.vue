<template>
  <div class="print-wrapper">
    <div class="print-content">
      <h2 class="title">{{ $t("appointmentDetails") }}</h2>
      <p><strong>{{ $t("patient") }}:</strong> {{ appointment.patients?.name }}</p>
      <p><strong>{{ $t("doctor") }}:</strong> {{ appointment.dentists?.name }}</p>
      <p><strong>{{ $t("date") }}:</strong> {{ appointment.date }}</p>
      <p><strong>{{ $t("time") }}:</strong> {{ appointment.time }}</p>
      <p><strong>{{ $t("status") }}:</strong> {{ appointment.status }}</p>
      <p><strong>{{ $t("addedBy") }}:</strong> {{ appointment.userName }}</p>
    </div>
  </div>
</template>


<script setup>
import { onMounted, ref } from 'vue';
const props = defineProps({ appointment: Object });
const emit = defineEmits(['close']);

onMounted(() => {
  setTimeout(() => {
    window.print();
    emit('close');
  }, 300);
});
</script>
<style>
.print-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: white;
  z-index: 999999;
  padding: 0;
  margin: 0;
  display: block;
  font-family: sans-serif;
}

.print-content {
  width: 100%;
  max-width: 700px;
  /* margin: 0 auto; */
  padding: 20mm;
  padding-left: 10;
  font-size: 16pt;
}

.title {
  text-align: center;
  font-weight: bold;
  font-size: 20pt;
  margin-bottom: 20px;
}

/* Fix print layout */
@media print {
  body * {
    visibility: hidden;
  }

  .print-wrapper,
  .print-wrapper * {
    visibility: visible;
  }

  .print-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: auto;
    padding: 0;
  }

  @page {
    size: A4 portrait;
    margin: 15mm;
  }
}
</style>
