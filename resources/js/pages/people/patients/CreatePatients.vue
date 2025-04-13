<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="PeopleRepository.createDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2 class="font-weight-bold pl-4">
                            {{
                                PeopleRepository.isEditMode
                                    ? t("update")
                                    : t("create")
                            }}
                        </h2>
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider class="border-opacity-100 mx-6"></v-divider>

                    <v-card-text>
                        <v-form ref="formRef" class="pt-4">
                            <div class="flex">
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                    :label="$t('name')"
                                    class="w-50 pb-4 pr-2"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>

                                <div class="relative w-50">
                                    <h4
                                        class="absolute bottom-20 left-5 text-gray-500 text-sm"
                                    >
                                        Date Of Birth
                                    </h4>
                                    <div class="pb-2 pl-2">
                                        <date-picker
                                            mode="single"
                                            :column="1"
                                            v-model="formData.dateOfBirth"
                                            :styles="styles"
                                            locale="fa"
                                            type="date"
                                            format="jYYYY/jMM/jDD"
                                            :locale-config="LocaleConfigs"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.phone"
                                    variant="outlined"
                                    :label="$t('phone')"
                                    density="compact"
                                    :counter="10"
                                    type="tel"
                                    class="w-50 pr-2 pb-2"
                                    :rules="[rules.required]"
                                ></v-text-field>
                                <div class="w-50">
                                    <div class="rounded-sm ml-2 styleBTN w-60">
                                        <v-btn
                                            class="w-50"
                                            variant="flat"
                                            rounded="0"
                                            @click="selectGender('Male')"
                                            :color="
                                                isMaleSelected
                                                    ? '#00893f'
                                                    : 'gray'
                                            "
                                            :class="{
                                                'text-white': isMaleSelected,
                                            }"
                                        >
                                            {{ $t("male") }}
                                        </v-btn>

                                        <v-btn
                                            class="w-50"
                                            variant="flat"
                                            rounded="0"
                                            @click="selectGender('Female')"
                                            :color="
                                                isFemaleSelected
                                                    ? '#00893f'
                                                    : 'gray'
                                            "
                                            :class="{
                                                'text-white': isFemaleSelected,
                                            }"
                                        >
                                            {{ $t("female") }}
                                        </v-btn>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-base text-xm text-[#666] ">
                                     Sicknesses
                                </h4>
                            <div class=" flex  gap-5 align-center mb-4  text-xm text-[#666]" :style="sicknessOptions ? '#000' :'#666'">
                               
                                <v-checkbox
                                    v-for="sickness in sicknessOptions"
                                    :key="sickness"
                                    :label="sickness"
                                    :value="sickness"
                                    :color="sicknessOptions ? '#000' :'#666'"
                                    class="text-xs"
                                    v-model="formData.medicalRecord"
                                    hide-details
                                    density="compact"
                                />
                            </div>
                            <h4 class="text-base text-xm text-[#666] ">
                                Dental Records
                                </h4>
                            <div class=" flex  gap-5 align-center mb-4  text-xm text-[#666]" :style="dentalRecords ? '#000' :'#666'">
                               
                                <v-checkbox
                                    v-for="sickness in dentalRecords"
                                    :key="sickness"
                                    :label="sickness"
                                    :value="sickness"
                                    :color="dentalRecords ? '#000' :'#666'"
                                    class="text-xs"
                                    v-model="formData.dentalRecord"
                                    hide-details
                                    density="compact"
                                />
                            </div>

                            <v-textarea
                                v-model="formData.address"
                                variant="outlined"
                                :label="$t('address')"
                                density="compact"
                            >
                            </v-textarea>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                PeopleRepository.isEditMode
                                    ? t("update")
                                    : t("submit")
                            }}
                        </v-btn>
                    </div>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from "vue";
import { usePeopleRepository } from "@/store/PeopleRepository";
import { LocaleConfigs } from "../../../LocaleConfigs";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
const PeopleRepository = usePeopleRepository();
const formRef = ref(null);
const selectGender = (gender) => {
    formData.gender = gender;
};
const sicknessOptions = [
  'Diabetes',
  'blood pressure',
  'Heart Disease',
  'Asthma',
  'Allergies',
  'Others'
]
const dentalRecords =[
    'Have a toothache?',
    'Bleeding gums?'
]


const formData = reactive({
    id: PeopleRepository.patient.id,
    name: PeopleRepository.patient.name,
    phone: PeopleRepository.patient.phone,
    address: PeopleRepository.patient.address,
    last_name: "nadeem",
   medicalRecord: convertJsonToArray(PeopleRepository.patient.medicalRecord, sicknessOptions),
  dentalRecord: convertJsonToArray(PeopleRepository.patient.dentalRecord, dentalRecords),
    type: "patient",
    gender: PeopleRepository.patient.gender || "Male", // Default to 'Male'
    dateOfBirth: PeopleRepository.patient.dateOfBirth,
});
function convertJsonToArray(json, options) {
  if (!json) return [];
  try {
    const data = typeof json === "string" ? JSON.parse(json) : json;
    const selected = [];

    for (const label of options) {
      const key = label.replace(/\s+/g, "_").toLowerCase().replace("?", "");
      if (data[key]) selected.push(label);
    }

    return selected;
  } catch (e) {
    console.error("Invalid JSON:", e);
    return [];
  }
}

// Computed properties for cleaner styling logic
const isMaleSelected = computed(() => formData.gender === "Male");
const isFemaleSelected = computed(() => formData.gender === "Female");

const rules = {
    required: (value) => !!value || "This field is required.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name.",
};

const save = async () => {
    const isValid = await formRef.value.validate();

    if (isValid) {
        // Convert arrays to JSON objects
        const medicalRecordObj = {};
        formData.medicalRecord.forEach((item) => {
            medicalRecordObj[item.replace(/\s+/g, "_").toLowerCase()] = true;
        });

        const dentalRecordObj = {};
        formData.dentalRecord.forEach((item) => {
            dentalRecordObj[item.replace(/\s+/g, "_").toLowerCase()] = true;
        });

        // Attach the transformed values
        const payload = {
            ...formData,
            medicalRecord: JSON.stringify(medicalRecordObj),
            dentalRecord: JSON.stringify(dentalRecordObj),
        };

        // Send to backend
        if (PeopleRepository.isEditMode) {
            await PeopleRepository.UpdatePatient(formData.id, payload);
        } else {
            await PeopleRepository.CreatePatient(payload);
        }
    }
};

formData.dateOfBirth = PeopleRepository.getTodaysDate();
</script>

<style scoped>
.text-white {
    color: white !important;
}
</style>
