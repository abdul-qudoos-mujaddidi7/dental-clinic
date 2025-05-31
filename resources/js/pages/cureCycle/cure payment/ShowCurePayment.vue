<template>
    <UpdateExpensePayment v-if="CureRepository.updateDialog" />
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="55rem"
            v-model="CureRepository.ShowCurePaymentDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3 m-12">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2>&nbsp; Show Payment &nbsp;</h2>
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-spacer></v-spacer>
                    <hr />
                    <div class="d-flex flex-column body-2 px-8 py-12">
                        <v-table>
                            <thead>
                                <tr>
                                    <th class="text-start">Date</th>
                                    <th class="text-start">Amount</th>
                                  
                                    <th class="text-end pl-6">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- Loop through each payment in the billExpensesPayments array -->
                                <tr
                                    v-for="(
                                        payment, index
                                    ) in CureRepository.curePayments"
                                    :key="index"
                                    class="text-left"
                                >
                                    <td>
                                        {{ payment.date }}
                                    </td>
                                    <td>
                                        {{ payment.amount }}

                                        {{ payment.people?.currency }}
                                    </td>
                                 
                                    <!-- <td dir="ltr">
                                        {{ payment.note }}
                                    </td> -->
                                    <td class="text-end">
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
                                                        @click="
                                                            editItem(payment)
                                                        "
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon color="tealColor"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        Edit
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(payment)
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
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                    </div>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script setup>
// import { reactive, ref } from "vue";
import { useCureRepository } from "@/store/CureRepository";
const CureRepository = useCureRepository();
// import UpdateExpensePayment from "./UpdateExpensePayment.vue";

const deleteItem = async (payment) => {
    await CureRepository.DeleteCurePayment(payment.id);
};
// CureRepository.FetchBillExpensePayment();
const editItem = async (payment) => {
    CureRepository.isEditMode=true;
    // CureRepository.cureId = payment.id;
    CureRepository.curePayment = {};
    if (Object.keys(CureRepository.FetchCurePayment).length === 0) {
        CureRepository.FetchCurePayment(payment.id)
            .then(() => {
                CureRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data: ", error);
            });
    }
    // console.log(CureRepository.meterCyclePaymentId, id);
    // await CureRepository.fetchMeterCyclePaymentForUpdate(id);
};
</script>

