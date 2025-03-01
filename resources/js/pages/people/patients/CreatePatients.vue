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
                                    ? "Update"
                                    : "Create"
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
                                    label="Name *"
                                    class="w-50 pb-4 pr-2"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                                <v-text-field
                                    v-model="formData.dateOfBirth"
                                    variant="outlined"
                                    label="Date of Birth *"
                                    type="date"
                                    class="w-50 pb-4 pl-2"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                            </div>

                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.phone"
                                    variant="outlined"
                                    label="Phone "
                                    density="compact"
                                    :counter="10"
                                    type="tel"
                                    class="w-50 pr-2 pb-4"
                                    :rules="[rules.required]"
                                ></v-text-field>
                                <div class="w-50 "> 
                                  
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
                                            Male
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
                                            Female
                                        </v-btn>
                                    </div>
                                </div>
                            </div>

                            <v-textarea
                                v-model="formData.address"
                                variant="outlined"
                                label="Address  "
                                density="compact"
                            >
                            </v-textarea>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                PeopleRepository.isEditMode
                                    ? "Update"
                                    : "Submit"
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

const PeopleRepository = usePeopleRepository();
const formRef = ref(null);
const selectGender = (gender) => {
    formData.gender = gender;
};
const formData = reactive({
    id: PeopleRepository.patient.id,
    name: PeopleRepository.patient.name,
    phone: PeopleRepository.patient.phone,
    address: PeopleRepository.patient.address,
    last_name: "nadeem",
    type: "patient",
    gender: PeopleRepository.patient.gender || "Male", // Default to 'Male'
    dateOfBirth: PeopleRepository.patient.dateOfBirth,
});
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
        if (PeopleRepository.isEditMode) {
            await PeopleRepository.UpdatePatient(formData.id, formData);
        } else {
            await PeopleRepository.CreatePatient(formData);
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
