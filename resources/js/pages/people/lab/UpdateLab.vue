<template>
    <CReateExpensePRoduct v-if="PeopleRepository.createDialog" />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <AppBar mainTitle="Update Laboratory " subTitle="People" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-form ref="formRef" class="d-flex pt-12 relative">
                <h3 class="absolute right-90 top-5 text-gray-500 text-sm">
                    Issue At
                </h3>
                <div class="pb-4 w-50 pr-2">
                    <date-picker
                        mode="single"
                        :column="1"
                        v-model="formData.issueAt"
                        :styles="styles"
                        locale="fa"
                        type="date"
                        format="jYYYY/jMM/jDD"
                        :locale-config="LocaleConfigs"
                    />
                </div>
                <div class="w-50">
                    <h3
                        class="absolute left-50 top-5 text-gray-500 text-sm pl-2"
                    >
                        Return Date
                    </h3>

                    <div class="pb-4 px-2">
                        <date-picker
                            mode="single"
                            :column="1"
                            v-model="formData.returnDate"
                            :styles="styles"
                            locale="fa"
                            type="date"
                            format="jYYYY/jMM/jDD"
                            :locale-config="LocaleConfigs"
                        />
                    </div>
                </div>

                <v-autocomplete
                    v-model="formData.status"
                    :items="PeopleRepository.leadStageFor"
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
                            v-model="PeopleRepository.labSearch"
                            @keyup.enter="PeopleRepository.SearchFetchData"
                            @input="PeopleRepository.SearchFetchData"
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
                        v-if="PeopleRepository.searchFetch.length > 0"
                    >
                        <div>
                            <div
                                v-for="index in PeopleRepository.searchFetch"
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
                            v-for="(pro, index) in formData.tooths"
                            :key="index"
                        >
                            <td class="pl-3 text-start">
                                {{ index + 1 }}
                            </td>
                            <td class="pl-3 text-start">
                                {{ pro.name || pro.toothName }}
                            </td>

                            <td class="pt-2 text-center pb-0 w-[14rem]">
                                <v-text-field
                                    v-model="pro.quantity"
                                    variant="outlined"
                                    type="number"
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
                    v-model="formData.description"
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
import { LocaleConfigs } from "../../../LocaleConfigs";
import { usePeopleRepository } from "@/store/PeopleRepository";

const PeopleRepository = usePeopleRepository();
// PeopleRepository.services =  laboratory.details || [];
const CalcFetchProduct = (index) => {
    console.log(index, "man of the match");
    PeopleRepository.fetchProduct(index.id);
    clearSearch();
};

// ======================
const clearSearch = () => {
    PeopleRepository.billExpenseSearch = ""; //
    PeopleRepository.searchFetch = [];
};
const removeProduct = (index) => {
    PeopleRepository.services.splice(index, 1);
    console.log(PeopleRepository.services);
};
const createExpenseProduct = () => {
    PeopleRepository.createDialog = true;
};

const formData = reactive({
    tooths: PeopleRepository.services || [],
    grandTotal: "",
    patientId: "",
    returnDate: "",
    issueAt: "",
    description: "",
    paid: "",
    type:"out"
});
const routeParams = useRoute();

PeopleRepository.FetchLaboratory(routeParams.params.id).then((res) => {
    const laboratory = PeopleRepository.laboratory; // Assuming the data is stored here
    formData.id = laboratory.id;
    PeopleRepository.services = laboratory.details || [];

    formData.grandTotal = laboratory.grandTotal;
    formData.returnDate = laboratory.returnDate;
    formData.issueAt = laboratory.issueAt;
    formData.description = laboratory.description;
    formData.paid = laboratory.paid;
    formData.status = laboratory.status;

    console.log(formData.grandTotal, "Initial grand total");
});

watch(
    () => PeopleRepository.laboratory,
    (newData) => {
        if (newData) {
            formData.tooths = newData.details || [];
            formData.grandTotal = newData.grandTotal;
            formData.returnDate = newData.returnDate;
            formData.issueAt = newData.issueAt;
            formData.description = newData.description;
            formData.paid = newData.paid;
            formData.status = newData.status;
        }
    },
    { deep: true }
);

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
    () => PeopleRepository.services,
    () => {
        PeopleRepository.services.forEach((services) => {
            // Update the 'subtotal' property for each service
            services.total = multiple(services);
            console.log(services);
        });
    },
    { deep: true }
);

const totalSum = computed(() => {
    let total = 0;

    if (Array.isArray(PeopleRepository.services)) {
        for (const item of PeopleRepository.services) {
            total += multiple(item);
        }
    }

    formData.grandTotal = total;
    return total;
});

// Update function
const update = async () => {
    formData.grandTotal = totalSum.value;

    // Ensure formData.tooths exists before mapping
    if (Array.isArray(formData.tooths)) {
        formData.tooths = formData.tooths.map((data) => {
            if (data.toothId) {
                return {
                    ...data,
                    product: { id: data.toothId }, // Assuming `toothId` is the correct field
                };
            } else {
                console.error("toothId is missing or invalid in:", data);
                return data;
            }
        });
    }

    // Validate form
    const isValid = await formRef.value.validate();
    if (isValid.valid) {
        // Vuetify 3 validation returns an object { valid: true/false }
        try {
            await PeopleRepository.UpdateLaboratory(formData.id, formData);
            console.log("Updated successfully:", formData);
        } catch (error) {
            console.error("Error updating laboratory:", error);
        }
    } else {
        console.error("Form validation failed");
    }
};

// Computed Duo (remaining balance)
const Duo = computed(() => {
    return totalSum.value - formData.paid || 0;
});

const saveData = async (id) => {
    await PeopleRepository.fetchProduct(id);
};

const deleteItem = async (item) => {
    await PeopleRepository.DeleteLaboratory(item.id);
};
formData.startDate = PeopleRepository.getTodaysDate();

// PeopleRepository.Patients();
// PeopleRepository.Doctor();
PeopleRepository.leadStagesFor();
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
