<template>
    <CReateExpensePRoduct v-if="LaboratoryRepository.createDialog" />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <AppBar mainTitle="Create Laboratory " subTitle="Laboratory" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-form ref="formRef" class="d-flex pt-12">
                <v-text-field
                    type="date"
                    v-model="formData.issueAt"
                    variant="outlined"
                    label="Issue At *"
                   class="pr-2"
                    style="width: 45%"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>
                <v-text-field
                    type="date"
                    v-model="formData.returnDate"
                    variant="outlined"
                    label="Return Date *"
                   
                      class="px-2"
                    style="width: 45%"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>

                

                <v-autocomplete
                    v-model="formData.status"
                    :items="LaboratoryRepository.leadStageFor"
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
                <v-autocomplete
                    v-model="formData.dentistId"
                    :items="LaboratoryRepository.doctorsFor"
                    :return-object="false"
                    variant="outlined"
                    label="Doctor *"
                    class="pl-2"
                    style="width: 45%"
                    item-value="id"
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
                            v-model="LaboratoryRepository.labSearch"
                            @keyup.enter="LaboratoryRepository.SearchFetchData"
                            @input="LaboratoryRepository.SearchFetchData"
                            @click:clear="clearSearch"
                            variant="outlined"
                            label="Search "
                            density="compact"
                            append-inner-icon="mdi-magnify"
                            clearable
                            class="border-none"
                        ></v-text-field>
                    </div>
                    <div
                        class="rounded shadow-lg px-5 mb-12"
                        v-if="LaboratoryRepository.searchFetch.length > 0"
                    >
                        <div>
                            <div
                                v-for="index in LaboratoryRepository.searchFetch"
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
                    class="text-sm text-center custom"
                    density="compact"
                    style="width: 150rem"
                >
                    <thead class="text-xs text-gray-700 uppercase thead">
                        <tr class="border-gray-300">
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
                            <th scope="col" class="px-3 py-3 text-center">
                                Sub Total
                            </th>
                            <th scope="col" class="px-3 py-3 text-end">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="space">
                        <tr
                            class="product-table h-[3.4rem] text-xs"
                            v-for="(pro, index) in LaboratoryRepository.services"
                            :key="index"
                        >
                            <td class="pl-3 text-start">{{ index + 1 }}</td>
                            <td class="pl-3 text-start">{{ pro.name }}</td>

                            <td class="text-center w-[14rem]">
                                <v-text-field
                                    v-model="pro.quantity"
                                    variant="outlined"
                                    type="number"
                                    density="compact"
                                    class="w-75"
                                    hide-details
                                    single-line
                                    :style="{
                                        height: '1.75rem',
                                        textAlign: 'center',
                                    }"
                                ></v-text-field>
                            </td>

                            <td class="pb-0 text-center w-[14rem]">
                                <v-text-field
                                    v-if="formData.peopleId !== null"
                                    v-model="pro.cost"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                    hide-details
                                    single-line
                                    :style="{
                                        height: '1.75rem',
                                        padding: '0',
                                        textAlign: 'center',
                                    }"
                                >
                                    <span
                                        class="span text-xs flex items-center justify-center pb-2"
                                    >
                                        AFG
                                    </span>
                                </v-text-field>
                            </td>

                            <td class="text-center align-middle">
                                <span>{{ multiple(pro) }}</span>
                            </td>

                            <td class="px-3 text-end align-middle">
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
                    v-model="formData.description"
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
import AppBar from "../../components/AppBar.vue";
import { reactive, computed, ref, watch, onMounted } from "vue";

import { useLaboratoryRepository } from "@/store/LaboratoryRepository";

const LaboratoryRepository = useLaboratoryRepository();
const CalcFetchProduct = (index) => {
    console.log(index, "man of the match");
    LaboratoryRepository.fetchProduct(index.id);
    clearSearch();
};

// ======================
const clearSearch = () => {
    LaboratoryRepository.billExpenseSearch = ""; //
    LaboratoryRepository.searchFetch = [];
};
const removeProduct = (index) => {
    LaboratoryRepository.services.splice(index, 1);
    console.log(LaboratoryRepository.services);
};
const createExpenseProduct = () => {
    LaboratoryRepository.createDialog = true;
};

const formData = reactive({
    tooths: LaboratoryRepository.services || [],
    grandTotal: "",
    toothId: "",
    returnDate: "",
    issueAt: "",
    description: "",
    paid: "",
    status: "",
    dentistId:"",
    type:'in'
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
    () => LaboratoryRepository.services,
    () => {
        LaboratoryRepository.services.forEach((services) => {
            // Update the 'subtotal' property for each service
            services.total = multiple(services);
            console.log(services);
        });
    },
    { deep: true }
);

// const totalSum = computed(() => {
//     const total = LaboratoryRepository.services.reduce(
//         (acc, item) => acc + multiple(item),
//         0
//     );
//     formData.grandTotal = total;
//     return total;
// });
const totalSum = computed(() => {
    let total = 0;

    if (Array.isArray(LaboratoryRepository.services)) {
        for (const item of LaboratoryRepository.services) {
            total += multiple(item);
        }
    }

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
        formData.tooths.map((data) => (data.serviceId = data.id));
        await LaboratoryRepository.CreateLaboratory(formData);
        formData.tooths = [];
        LaboratoryRepository.services = [];

        // Reset other formData fields
        formData.grandTotal = "";
        formData.toothId = "";
        formData.returnDate = LaboratoryRepository.getTodaysDate();
        formData.issueAt = LaboratoryRepository.getTodaysDate();
        formData.description = "";
        formData.paid = "";
        formData.status = "";

        console.log("Form submitted and cleared successfully!");
    }
};

const saveData = async (id) => {
    await LaboratoryRepository.fetchProduct(id);
};

const deleteItem = async (item) => {
    await LaboratoryRepository.DeleteLaboratory(item.id);
};
formData.returnDate = LaboratoryRepository.getTodaysDate();
formData.issueAt = LaboratoryRepository.getTodaysDate();

// LaboratoryRepository.Patients();
LaboratoryRepository.Doctors();
LaboratoryRepository.leadStagesFor();
// ====================
// =====================================
</script>

<style scoped>
.thead {
    /* border-left: 4px solid #fecd07;
    background-color: #ecf1f4;
    max-width: 120rem; */
    background-color: #ecf1f4;
    border-left: 4px solid #f4d03f;
    border-bottom: 4px solid #ffff;
    border-width: 4px;
    border-right: none;
    border-top: none;
}

.discount {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}

.product-table {
    border-bottom: 2px solid #ffff;
    border-left: 4px solid #f4d03f;
    border-width: 4px;
    border-right: none;
    border-top: none;
}
</style>
