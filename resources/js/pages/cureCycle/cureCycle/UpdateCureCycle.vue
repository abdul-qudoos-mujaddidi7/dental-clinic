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
                <div class="pb-4 w-50 pr-2">
                    <date-picker
                        mode="single"
                        :column="1"
                        v-model="formData.startDate"
                        :styles="styles"
                        locale="fa"
                        type="date"
                        :locale-config="LocaleConfigs"
                    />
                </div>

                <v-autocomplete
                    v-model="formData.patientId"
                    :items="CureRepository.patientsFor"
                    :return-object="false"
                    variant="outlined"
                    :label="$t('patient')"
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
                    :label="$t('doctor')"
                    class="pr-2 pl-2"
                    style="width: 45%"
                    item-value="id"
                    item-title="name"
                    density="compact"
                    :rules="[rules.required]"
                ></v-autocomplete>
                <v-autocomplete
                    v-model="formData.status"
                    :items="CureRepository.leadStageFor"
                    :return-object="false"
                    variant="outlined"
                    :label="$t('status')"
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
                            :label="$t('search')"
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
                                {{ t("service") }}
                                {{ t("service") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                {{ t("qty") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                Cost
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                {{ t("cost") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-center">
                                {{ t("subTotal") }}
                            </th>
                            <th scope="col" class="px-3 py-3 text-end">
                                {{ t("action") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(pro, index) in combinedServices"
                            :key="pro.id"
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
                                    :rules="[rules.required, rules.positive]"
                                ></v-text-field>
                            </td>
                            <td class="pt-2 pb-0 text-center w-[14rem]">
                                <v-text-field
                                    v-model="pro.cost"
                                    variant="outlined"
                                    density="compact"
                                    class="w-75"
                                    :rules="[rules.required, rules.positive]"
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
                                <span>{{ pro.total }}</span>
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
                    <span>{{ t("total") }}</span>
                </div>

                <div class="w-[25rem]">
                    <v-text-field
                        v-model="formData.paid"
                        variant="outlined"
                        :label="$t('paid')"
                        :rules="[rules.positive]"
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
                    v-model="formData.note"
                    class="textArea"
                    label="Details"
                    variant="outlined"
                    density="compact"
                >
                </v-textarea>
            </div>
            <div class="d-flex flex-row-reverse mt-6">
                <v-btn color="#112F53" @click="update">
                    {{ t("update") }}</v-btn
                >
            </div>
        </div>
    </div>
</template>

<script setup>
import AppBar from "../../../components/AppBar.vue";
import { reactive, computed, ref, watch, onMounted } from "vue";
import { useRoute } from "vue-router";
import { LocaleConfigs } from "../../../LocaleConfigs";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
import { useCureRepository } from "@/store/CureRepository";

const CureRepository = useCureRepository();
const CalcFetchProduct = (index) => {
    console.log(index, "man of the match");
    CureRepository.fetchProduct(index.id);
    clearSearch();
};

const clearSearch = () => {
    CureRepository.billExpenseSearch = "";
    CureRepository.searchFetch = [];
};
const removeProduct = (index) => {
    CureRepository.cure.services.splice(index, 1);
};

const createService = () => {
    CureRepository.createDialog = true;
};

const routeParams = useRoute();
const formData = reactive({
    id: "",
    deletedIds: [],
    cureProduct: [],
    dentistId: null,
    grandTotal: 0,
    patientId: null,
    startDate: "",
    description: "",
    paid: 0,
    status: "",
    services: [],
    total: "",
});

// Fetch the data and populate `formData`
CureRepository.FetchCure(routeParams.params.id).then((res) => {
    const cure = CureRepository.cure; // Assuming the data is stored here
    formData.id = cure.id;
    formData.services = cure.servicesDetails || [];
    formData.dentistId = cure.dentist?.id;
    formData.grandTotal = 0; // Convert grand_total to integer
    formData.patientId = cure.patient?.id;
    formData.startDate = cure.start_date;
    formData.description = cure.description;
    formData.paid = cure.paid;
    formData.status = cure.status;

    console.log(
        formData.grandTotal,
        "Initial grand total",
        formData.dentistId,
        "den id"
    );
});
console.log();

// const multiple = (pro) => {
//     const quantity = parseFloat(pro.quantity) || 0;
//     const cost = parseFloat(pro.cost) || 0;
//     return quantity * cost;
// };

// // Computed property to calculate the total
// const totalSum = computed(() => {
//     // Sum up the services in `formData.services`
//     const servicesTotal = formData.services.reduce((acc, item) => {
//         return acc + multiple(item); // Replace `multiple` with your logic for calculating each item
//     }, 0);

//     // Add the fetched grandTotal
//     return servicesTotal ;
// });

// Watch the computed property if needed
// watch(totalSum, (newVal) => {
//     console.log(newVal, "Updated grand total");
// });

// Combine cureProduct from both repositories
const combinedServices = computed(() => {
    return [...formData.services];
});
watch(
    combinedServices,
    (newValues) => {
        newValues.forEach((pro) => {
            console.log("Row:", pro);
            pro.total =
                (parseFloat(pro.quantity) || 0) * (parseFloat(pro.cost) || 0);
            console.log("Updated Total:", pro.total);
        });
    },
    { deep: true }
);

const formRef = ref(null);
const rules = {
    required: (value) => !!value || "This field is required.",
    positive: (value) => value >= 0 || "Negative values are not allowed.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) || "Invalid name.",
};

watch(
    combinedServices,
    (newServices) => {
        formData.cureProduct = newServices;
    },
    { immediate: true, deep: true }
);

const totalSum = computed(() => {
    let total = 0;

    if (Array.isArray(CureRepository.cure.servicesDetails)) {
        for (const item of CureRepository.cure.servicesDetails) {
            total +=
                (parseFloat(item.quantity) || 0) * (parseFloat(item.cost) || 0);
        }
    }

    formData.grandTotal = total;
    return total;
});
// javascript
// // Computed property to calculate the total
// const totalSum = computed(() => {
//     // Sum up the services in `formData.services`
//     const servicesTotal = formData.services.reduce((acc, item) => {
//         return acc + (parseFloat(item.quantity) || 0) * (parseFloat(item.cost) || 0);
//     }, 0);

//     // Add the fetched grandTotal
//     return servicesTotal;
// });

// // Watch the computed property if needed
// watch(totalSum, (newVal) => {
//     console.log(newVal, "Updated grand total");
//     formData.grandTotal = newVal;
// });

// // Combine cureProduct from both repositories
// const combinedServices = computed(() => {
//     return [...formData.services];
// });
// watch(combinedServices, (newValues) => {
//   newValues.forEach((pro) => {
//     pro.total = (parseFloat(pro.quantity) || 0) * (parseFloat(pro.cost) || 0);
//   });
// }, { deep: true });

// // Update function
// const update = async () => {
//     formData.grandTotal = totalSum.value;
//     if (Array.isArray(formData.services)) {
//         formData.services = formData.services.map((data) => {
//             if (data.services && data.services.id) {
//                 return {
//                     ...data,
//                     product: { id: data.services.id },
//                 };
//             } else {
//                 console.error(
//                     "services is missing or invalid in services:",
//                     data
//                 );
//                 return data;
//             }
//         });
//     }
//     const isValid = await formRef.value.validate();
//     if (isValid) {
//         await CureRepository.UpdateCure(formData.id, formData);
//     }
// };
// ```
// Computed Duo (remaining balance)
const Duo = computed(() => {
    return totalSum.value - formData.paid || 0;
});
// Update function
const update = async () => {
    formData.grandTotal = totalSum.value;
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
const accountIndex = ref(0);

const currenctAccountName = computed(() => {
    const accounts = CureRepository.account;

    if (!accounts || accounts.length === 0) {
        return { moneyAccountId: "...", id: null };
    }

    if (accountIndex.value >= accounts.length) {
        accountIndex.value = 0;
    }

    formData.moneyAccountId = accounts[accountIndex.value].id;

    return {
        name: accounts[accountIndex.value].name,
        id: accounts[accountIndex.value].id,
    };
});
//====================================
const changeCurrency = () => {
    const accounts = CureRepository.account;
    if (!accounts || accounts.length === 0) return;
    accountIndex.value = (accountIndex.value + 1) % accounts.length;
};
CureRepository.fetchAccountDataForCreate();
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
