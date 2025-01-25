<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="LeadRepository.createDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2 class="font-weight-bold pl-4">
                            {{
                                LeadRepository.isEditMode ? "Update" : "Create"
                            }}
                        </h2>
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider class="border-opacity-100 mx-6"></v-divider>

                    <v-card-text>
                        <v-form ref="formRef" class="pt-4">
                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                    label="Full name  *"
                                    class="pb-4 pr-2 w-50"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>

                                <v-text-field
                                    v-model="formData.phone"
                                    variant="outlined"
                                    label="Phone * "
                                    density="compact"
                                    :counter="10"
                                    type="tel"
                                    class="pb-4 pl-2 w-50"
                                    :rules="[rules.required, rules.phoneNumber]"
                                ></v-text-field>
                            </div>
                            <div class="flex w-100">
                                <v-autocomplete
                                    v-model="formData.categoryId"
                                    :items="LeadRepository.leadCategoriesFor"
                                    variant="outlined"
                                    density="compact"
                                    item-value="id"
                                    item-title="name"
                                    :return-object="false"
                                    label="Category"
                                    class="pb-4 pr-2 w-50"
                                    :rules="[rules.required]"
                                >
                                </v-autocomplete>
                                <v-autocomplete
                                    v-model="formData.stageId"
                                    :items="LeadRepository.leadStageFor"
                                    variant="outlined"
                                    density="compact"
                                    item-value="id"
                                    item-title="name"
                                    :return-object="false"
                                    label="Status"
                                    class="pb-4 pl-2 w-50"
                                    :rules="[rules.required]"
                                >
                                </v-autocomplete>
                            </div>
                            <div class="flex w-100">
                                <v-text-field
                                    type="date"
                                    v-model="formData.date"
                                    variant="outlined"
                                    label="Date"
                                    class="pr-2 w-50"
                                    density="compact"
                                ></v-text-field>
                                <div class="w-50">
                                    <div class="rounded ml-2 styleBTN w-60">
                                        <v-btn
                                            class="w-50"
                                            variant="text"
                                            rounded="0"
                                            @click="selectGender('Male')"
                                            :style="{
                                                backgroundColor:
                                                    formData.gender === 'Male'
                                                        ? '#00893F'
                                                        : '',
                                                color:
                                                    formData.gender === 'Male'
                                                        ? '#FFFFFF'
                                                        : '',
                                            }"
                                            >Male</v-btn
                                        >
                                        <v-btn
                                            class="w-50"
                                            variant="text"
                                            @click="selectGender('Female')"
                                            rounded="0"
                                            :style="{
                                                backgroundColor:
                                                    formData.gender === 'Female'
                                                        ? '#00893F'
                                                        : '',
                                                color:
                                                    formData.gender === 'Female'
                                                        ? '#FFFFFF'
                                                        : '',
                                            }"
                                            >Female
                                        </v-btn>
                                    </div>
                                </div>
                            </div>
                            <v-text-field
                                v-model="formData.address"
                                label="Address *"
                                variant="outlined"
                                density="compact"
                            >
                            </v-text-field>

                            <v-textarea
                                v-model="formData.note"
                                variant="outlined"
                                label="Details  "
                                density="compact"
                            >
                            </v-textarea>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                LeadRepository.isEditMode ? "Update" : "Submit"
                            }}
                        </v-btn>
                    </div>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useLeadRepository } from "@/store/LeadRepository";

const LeadRepository = useLeadRepository();
const formRef = ref(null);
const selectGender = (gender) => {
    formData.gender = gender;
};

const formData = reactive({
    id: LeadRepository.lead.id,
    name: LeadRepository.lead.name,
    phone: LeadRepository.lead.phone,
    address: LeadRepository.lead.address,
    gender: LeadRepository.lead.gender,
    note: LeadRepository.lead.note,
    date: LeadRepository.lead.date,
    categoryId: LeadRepository.lead.category?.id,
    stageId: LeadRepository.lead.stage?.id,
});
const rules = {
    required: (value) => !!value || "This field is required.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name.",
    phoneNumber: (value) =>
        /^(\+?[0-9]{10,15})$/.test(value) ||
        "Please enter a valid phone number (10-15 digits).",
};

const save = async () => {
    const isValid = await formRef.value.validate();
    console.log(formData)
    if (isValid) {
        if (LeadRepository.isEditMode) {
            await LeadRepository.UpdateLead(formData.id, formData);
        } else {
            await LeadRepository.CreateLead(formData);
        }
    }
};
LeadRepository.leadCategories();
</script>
