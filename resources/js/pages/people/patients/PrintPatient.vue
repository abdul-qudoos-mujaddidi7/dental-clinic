<template>
    <div ref="printContent" class="p-6 bg-white text-black" dir="rtl">
        <!-- Header -->
        <div class="flex flex-col items-center border-b pb-4 text-center">
            <img
                src="../../../../../public/assets/logo.jpg/"
                class="h-16 mb-2"
                alt="Logo"
            />
            <div>
                <h2 class="font-bold text-xl">کلینیک دندان پرسپویان</h2>
                <p class="text-sm text-gray-600">Parsapoyan Dental Clinic</p>
            </div>
        </div>
        <div class="flex justify-center pb-2">
            <h2 class="font-bold text-xl text-primaryOld">
                فرم ثبت نام بیمار/مریض کلینیک پرسپویان
            </h2>
        </div>

        <!-- Patient Info -->
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-primaryOld">
            <div><strong class="">نام:</strong> {{ patient.name }}</div>
            <div><strong>شماره تماس:</strong> {{ patient.phone }}</div>
            <div><strong>آدرس:</strong> {{ patient.address }}</div>
            <div><strong>تاریخ تولد:</strong> {{ patient.dateOfBirth }}</div>
            <div><strong>جنسیت:</strong> {{ patient.gender }}</div>
        </div>

        <!-- Medical Record -->
        <div class="mb-4 border-t pt-4">
            <h3 class="font-semibold mb-2 text-primaryOld">سوابق پزشکی</h3>
            <div class="grid grid-cols-2 gap-2 text-primary">
                <label
                    v-for="item in medicalLabels"
                    :key="item.key"
                    class="flex items-center gap-2"
                >
                    <input
                        type="checkbox"
                        disabled
                        :checked="parsedMedical[item.key]"
                    />
                    {{ item.label }}
                </label>
            </div>
        </div>

        <!-- Dental Record -->
        <div class="mb-4 border-t pt-4">
            <h3 class="font-semibold mb-2 text-primaryOld">
                سوابق دندان‌پزشکی
            </h3>
            <div class="grid grid-cols-2 gap-2 text-primary">
                <label
                    v-for="item in dentalLabels"
                    :key="item.key"
                    class="flex items-center gap-2"
                >
                    <input
                        type="checkbox"
                        disabled
                        :checked="parsedDental[item.key]"
                    />
                    {{ item.label }}
                </label>
            </div>
        </div>
        <div class="mb-4 border-t pt-4">
            <h3 class="font-semibold mb-2 text-primaryOld">رضایت و امضا</h3>
            <div class="grid grid-cols-2 gap-2 text-primary">
                <div class="text-right">
                    <p class="mb-4">
                        اینجانب __________،تایید میکنم که اطلاعات فوق صحیح است و مجوز
                        درمان را می دهم
                    </p>
                    <p class="mb-4">__________تاریخ</p>
                    <p>1/1</p>
                </div>
                <div>
                    <!-- Empty space for signature -->
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div
            class="border-t pt-4 mt-6 flex justify-between align-end text-xs "
        >
            <div class=" w-full bg-primaryOld text-white p-2">
                <footer> 
                    <span class="mdi mdi-map-marker">
                        {{ patient.systemAddress }}
                    </span> &nbsp; &nbsp; &nbsp;
                    <span class="mdi mdi-phone-in-talk-outline">{{ patient.phone }}</span>
                </footer>
            </div>
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
