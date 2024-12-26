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
                                status
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
                            v-for="(
                                pro, index
                            ) in CureRepository.services"
                            :key="index"
                        >
                            <td class="pl-3 text-start">
                                {{ index + 1 }}
                            </td>
                            <td class="pl-3 text-start">
                                {{ pro.name }}
                            </td>

                            <td class="pt-2 text-center pb-0 w-[14rem]">
                                <v-text-field
                                    v-model="pro.quantity"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                >
                                   
                                </v-text-field>
                            </td>
                            

                            <td class="pt-2 pb-0 text-center w-[14rem]">
                                <v-text-field
                                    v-if="formData.peopleId !== null"
                                    v-model="pro.cost"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                >
                                    <span class="span">
                                        {{ displayedCurrencySymbol }}
                                    </span>
                                </v-text-field>
                            </td>
                            <td class="pt-2 text-center pb-0 w-[14rem]">
                                <v-autocomplete
                                :items="['complete', 'start']"
                                v-model="pro.status"
                                variant="outlined"
                                density="compact"
                                    class="w-75"
                                >

                                </v-autocomplete>

                            </td>
                            <td class="text-center">
                                <span>{{ multiple(pro) }}</span>
                            </td>

                            <td class="px-3 text-end">
                                <v-icon
                                    color="red"
                                    @click="removeProduct(index)"
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
                <v-btn color="#112F53" @click="createEarning"> Submit</v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppBar from "../../../components/AppBar.vue";
import { reactive, computed, ref, watch, onMounted } from "vue";

import { useCureRepository } from "@/store/CureRepository";

const CureRepository = useCureRepository();
const CalcFetchProduct = (index) => {
    console.log(index, "man of the match");
    CureRepository.fetchProduct(index.id);
    clearSearch();
};

// ======================
const clearSearch = () => {
    CureRepository.billExpenseSearch = ""; // Clear repository's search
    CureRepository.searchFetch = [];
};
const removeProduct = (index) => {
    CureRepository.services.splice(index, 1);
    console.log(CureRepository.services);
};
const createExpenseProduct = () => {
    CureRepository.createDialog = true;
};

const formData = reactive({
    services: CureRepository.services,
    grandTotal: "",
    patientId: "",
    startDate: "",
    description: "",
    paid: "",
    status:"",
});
const formRef = ref(null);
const rules = {
    required: (value) => !!value || "This field is required.",
    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) || "Invalid name.",
};

const multiple = (pro) => {
    console.log(pro);
    const add = pro.quantity * pro.cost;
    console.log(add);
    return add || 0;
};

watch(
    () => CureRepository.services,
    () => {
        CureRepository.services.forEach((services) => {
            // Update the 'subtotal' property for each service
            services.total = multiple(services);
            console.log(services);
        });
    },
    { deep: true }
);

const totalSum = computed(() => {
    const total = CureRepository.services.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
    formData.grandTotal = total;
    return total;
});
// Computed Duo (remaining balance)
const Duo = computed(() => {
    return totalSum.value - formData.paid || 0;
});

const createEarning = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        formData.services.map((data) => (data.serviceId = data.id));
        await CureRepository.CreateCure(formData);
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
