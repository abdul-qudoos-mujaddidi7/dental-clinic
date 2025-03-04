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
                            <div class="pb-4">
                                <date-picker
                                    mode="single"
                                    :column="1"
                                    v-model="formData.date"
                                    :styles="styles"
                                    locale="fa"
                                    type="datetime"
                                    format="jYYYY/jMM/jDD"
                                    :locale-config="LocaleConfigs"
                                />
                                
                            </div>

                            <div class="flex">
                                <v-autocomplete
                                    v-model="formData.patientId"
                                    :items="LeadRepository.patientsForApp"
                                    :return-object="false"
                                    variant="outlined"
                                    label="Patient *"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                    :rules="[rules.required]"
                                    class="w-50 pr-2 pb-4"
                                >
                                </v-autocomplete>

                                <v-autocomplete
                                    v-model="formData.dentistId"
                                    :items="LeadRepository.doctorsForApp"
                                    :return-object="false"
                                    variant="outlined"
                                    label="Doctors *"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                    :rules="[rules.required]"
                                    class="w-50 pl-2 pb-4"
                                >
                                </v-autocomplete>
                            </div>
                            <div class="flex">
                                <v-autocomplete
                                    v-model="formData.status"
                                    :items="[
                                        'Completed',
                                        'Pending',
                                        'Cancelled',
                                        'In Progress',
                                        'No Show',
                                    ]"
                                    :return-object="false"
                                    variant="outlined"
                                    label="Status *"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                    :rules="[rules.required]"
                                    class="pb-4"
                                >
                                </v-autocomplete>
                            </div>
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
import { LocaleConfigs, styles } from "../../../LocaleConfigs.js";

const LeadRepository = useLeadRepository();
const formRef = ref(null);
const formData = reactive({
    id: LeadRepository.appointment.id,
    dateTime: LeadRepository.appointment.date,
    time: LeadRepository.appointment.time,
    status: LeadRepository.appointment.status,
    patientId: LeadRepository.appointment.patients?.id,
    dentistId: LeadRepository.appointment.dentists?.id,
    userId: LeadRepository.appointment.user?.id,
});
const rules = {
    required: (value) => !!value || "This field is required.",

    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name.",
};

const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        if (LeadRepository.isEditMode) {
            await LeadRepository.UpdateAppointment(formData.id, formData);
        } else {
            await LeadRepository.CreateAppointment(formData);
        }
        LeadRepository.isEditMode = false;
    }
};
LeadRepository.fetchPatients();
// patientsForApp
LeadRepository.fetchDoctors();
// doctorsForApp
LeadRepository.fetchUsers();
// userForApp

formData.date = LeadRepository.getTodaysDate();
</script>

<style scoped>
.borderStyle {
    border: 1px solid #999;
}
</style>
