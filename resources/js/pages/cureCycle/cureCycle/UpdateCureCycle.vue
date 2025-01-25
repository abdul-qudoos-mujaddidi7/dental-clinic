<template>
    <CReateExpensePRoduct v-if="CureRepository.createDialog" />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <AppBar mainTitle="Create Cure Cycle" subTitle="cure cycle" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-form ref="formRef" class="d-flex pt-12">
                <v-text-field
                    type="date"
                    v-model="formData.startDate"
                    variant="outlined"
                    label="Date *"
                    class="pr-2"
                    style="width: 45%"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>

                <v-autocomplete
                    v-model="formData.patientId"
                    :items="CureRepository.patientsFor"
                    :return-object="false"
                    variant="outlined"
                    label="Patient *"
                    class="pr-2 pl-2"
                    style="width: 45%"
                    item-value="id"
                    item-title="name"
                    density="compact"
                    :rules="[rules.required]"
                ></v-autocomplete>

                <v-autocomplete
                    v-model="formData.dentistId"
                    :items="CureRepository.doctorFor"
                    :return-object="false"
                    variant="outlined"
                    label="Doctor *"
                    class="pr-2 pl-2"
                    style="width: 45%"
                    item-value="id"
                    item-title="firstName"
                    density="compact"
                    :rules="[rules.required]"
                ></v-autocomplete>
                <v-autocomplete
                    v-model="formData.status"
                    :items="CureRepository.leadStageFor"
                    :return-object="false"
                    variant="outlined"
                    label="Status *"
                    class="pr-2 pl-2"
                    style="width: 45%"
                    item-value="name"
                    item-title="name"
                    density="compact"
                    :rules="[rules.required]"
                ></v-autocomplete>
            </v-form>
            <v-divider></v-divider>
            <v-row no-gutters class="justify-space-between mt-16">
                <v-col cols="full" class="w-50" sm="12" md="12">
                    <div class="d-flex">
                        <v-text-field
                            v-model="CureRepository.billExpenseSearch"
                            @keyup.enter="CureRepository.SearchFetchData"
                            @input="CureRepository.SearchFetchData"
                            @click:clear="clearSearch"
                            variant="outlined"
                            label="Search Services"
                            density="compact"
                            append-inner-icon="mdi-magnify"
                            clearable
                            class="border-none"
                        ></v-text-field>
                    </div>
                    <div
                        class="rounded shadow-lg px-5 mb-12"
                        v-if="CureRepository.searchFetch.length > 0"
                    >
                        <div>
                            <div
                                v-for="index in CureRepository.searchFetch"
                                :key="index"
                            >
                                <p
                                    @click="CalcFetchProduct(index)"
                                    class="cursor-pointer px-4 p-1.5 hover-bg hover:text-bold selected-item"
                                >
                                    {{ index.name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </v-col>
                <table
                    class="text-sm text-center"
                    density="compact"
                    style="width: 150rem"
                >
                    <thead class="text-xs text-gray-700 uppercase thead">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-start">#</th>
                            <th scope="col" class="px-3 py-3 text-start">
                                Service
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                Qty
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                Cost
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                Status
                            </th>
                            <th scope="col" class="px-3 py-3 text-center">
                                Sub Total
                            </th>
                            <th scope="col" class="px-3 py-3 text-end">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="product-table"
                            v-for="(pro, index) in combinedServices"
                            :key="index"
                        >
                            <td class="pl-3 text-start">{{ index + 1 }}</td>
                            <td class="pl-3 text-start">
                                {{ pro.serviceName || pro.name }}
                            </td>
                            <td class="pt-2 text-center pb-0 w-[14rem]">
                                <v-text-field
                                    v-model="pro.quantity"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                ></v-text-field>
                            </td>
                            <td class="pt-2 pb-0 text-center w-[14rem]">
                                <v-text-field
                                    v-model="pro.cost"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                ></v-text-field>
                            </td>
                            <td class="pt-2 text-center pb-0 w-[14rem]">
                                <v-autocomplete
                                    :items="['complete', 'start']"
                                    v-model="pro.status"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                ></v-autocomplete>
                            </td>
                            <td class="text-center">
                                <span>{{ multiple(pro) }}</span>
                            </td>
                            <td class="px-3 text-end">
                                <v-icon
                                    color="red"
                                    @click="removeProduct(pro)"
                                    class="mdi mdi-trash-can-outline"
                                ></v-icon>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </v-row>

            <div
                class="pt-12 w-100 flex justify-space-between items-center"
                dir="rtl"
            >
                <div
                    class="flex justify-between w-[14rem] border-t-[.1rem] border-b-[.1rem] border-dashed border-[#C6C6C6] p-1 text-lg font-bold"
                >
                    <span>{{ totalSum }}</span>
                    <span>Total</span>
                </div>

                <div>
                    <v-text-field
                        v-model="formData.paid"
                        variant="outlined"
                        label="Paid"
                        type="number"
                        density="compact"
                    >
                    </v-text-field>
                </div>
            </div>

            <div class="pt-16">
                <v-textarea
                    v-model="formData.note"
                    class="textArea"
                    label="Details"
                    variant="outlined"
                    density="compact"
                >
                </v-textarea>
            </div>
            <div class="d-flex flex-row-reverse mt-6">
                <v-btn color="#112F53" @click="update"> Submit</v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppBar from "../../../components/AppBar.vue";
import { reactive, computed, ref, watch, onMounted } from "vue";
import { useRoute } from "vue-router";


import { useCureRepository } from "@/store/CureRepository";

const CureRepository = useCureRepository();
const CalcFetchProduct = (index) => {
    console.log(index, "man of the match");
    CureRepository.fetchProduct(index.id);
    clearSearch();
};

// ======================
const clearSearch = () => {
    CureRepository.billExpenseSearch = "";
    CureRepository.searchFetch = [];
};

const removeProduct = async (index, serviceId) => {
    try {
        // Send the serviceId to the backend
        const response = await CureRepository.DeleteCure(serviceId);

        // Only remove from the table if the backend deletion is successful
        if (response && response.status === 200) {
            this.services.splice(index, 1); // Remove from table reactively
            console.log(`Removed product with serviceId: ${serviceId}`);
        } else {
            console.error(
                `Failed to delete product with serviceId: ${serviceId}`
            );
        }
    } catch (error) {
        console.error(
            `Error removing product with serviceId: ${serviceId}`,
            error
        );
    }
}

const createExpenseProduct = () => {
    CureRepository.createDialog = true;
};

const routeParams = useRoute();
const formData = reactive({
    id: null,
    deletedIds: [],
    services: [],
    dentistId: null,
    grandTotal: null,
    patientId: null,
    startDate: null,
    description: null,
    paid: null,
    status: null,
});

// Fetch the data and populate `formData`
CureRepository.FetchCure(routeParams.params.id).then((res) => {
    const cure = CureRepository.cure; // Assuming the data is stored here
    formData.id = cure.id;
    formData.services = cure.services || [];
    formData.dentistId = cure.dentist?.id;
    formData.grandTotal = parseInt(cure.grand_total || 0, 10); // Convert grand_total to integer
    formData.patientId = cure.patient?.id;
    formData.startDate = cure.start_date;
    formData.description = cure.description;
    formData.paid = cure.paid;
    formData.status = cure.status;

    console.log(formData.grandTotal, "Initial grand total");
});

const multiple = (pro) => {
    console.log(pro);
    const add = pro.quantity * pro.cost;
    console.log(add);
    return add || 0;
};

// Computed property to calculate the total
const totalSum = computed(() => {
    // Sum up the services in `formData.services`
    const servicesTotal = formData.services.reduce((acc, item) => {
        return acc + multiple(item); // Replace `multiple` with your logic for calculating each item
    }, 0);

    // Add the fetched grandTotal
    return servicesTotal + (formData.grandTotal || 0);
});

// Watch the computed property if needed
watch(totalSum, (newVal) => {
    console.log(newVal, "Updated grand total");
});

// Combine services from both repositories
const combinedServices = computed(() => {
    return [...CureRepository.services, ...formData.services];
});

const formRef = ref(null);
const rules = {
    required: (value) => !!value || "This field is required.",
    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) || "Invalid name.",
};

watch(
    () => CureRepository.services,
    () => {
        CureRepository.services.forEach((services) => {
            // Update the 'subtotal' property for each service
            services.total = multiple(services);
            console.log(services, "watch");
        });
    },
    { deep: true }
);

// const totalSum = computed(() => {
//     const grandTotal = parseInt(formData.grandTotal|| 0, 10); // Convert to integer, default to 0 if undefined
//     const total = CureRepository.services.reduce(
//         (acc, item) => acc + multiple(item),
//         0
//     );
//     formData.grandTotal = total + grandTotal;
//     return formData.grandTotal;
// });

// Computed Duo (remaining balance)
const Duo = computed(() => {
    return totalSum.value - formData.paid || 0;
});

// Update function
const update = async () => {
    if (Array.isArray(formData.services)) {
        formData.services = formData.services.map((data) => {
            if (data.services && data.services.id) {
                return {
                    ...data,
                    product: { id: data.services.id },
                };
            } else {
                console.error(
                    "services is missing or invalid in services:",
                    data
                );
                return data;
            }
        });
    }
    const isValid = await formRef.value.validate();
    if (isValid) {
        await CureRepository.UpdateCure(formData.id, formData);
    }
};

const saveData = async (id) => {
    await CureRepository.fetchProduct(id);
};

const deleteItem = async (item) => {
    await CureRepository.deleteEarning(item.id);
};
formData.startDate = CureRepository.getTodaysDate();

CureRepository.Patients();
CureRepository.Doctor();
CureRepository.leadStagesFor();
// ====================
// =====================================
</script>

<style scoped>
.thead {
    border-left: 4px solid #fecd07;
    background-color: #ecf1f4;
    max-width: 120rem;
}

.discount {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}
</style>
