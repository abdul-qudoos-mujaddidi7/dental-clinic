<template>
    <CreateMainLabPayment v-if="LaboratoryRepository.mainLabCreatePaymentDialog" />
    <ShowMainLabPayment v-if="LaboratoryRepository.createDialog"/>
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl" :dir="dir">
            <AppBar
                :mainTitle="$t('inboundLaboratory')"
                :sub-title="$t('inboundLaboratory')"
            />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>

            <div class="btn-search pt-12 pb-6">
                <div class="text-field w-25">
                    <v-text-field
                        :loading="loading"
                        color="primaryOld"
                        density="compact"
                        variant="outlined"
                        :label="t('search')"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="LaboratoryRepository.laboratorySearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <router-link to="createMainLab">
                        <v-btn
                            color="primaryOld"
                            variant="flat"
                            :text="t('create')"
                            class="px-6"
                        >
                        </v-btn>
                    </router-link>
                </div>
            </div>

            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main" :dir="dir">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    :dir="dir"
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        LaboratoryRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="
                                        LaboratoryRepository.totalItems
                                    "
                                    :items="processedData"
                                    :loading="LaboratoryRepository.loading"
                                    :search="
                                        LaboratoryRepository.laboratorySearch
                                    "
                                    @update:options="
                                        LaboratoryRepository.FetchLaboratories
                                    "
                                    :item-key="
                                        LaboratoryRepository.laboratories
                                    "
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <template v-slot:item.details="{ item }">
                                        <span
                                            v-if="
                                                item.details &&
                                                item.details.length
                                            "
                                            >{{
                                                item.details[0].toothName
                                            }}</span
                                        >
                                        <span v-else>N/A</span>
                                    </template>

                                    <template v-slot:item.action="{ item }">
                                        <v-menu>
                                            <template
                                                v-slot:activator="{ props }"
                                            >
                                                <v-btn
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                    variant="text"
                                                ></v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        @click="
                                                            CreateDialog(
                                                                item
                                                            )
                                                        "
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi
                                                            mdi-cash-edit</v-icon
                                                        >
                                                        {{ t("createPayment") }}
                                                    </v-list-item-title>
                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        @click="
                                                            ViewPaymentDialog(
                                                                item
                                                            )
                                                        "
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi
                                                            mdi-cash-sync</v-icon
                                                        >
                                                        {{ t("showPayment") }}
                                                    </v-list-item-title>
                                                    <router-link
                                                        :to="`/updateMainLab/${item.id}`"
                                                    >
                                                        <v-list-item-title
                                                            class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        >
                                                            <v-icon
                                                                color="tealColor"
                                                                >mdi-square-edit-outline</v-icon
                                                            >
                                                            {{ t("edit") }}
                                                        </v-list-item-title>
                                                    </router-link>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item)
                                                        "
                                                    >
                                                        <v-icon color="error"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        {{ t("delete") }}
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                </v-data-table-server>
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import AppBar from "../../components/AppBar.vue";
import CreateMainLabPayment from "./payment/CreateMainLabPayment.vue";
import ShowMainLabPayment from "./payment/ShowMainLabPayment.vue";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useLaboratoryRepository } from "@/store/LaboratoryRepository";
const LaboratoryRepository = useLaboratoryRepository();

const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr";
});
// Bulk delete

const CreateDialog = (item) => {
    LaboratoryRepository.mainLabPaymentID = item.id;
   LaboratoryRepository.peopleId = item.peopleId
    
    LaboratoryRepository.paymentLab = {};
    LaboratoryRepository.setEditMode(false);
    LaboratoryRepository.mainLabCreatePaymentDialog = true;
};
const ViewPaymentDialog = (item) => {
    console.log(item.id, "payment id");
    const expenseId = item.id;
    LaboratoryRepository.mainLabPaymentID = item.id;
    // LaboratoryRepository.billExpensesPayments = {};
    // if (Object.keys(LaboratoryRepository.billExpensesPayments).length === 0) {
    LaboratoryRepository.FetchLabPayment(expenseId)
        .then(() => {
            LaboratoryRepository.createDialog = true;
        })
        .catch((error) => {
            console.error("Error fetching data: ", error);
        });
    // }
};
// Delete and update Create
const CreateDialogShow = () => {
    (LaboratoryRepository.laboratory = {}),
        LaboratoryRepository.setEditMode(false);
    LaboratoryRepository.createDialog = true;
    LaboratoryRepository.labId = id;
};

// Header
const headers = [
    { title: t("issueAt"), key: "issueAt", align: "start", sortable: false },

    {
        title: t("returnDate"),
        key: "returnDate",
        align: "start",
        sortable: false,
    },
    {
        title: t("grandTotal"),
        key: "grandTotal",
        align: "start",
        sortable: false,
    },

    { title: t("paid"), key: "paid", align: "start", sortable: false },
    { title: t("status"), key: "status", align: "start", sortable: false },
    {
        title: t("details"),
        key: "description",
        align: "start",
        sortable: false,
    },
    { title: t("action"), key: "action", align: "end", sortable: false },
];

// Preprocess the data to include toothName
const processedData = computed(() => {
    return LaboratoryRepository.laboratories.map((item) => {
        return {
            ...item,
            toothName:
                item.details && item.details.length
                    ? item.details[0].toothName
                    : "N/A",
        };
    });
});

const deleteItem = async (item) => {
    await LaboratoryRepository.DeleteLaboratory(item.id);
};
</script>
