<template>
    <AppBar :mainTitle="$t('profitLoss')" sub-title="reports" />

    <div class="pb-2">
    <v-row class="pt-12 ">
        <v-col class="">
            <v-card :subtitle="$t('expenses')" hover>
                <v-card-text class="borderBT mb-4 mx-3">
                    {{ ReportRepository.totalAllExpense }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col>
            <v-card :subtitle="$t('profit')" hover>
                <v-card-text class="borderBlue mb-4 mx-3">
                    {{ ReportRepository.totalAllProfit }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col>
            <v-card :subtitle="$t('pickup')" hover>
                <v-card-text class="bordeRed mb-4 mx-3">
                    {{ ReportRepository.totalAllPickup }}
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</div>
    <div class="w-full">
        <v-card
            class="px-6 rounded-lg"
            dir="rtl"
            variant="elevated"
            elevation="1"
        >
            <!-- Flight Group Details Tabs section  -->
            <v-tabs v-model="tab" color="primary">
                <v-tab value="earnings">Sales </v-tab>
                <v-tab value="Payment">transfers </v-tab>
            </v-tabs>
            <v-divider></v-divider>
            <v-window v-model="tab">
                <v-window-item value="earnings">man </v-window-item>
                <v-window-item value="Payment">women </v-window-item>
            </v-window>
        </v-card>
    </div>
</template>

<script setup>
import { ref,computed } from "vue";
import { useReportRepository } from "@/store/ReportRepository";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
let tab = ref(null);

import AppBar from "../../../components/AppBar.vue";

const ReportRepository = useReportRepository();
ReportRepository.fetchTotalReportsOfEarnings();
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
.card {
    /* background-color: green; */
    margin: 1.4rem;
    padding: 1.4rem;
}
</style>
