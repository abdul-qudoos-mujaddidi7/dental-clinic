<template>
    <CReateExpensePRoduct v-if="PeopleRepository.createDialog" />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white" rtl>
            <AppBar mainTitle="Create Laboratory " subTitle="People" />
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
                    v-model="formData.supplierId"
                    :items="PeopleRepository.suppliersFor"
                    :return-object="false"
                    variant="outlined"
                    label="Supplier *"
                    class="pr-2 pl-2"
                    style="width: 45%"
                    item-value="id"
                    item-title="name"
                    density="compact"
                    :rules="[rules.required]"
                ></v-autocomplete>
            </v-form>
            <v-divider></v-divider>
            <v-row no-gutters class="justify-space-between mt-16">
                <div class="d-flex gap-2 pb-6 flex flex-wrap">
                    <v-chip
                        v-for="(service, i) in PeopleRepository.dentalsFor"
                        :key="i"
                        :variant="
                            selectedServices.some((s) => s.id === service.id)
                                ? 'flat'
                                : 'outlined'
                        "
                        :color="
                            selectedServices.some((s) => s.id === service.id)
                                ? 'primaryOld'
                                : 'gray'
                        "
                        @click="toggleService(service)"
                        class="cursor-pointer"
                    >
                        {{ service.name }}
                    </v-chip>
                </div>

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
                            v-for="(pro, index) in PeopleRepository.services"
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
                                >
                                    <span
                                        class="span text-xs flex items-center justify-center pb-2"
                                        >AFG</span
                                    >
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

                <div class="w-[25rem]">
                    <v-text-field
                        v-model="formData.paid"
                        variant="outlined"
                        label="Paid"
                      class="w-100"
                        density="compact"
                    >
                        <div @click="changeCurrency" style="cursor: pointer">
                            <span class="paidSpan">
                                {{ currenctAccountName.name }}
                            </span>
                        </div>
                        {{ grandTotal }}
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
import AppBar from "../../../components/AppBar.vue";
import { reactive, computed, ref, watch, onMounted } from "vue";
import { LocaleConfigs } from "../../../LocaleConfigs";
import { usePeopleRepository } from "@/store/PeopleRepository";

const PeopleRepository = usePeopleRepository();

const formData = reactive({
    tooths: PeopleRepository.services || [],
    grandTotal: "",
    toothId: "",
    returnDate: "",
    issueAt: "",
    description: "",
    paid: "",
    status: "",
    type: "out",
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
PeopleRepository.FetchDentals();
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

// const totalSum = computed(() => {
//     const total = PeopleRepository.services.reduce(
//         (acc, item) => acc + multiple(item),
//         0
//     );
//     formData.grandTotal = total;
//     return total;
// });
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

// Computed Duo (remaining balance)
const Duo = computed(() => {
    return totalSum.value - formData.paid || 0;
});

const createEarning = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        formData.tooths.map((data) => (data.serviceId = data.id));
        await PeopleRepository.CreateLaboratory(formData);
        formData.tooths = [];
        PeopleRepository.services = [];

        // Reset other formData fields
        formData.grandTotal = "";
        formData.toothId = "";
        formData.returnDate = PeopleRepository.getTodaysDate();
        formData.issueAt = PeopleRepository.getTodaysDate();
        formData.description = "";
        formData.paid = "";
        formData.status = "";

        console.log("Form submitted and cleared successfully!");
    }
};

PeopleRepository.FetchSuppliersFor();
console.log(PeopleRepository.suppliersFor, "chiqa tyt");
const deleteItem = async (item) => {
    await PeopleRepository.DeleteLaboratory(item.id);
};
formData.returnDate = PeopleRepository.getTodaysDate();
formData.issueAt = PeopleRepository.getTodaysDate();

// PeopleRepository.Patients();
// PeopleRepository.Doctor();
PeopleRepository.leadStagesFor();
// ========================

// =============================
// Define available services
const availableServices = ref([
    { id: 1, name: "Cad Cam", quantity: 1, cost: 2200 },
    { id: 2, name: "Zarconia", quantity: 1, cost: 2000 },
    { id: 3, name: "Veneer", quantity: 1, cost: 2200 },
    { id: 4, name: "Attachment", quantity: 1, cost: 4500 },
    { id: 5, name: "Procelain Style", quantity: 1, cost: 600 },
    { id: 6, name: "Procelain Design", quantity: 1, cost: 400 },
    { id: 7, name: "Procelain Classic", quantity: 1, cost: 400 },
    { id: 8, name: "Procelain Pro Shofo", quantity: 1, cost: 300 },
    { id: 9, name: "Procelain Noritake", quantity: 1, cost: 300 },
    { id: 10, name: "Metal Suprema Cast", quantity: 1, cost: 200 },
    { id: 11, name: "Golden Pro", quantity: 1, cost: 200 },
    { id: 12, name: "Full Denture", quantity: 1, cost: 2500 },
    { id: 13, name: "CC Plate", quantity: 1, cost: 2000 },
    { id: 14, name: "Full Night Guard", quantity: 1, cost: 700 },
]);

const selectedServices = ref([]);

const toggleService = (service) => {
    const index = PeopleRepository.services.findIndex(
        (s) => s.id === service.id
    );

    if (index === -1) {
        // Add service to the table and mark it as selected
        PeopleRepository.services.push({ ...service });
        selectedServices.value.push(service);
    } else {
        // Remove service from the table and deselect it
        PeopleRepository.services.splice(index, 1);
        selectedServices.value = selectedServices.value.filter(
            (s) => s.id !== service.id
        );
    }
};
const removeProduct = (index) => {
    const removedService = PeopleRepository.services[index];

    PeopleRepository.services.splice(index, 1);
    selectedServices.value = selectedServices.value.filter(
        (s) => s.id !== removedService.id
    );
};

// =====================================
const account = PeopleRepository.account.name;

const accountIndex = ref(0);

const currenctAccountName = computed(() => {
    const accounts = PeopleRepository.account;

    if (!accounts || accounts.length === 0) {
        return { moneyAccountId: "...", id: null };
    }

    if (accountIndex.value >= accounts.length) {
        accountIndex.value = 0;
    }

    formData.name = accounts[accountIndex.value].id;

    return {
        name: accounts[accountIndex.value].name,
        id: accounts[accountIndex.value].id,
    };
});
//====================================
const changeCurrency = () => {
    const accounts = PeopleRepository.account;
    if (!accounts || accounts.length === 0) return;
    accountIndex.value = (accountIndex.value + 1) % accounts.length;
};

PeopleRepository.fetchAccountDataForCreate();
console.log(PeopleRepository.account, "na");
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
