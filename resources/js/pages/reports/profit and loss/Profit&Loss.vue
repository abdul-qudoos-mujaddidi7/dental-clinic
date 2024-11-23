<template>
    <AppBar mainTitle="Profit & Loss" sub-title="reports" />

    <v-row class="pt-12">
        <v-col>
            <v-card subtitle="Expense" hover>
                <v-card-text class="borderBT mb-4 mx-3">
                    {{ ReportRepository.totalAllExpense }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col>
            <v-card subtitle="Net Profit" hover>
                <v-card-text class="borderBlue mb-4 mx-3">
                    {{ ReportRepository.totalAllProfit }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col>
            <v-card subtitle="Pickup" hover>
                <v-card-text class="bordeRed mb-4 mx-3">
                    {{ ReportRepository.totalAllPickup }}
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script setup>
import { useReportRepository } from "@/store/ReportRepository";
// ignore
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