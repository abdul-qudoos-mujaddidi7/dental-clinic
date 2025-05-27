<template>
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl " rtl>
            <AppBar mainTitle="View Cure Cycle " sub-Title=" Cure Cycle " />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div class="pb-24">
                <div
                    class="border-t-2 border-b-2 border-dashed border-[#ECF1F4] mt-4 w-25 py-1 flex justify-between"
                >
                    <span>Date</span>
                    <span>{{ CureRepository.cure.start_date }}</span>
                </div>
                <div
                    class="border-b-2 border-dashed border-[#ECF1F4] w-25 py-1 flex justify-between"
                >
                    <span>patient</span>
                    <span>{{ CureRepository.cure.patient?.name }}</span>
                </div>
                <div
                    class="border-b-2 border-dashed border-[#ECF1F4] w-25 py-1 flex justify-between"
                >
                    <span>Doctor</span>
                    <span>{{ CureRepository.cure.dentist?.name }}</span>
                </div>
            </div>

            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-table>
                    <thead >
                        <tr
                           
                        >
                            <th class="text-lift">Service</th>
                            <th class="text-lift">Cost</th>
                            <th class="text-lift">QTY</th>
                            <th class="text-lift">Sub Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="text-lift"  v-for="index in CureRepository.cure.servicesDetails
                                "
                            :key="index.id">
                            <td>{{ index.serviceName }}</td>
                            <td>{{ index.cost }}</td>
                            <td>{{ index.quantity }}</td>
                            <td>{{ index.total }} AFG</td>
                        </tr>
                    </tbody>
                </v-table>
            </div>
           
            <div class="pt-24 flex  justify-space-between">
                <div class="">
                <span>Note:</span> <span>{{ CureRepository.cure.description }}</span>
            </div>
            <div class="w-25">
                <div
                    class="border-t-2 border-b-2 border-dashed border-[#ECF1F4] mt-4  py-1 flex justify-between"
                >
                    <span>Grand Total</span>
                    <span> {{ CureRepository.cure.grand_total }} AFG </span>
                </div>
                <div
                    class="border-b-2 border-dashed border-[#ECF1F4]  py-1 flex justify-between"
                >
                    <span>Paid </span>
                    <span> {{ CureRepository.cure.paid }} AFG </span>
                </div>
                <div
                    class="border-b-2 border-dashed border-[#ECF1F4]  py-1 flex justify-between"
                >
                    <span>Due</span>
                    <span> {{ CureRepository.cure.due }} AFG </span>
                </div>
            </div>
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
console.log(CureRepository.cure, "this is what i nedd ");
// delete and update
const deleteItem = async (item) => {
    await CureRepository.DeleteCure(item.id);
};
</script>
