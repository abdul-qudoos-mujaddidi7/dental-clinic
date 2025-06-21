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

        <div class="flex justify-center pb-2">
            <h2 class="font-bold text-xl text-primaryOld">دوره درمان</h2>
        </div>

        <!-- Cure Info -->
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-primaryOld">
            <div><strong>تاریخ شروع:</strong> {{ cure?.start_date }}</div>
            <div><strong>نام مریض:</strong> {{ cure?.patient?.name }}</div>
            <div><strong>دکتر معالج:</strong> {{ cure?.dentist?.name }}</div>
        </div>

        <!-- Services -->
        <div class="mb-6 border-t pt-4">
            <h3 class="font-semibold mb-2 text-primaryOld">لیست خدمات</h3>
            <div class="overflow-x-hidden mt-6">
                <table class="w-full border text-sm ">
                    <thead>
                        <tr>
                            <th class="text-right p-2 border">خدمت</th>
                            <th class="text-right p-2 border">قیمت</th>
                            <th class="text-right p-2 border">تعداد</th>
                            <th class="text-right p-2 border">مجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(service, index) in cure?.servicesDetails || []"
                            :key="index"
                            
                        >
                            <td class="p-2 border">{{ service.serviceName }}</td>
                            <td class="p-2 border">{{ service.cost }}</td>
                            <td class="p-2 border">{{ service.quantity }}</td>
                            <td class="p-2 border">{{ service.total }} AFG</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Note and Totals -->
        <div class="flex justify-between pt-4 text-sm">
            <div>
                <strong>یادداشت:</strong>
                <p>{{ cure?.description }}</p>
            </div>
            <div class="space-y-2 text-primaryOld">
                <div><strong>جمع کل:</strong> {{ cure?.grand_total }} AFG</div>
                <div><strong>پرداخت شده:</strong> {{ cure?.paid }} AFG</div>
                <div><strong>باقی:</strong> {{ cure?.due }} AFG</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineExpose, ref } from "vue";

const printContent = ref(null);

const props = defineProps({
    cure: Object, // full cure data already fetched
});

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
