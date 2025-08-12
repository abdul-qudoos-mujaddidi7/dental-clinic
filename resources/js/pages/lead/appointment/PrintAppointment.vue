<template>
  <div ref="printContent" class="p-6 bg-white text-black" dir="rtl">
    <!-- Header -->
    <div class="flex flex-col items-center border-b pb-4 text-center">
      <img src="/assets/logo.jpg" class="h-16 mb-2" alt="Logo" />
      <div>
        <h2 class="font-bold text-xl">کلینیک دندان پرسپویان</h2>
        <p class="text-sm text-gray-600">Parsapoyan Dental Clinic</p>
      </div>
    </div>

    <!-- Title -->
    <div class="flex justify-center pb-2">
      <h2 class="font-bold text-xl text-primaryOld">جزئیات ملاقات</h2>
    </div>

    <!-- Appointment Info -->
    <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-primaryOld">
      <div><strong>نام مریض:</strong> {{ appointment?.patients?.name }}</div>
      <div><strong>نام داکتر:</strong> {{ appointment?.dentists?.name }}</div>
      <div><strong>تاریخ ملاقات:</strong> {{ appointment?.date }}</div>
      <div><strong>زمان ملاقات:</strong> {{ appointment?.time }}</div>
      <div><strong>حالت ملاقات:</strong> {{ appointment?.status }}</div>
      <div><strong>اضافه شده توسط:</strong> {{ appointment?.userName }}</div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  appointment: Object, // داده‌های کامل ملاقات
});

const printContent = ref(null);

defineExpose({ printContent });
</script>

<style scoped>
[dir="rtl"] {
  text-align: right;
}

[dir="rtl"] .text-center {
  text-align: center;
}
</style>
