<template>
    <UpdateExpensePayment v-if="LaboratoryRepository.createDialog" />
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="55rem"
            v-model="LaboratoryRepository.createDialog"
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
                                    <th class="text-start">Account</th>
                                    <th class="text-start">Details</th>
                                    <th class="text-end pl-6">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- Loop through each payment in the billExpensesPayments array -->
                                <tr
                                    v-for="(
                                        payment, index
                                    ) in LaboratoryRepository.paymentLab"
                                    :key="index"
                                    class="text-left"
                                >
                                    <td>
                                        {{ payment }}
                                    </td>
                                    <!-- <td>
                                            {{ payment.date }}
                                        </td> -->
                                    <td>
                                        <!-- {{ payment.amount }} -->

                                        <!-- {{ payment.people?.currency }} -->
                                    </td>
                                    <td dir="ltr">
                                        <!-- {{ payment.user?.name }} -->
                                    </td>
                                    <td dir="ltr">
                                        <!-- {{ payment.note }} -->
                                    </td>
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
                                                        <v-icon
                                                            color="tealColor"
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
import { useLaboratoryRepository } from "@/store/LaboratoryRepository";
const LaboratoryRepository = useLaboratoryRepository();

const deleteItem = async (payment) => {
    await LaboratoryRepository.DeleteLabPayment(payment.id);
};
// LaboratoryRepository.FetchBillExpensePayment();
const editItem = async (payment) => {
    LaboratoryRepository.isEditMode = true;
    // LaboratoryRepository.meterCyclePaymentId = id;
    LaboratoryRepository.setEditMode(true);
    LaboratoryRepository.paymentLab = {};
    if (Object.keys(LaboratoryRepository.FetchLabPayment).length === 0) {
        LaboratoryRepository.FetchLabPayment(payment.id)
            .then(() => {
                LaboratoryRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data: ", error);
            });
    }
    // console.log(LaboratoryRepository.meterCyclePaymentId, id);
    // await LaboratoryRepository.fetchMeterCyclePaymentForUpdate(id);
};

const headers = [
    { title: "عمل", key: "action", align: "center", sortable: false },
    {
        title: "شخص ",
        key: "account.name",
        align: "center",
        sortable: false,
    },
    { title: "مقدار ", key: "amount", align: "center", sortable: false },

    { title: "تاریخ", key: "date", align: "center", sortable: false },
];
</script>
