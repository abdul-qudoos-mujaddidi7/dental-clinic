<template>
  <div ref="printContent" class="p-6 bg-white text-black" dir="rtl">
    <!-- Header -->
    <div class="flex flex-col items-center border-b pb-4 mb-4 text-center">
      <img src="../../../../../public/assets/logo.jpg/" class="h-16 mb-2" alt="Logo" />
      <div>
        <h2 class="font-bold text-xl">کلینیک دندان پرساپویان</h2>
        <p class="text-sm text-gray-600">Parsapoyan Dental Clinic</p>
      </div>
    </div>

    <!-- Patient Info -->
    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
      <div><strong>نام:</strong> {{ patient.name }}</div>
      <div><strong>شماره تماس:</strong> {{ patient.phone }}</div>
      <div><strong>آدرس:</strong> {{ patient.address }}</div>
      <div><strong>تاریخ تولد:</strong> {{ patient.dateOfBirth }}</div>
      <div><strong>جنسیت:</strong> {{ patient.gender }}</div>
    </div>

    <!-- Medical Record -->
    <div class="mb-4 border-t pt-4">
      <h3 class="font-semibold mb-2">سوابق پزشکی</h3>
      <div class="grid grid-cols-2 gap-2">
        <label v-for="item in medicalLabels" :key="item.key" class="flex items-center gap-2">
          <input type="checkbox" disabled :checked="parsedMedical[item.key]" />
          {{ item.label }}
        </label>
      </div>
    </div>

    <!-- Dental Record -->
    <div class="mb-4 border-t pt-4">
      <h3 class="font-semibold mb-2">سوابق دندان‌پزشکی</h3>
      <div class="grid grid-cols-2 gap-2">
        <label v-for="item in dentalLabels" :key="item.key" class="flex items-center gap-2">
          <input type="checkbox" disabled :checked="parsedDental[item.key]" />
          {{ item.label }}
        </label>
      </div>
    </div>

    <!-- Footer -->
    <div class="border-t pt-4 mt-6 flex justify-between text-xs text-gray-600">
      <span>ریکارد دندان</span>
      <span>ریکارد مریض</span>
    </div>
  </div>
</template>


<script setup>
import { computed } from "vue";
const props = defineProps({
  patient: Object,
});

// These match the same key names created in your form
const medicalLabels = [
  { key: "diabetes", label: "دیابت" },
  { key: "blood_pressure", label: "فشار خون " },
  { key: "heart_disease", label: "بیماری قلبی" },
  { key: "asthma", label: "آسم" },
  { key: "allergies", label: "آلرژی" },
  { key: "others", label: "سایر" },
];

const dentalLabels = [
  { key: "have_a_toothache?", label: "آیا دندان درد دارید؟ " },
  { key: "bleeding_gums?", label: "خون ریزی لثه ؟" },
];

// Parse JSON fields (with fallback if null)
const parsedMedical = computed(() => {
  try {
    return JSON.parse(props.patient.medicalRecord || "{}");
  } catch {
    return {};
  }
});
const parsedDental = computed(() => {
  try {
    return JSON.parse(props.patient.dentalRecord || "{}");
  } catch {
    return {};
  }
});
</script>

<style scoped>

input[type="checkbox"]:disabled {
  accent-color: #0d9488;
  cursor: not-allowed;
}

/* RTL overrides if needed */
[dir="rtl"] {
  text-align: right;
}

[dir="rtl"] .text-center {
  text-align: center;
}

</style>
