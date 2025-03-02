<template>
    <CurePyament v-if="CureRepository.createDialog"/>
    <ShowCurePayment v-if="CureRepository.ShowCurePaymentDialog"/>
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
            <AppBar mainTitle="Cure Cycle" sub-title="cure Cycle" />
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
                        label="Search ..."
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="CureRepository.curesSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        Filter
                    </v-btn>
                    &nbsp;
                    <router-link to="/createCure">
                        <v-btn
                            color="primaryOld"
                            variant="flat"
                            text="Create"
                            class="px-6"
                        >
                        </v-btn>
                    </router-link>
                </div>
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        CureRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="CureRepository.totalItems"
                                    :items="CureRepository.cures"
                                    :loading="CureRepository.loading"
                                    :search="CureRepository.curesSearch"
                                    @update:options="CureRepository.FetchCures"
                                    :item-key="CureRepository.cures"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Checkbox for selecting rows -->

                                    <template v-slot:item.checkbox="{ item }">
                                        <v-checkbox
                                            :value="item.id"
                                            v-model="selectedIds"
                                            class="w-10 d-flex"
                                        ></v-checkbox>
                                    </template>
                                    <template
                                        v-slot:item.paymentStatus="{ item }"
                                    >
                                        <span
                                            :class="
                                                getPaymentStatusClass(
                                                    item.paymentStatus
                                                )
                                            "
                                        >
                                            {{ item.paymentStatus }}
                                        </span>
                                    </template>
                                    <template v-slot:item.due="{item}">
                                        <span class="text-[#E54141]">{{item.due}}</span>

                                    </template>

                                    <template
                                        v-slot:item.status="{ item }"
                                    >
                                        <span
                                            :class="
                                                getStatusClass(
                                                    item.status
                                                )
                                            "
                                        >
                                            {{ item.status }}
                                        </span>
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
                                                            CreateDialogShow(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi
                                                            mdi-cash-edit</v-icon
                                                        >
                                                        Create Payment
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
                                                        Show Payment
                                                    </v-list-item-title>
                                                    <router-link
                                                        :to="
                                                            '/updateCure/' +
                                                            item.id
                                                        "
                                                    >
                                                        <v-list-item-title
                                                            class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        >
                                                            <v-icon
                                                                color="tealColor"
                                                                >mdi-square-edit-outline</v-icon
                                                            >
                                                            Edit
                                                        </v-list-item-title>
                                                    </router-link>
                                                    <router-link
                                                        :to="
                                                            '/viewCureCycle/' +
                                                            item.id
                                                        "
                                                    >
                                                        <v-list-item-title
                                                            class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        >
                                                            <v-icon
                                                                color="tealColor"
                                                                >mdi-square-edit-outline</v-icon
                                                            >
                                                            View Cure 
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
                                                        Delete
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                </v-data-table-server>
                                <v-btn
                                    class="header-button"
                                    v-if="selectedIds.length > 0"
                                    @click="sendSelectedIds"
                                    color="#B71C1C"
                                    text="Delete"
                                    flat
                                >
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CurePyament from "../cure payment/CurePyament.vue";
import ShowCurePayment from "../cure payment/ShowCurePayment.vue";

import { useCureRepository } from "@/store/CureRepository";
const CureRepository = useCureRepository();
// bulk delete
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            billExpenseIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        CureRepository.bulkDeleteBillExpense(data);
    } else {
        console.log("No IDs selected.");
    }
};
const deleteItem = async (item) => {
    await CureRepository.DeleteCure(item.id);
};
// create payment
const CreateDialogShow = (id) => {
    CureRepository.cureId = id;

    CureRepository.curePayment = {};
    CureRepository.setEditMode(false);
    CureRepository.createDialog = true;
};

const ViewPaymentDialog = (item) => {
    console.log(item.id, "payment id");
    const cureID = item.id;
    CureRepository.paymentId = item.id;
    CureRepository.cureId = item.id;

    // CureRepository.billExpensesPayments = {};
    // if (Object.keys(CureRepository.billExpensesPayments).length === 0) {
    CureRepository.FetchCurePayments(cureID)
        .then(() => {
            CureRepository.ShowCurePaymentDialog = true;
        })
        .catch((error) => {
            console.error("Error fetching data: ", error);
        });
    // }
};
// change the color 
function getPaymentStatusClass(status) {
  const statusClasses = {
    DUE: 'text-[#E54141]  font-bold',
    PAID: 'text-[#00893F] font-bold',
    PARTIAL: 'text-[#EC942C] font-bold',
  };
  return statusClasses[status] || 'text-[#000000]'; // Default fallback
}
function getStatusClass(state) {
  const status = {
    completed: 'text-[#E54141]  font-bold',
    ongoing: 'text-[#00893F] font-bold',
    new: 'text-[#EC942C] font-bold',
  };
  return status[state] || 'text-[#000000]'; // Default fallback
}
// header
const headers = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: "Reference", key: "reference", align: "center", sortable: false },
    { title: "Date", key: "start_date", align: "start", sortable: false },
    { title: "Doctor", key: "dentist.name", align: "start", sortable: false },
    { title: "patient", key: "patient.name", align: "center", sortable: false },
    {
        title: "CURE STATUS",
        key: "status",
        align: "center",
        sortable: false,
    },
    {
        title: "Grand total",
        key: "grand_total",
        align: "center",
        sortable: false,
    },
    { title: "PAID", key: "paid", align: "center", sortable: false },
    { title: "DUE", key: "due", align: "center", sortable: false },
    {
        title: "Payment Status",
        key: "paymentStatus",
        align: "center",
        sortable: false,
    },

    { title: "Action", key: "action", align: "center", sortable: false },
];
</script>

<style scoped>
.v-data-table-server {
    position: relative;
}
.header-button {
    position: absolute;
    top: 0.7rem;
    left: 0.7rem;
    z-index: 1;
}
</style>
