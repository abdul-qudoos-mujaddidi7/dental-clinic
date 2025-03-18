<template>
    <AppBar :mainTitle="$t('profitLoss')" sub-title="reports" />

    <div class="pb-8">
    <v-row class="pt-12 ">
        <v-col class="">
            <v-card :subtitle="$t('allPayment')" hover>
                <v-card-text class="borderBT mb-4 mx-3">
                    {{ PeopleRepository.totalAllExpense }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col>
            <v-card :subtitle="$t('profit')" hover>
                <v-card-text class="borderBlue mb-4 mx-3">
                    {{ PeopleRepository.totalAllProfit }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col>
            <v-card :subtitle="$t('pickup')" hover>
                <v-card-text class="bordeRed mb-4 mx-3">
                    {{ PeopleRepository.totalAllPickup }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col>
            <v-card :subtitle="$t('pickup')" hover>
                <v-card-text class="bordeBlack mb-4 mx-3">
                    {{ PeopleRepository.totalAllPickup }}
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</div>
    <div class="w-full">
        <v-card
            class="px-6 rounded-lg"
             :dir="dir"
            variant="elevated"
            elevation="1"
        >
            <!-- Flight Group Details Tabs section  -->
            <v-tabs v-model="tab" color="primary">
                <v-tab value="earnings">{{ t("accounts") }} </v-tab>
                <v-tab value="Payment">{{ t("transfers") }} </v-tab>
            </v-tabs>
            <v-divider></v-divider>
            <v-window v-model="tab">
                <v-window-item value="earnings"><CreateAccSupp></CreateAccSupp> </v-window-item>
                <v-window-item value="Payment"><create-transfer-sup></create-transfer-sup> </v-window-item>
            </v-window>
        </v-card>
    </div>
</template>

<script setup>
import { ref,computed } from "vue";
import {usePeopleRepository} from '@/store/PeopleRepository'

import { useI18n } from "vue-i18n";
import CreateTransferSup from "./payment/CreateTransferSup.vue";
const { t, locale } = useI18n();
let tab = ref(null);
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

import AppBar from "../../../components/AppBar.vue";

const PeopleRepository = usePeopleRepository();
// PeopleRepository.fetchTotalReportsOfEarnings();
</script>

<style scoped>
.borderBT {
    border-bottom: 4px solid #112f53;
}
.borderGreen {
    border-bottom: 4px solid #00893f;
}
.borderBlue {
    border-bottom: 4px solid #0080ff;
}
.bordeRed {
    border-bottom: 4px solid #e54141;
}
.bordeBlack {
    border-bottom: 4px solid #000;
}
.card {
    /* background-color: green; */
    margin: 1.4rem;
    padding: 1.4rem;
}
</style>
