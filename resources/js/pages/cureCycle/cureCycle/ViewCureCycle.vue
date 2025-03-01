<template>
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <AppBar mainTitle=" فروشات  " sub-Title=" نمایش فروش " />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div>
        <!-- First Row: Name -->
        <v-row class="custom-row" dir="rtl">
            <v-col cols="2">
                <span class="text-GreenLight">{{
                    CureRepository.cure.people?.name
                }}</span>
            </v-col>
        </v-row>

        <!-- Second Row: Phone -->
        <v-row class="custom-row" dir="rtl">
            <v-col cols="1">
                <span>شماره تماس:</span>
            </v-col>
            <v-col cols="2">
                <span>{{ CureRepository.cure.people?.phone }}</span>
            </v-col>
        </v-row>

        <v-row class="custom-row" dir="rtl">
            <v-col cols="1">
                <span>آدرس:</span>
            </v-col>
            <v-col cols="">
                <span>{{ CureRepository.cure.people?.address }}</span>
            </v-col>
        </v-row>

        <!-- Third Row: Date -->
        <v-row class="custom-row" dir="rtl">
            <v-col cols="1">
                <span>تاریخ:</span>
            </v-col>
            <v-col cols="2">
                <span>{{ CureRepository.cure?.date }}</span>
            </v-col>
        </v-row>

        <!-- Fourth Row: Currency -->
        <v-row class="custom-row" dir="rtl">
            <v-col cols="1">
                <span>حساب:</span>
            </v-col>
            <v-col cols="2">
                <span>{{ CureRepository.cure.currency?.name }}</span>
                : &nbsp;
                <span>{{ CureRepository.cure.currency?.symbol}}</span>
            </v-col>
        </v-row>
    </div>

            <!-- Fifth Row: Add any other information here -->

            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <div class="overflow-x-auto pb-6 table">
                                    <table
                                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 bg-blue-darken-500 w-100"
                                        dir="rtl"
                                    >
                                        <thead
                                            dir="rtl"
                                            class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 thead"
                                        >
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-center"
                                                    dir="rtl"
                                                >
                                                    محصول
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-center"
                                                >
                                                    تعداد/مقدار
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-center"
                                                >
                                                    قیمت فی‌واحد
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-center"
                                                >
                                                    تخفیف
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-center"
                                                >
                                                    مجموع پول
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class=""
                                                v-for="cureDetail in CureRepository
                                                    .cure.cureDetails"
                                                :key="cureDetail.id"
                                            >
                                                <td
                                                    class="px-3 py-3 text-center"
                                                >
                                                    {{
                                                        cureDetail.product
                                                            .name
                                                    }}
                                                    
                                                </td>

                                                <td
                                                    class="py-3 px-2 pt-8 text-center flex-row justify-"
                                                    dir="rtl"
                                                >
                                                    {{ cureDetail.quentity }}
                                                    {{ cureDetail.product.unit }}
                                                
                                                </td>

                                                <td
                                                    class="py-3 px-2 pt-8 create-input text-center"
                                                    dir="auto"
                                                >
                                                    {{ cureDetail.price }}
                                                </td>
                                                <td
                                                    class="py-3 px-2 pt-8 create-input text-center"
                                                    dir="auto"
                                                >
                                                    {{ cureDetail.discount }}
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="bg-[#ecf1f4] relative top-0 left-0 text-right"
                                                        dir="ltr"
                                                        >{{
                                                            cureDetail.total
                                                        }}</span
                                                    >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </v-col>
                        </v-row>
                        <div dir="rtl">
                            <table class="custom-table">
                                <tr>
                                    <td>مجموع:</td>
                                    <td>
                                        {{ CureRepository.cure.subTotal }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>تخفیف:</td>
                                    <td>
                                        {{ CureRepository.cure.discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>مبلغ نهایی:</td>

                                    <td>
                                        {{
                                            CureRepository.cure.grandTotal
                                        }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div dir="rtl" class="mt-32 pr-4 pt-12">
                            <span>
                                جزئيات: {{ CureRepository.cure.note }}
                            </span>
                        </div>
                        <div dir="rtl" class="mt-32 pr-4 pt-12">
                            <span>
                                ایجاد شده توسط: {{ CureRepository.cure.addedBy?.name }}
                            </span>
                        </div>
                        

                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useCureRepository } from "@/store/CureRepository";
const CureRepository = useCureRepository();

// ignore

import AppBar from "../../../components/AppBar.vue";
import { useRoute } from "vue-router";

const route = useRoute();

CureRepository.FetchCure(route.params.id);
// delete and update
const deleteItem = async (item) => {
    await CureRepository.Deletecure(item.id);
};
</script>

<style scoped>

.custom-row {
    margin-top: 0rem; /* Adjust this value to control the vertical space */
}
.card {
    /* background-color: green; */
    margin: 1.4rem;
    padding: 1.4rem;
}
.all-expense {
    width: 83.2%;
}
.v-table > :nth-child(2) {
    justify-content: space-evenly;
}
.v-table > :nth-child(2) > :nth-child(1) {
    direction: ltr;
}
.v-table > :nth-child(2) > :nth-child(2) {
    width: 47rem;
    align-self: center;
}
/* .product-table {
    display: flex;
    justify-content: space-between;
    background-color: #ecf1f4;
    border-right: 4px solid #fecd07;
}
.thead {
    border-right: 4px solid #fecd07;
    background-color: #ecf1f4;
} */
</style>
