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
                                    v-model="formData.date"
                                    variant="outlined"
                                    label="Date  *"
                                    class="w-50 pr-2  pb-4"
                                    type="date"
                                    density="compact"
                                    :rules="[rules.required]"
                                    
                                ></v-text-field>
                                <v-text-field
                                    v-model="formData.time"
                                    variant="outlined"
                                    label="time  *"
                                    class="w-50 pl-2 pb-4"
                                    type="time"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                              
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
                                <div class="w-100 ">
                                <div class="w-100 h-100 pb-[1.1rem] d-flex">
                                    <div
                                        class="w-100 rounded flex justify-start pl-4 borderStyle"
                                    >
                                        <v-switch
                                            v-model="formData.status"
                                            :true-value="1"
                                            :false-value="0"
                                            class="pr-2"
                                            :color="
                                                formData.status == 1
                                                    ? '#ED4B9E'
                                                    : 'grey'
                                            "
                                            :label="
                                                formData.status == 1
                                                    ? 'Active'
                                                    : 'Unactive'
                                            "
                                            hide-details
                                            density="compact"
                                        ></v-switch>
                                    </div>
                                </div>
                            </div>
                              
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

const LeadRepository = useLeadRepository();
const formRef = ref(null);
const formData = reactive({
    id: LeadRepository.appointment.id,
    date: LeadRepository.appointment.date,
    time: LeadRepository.appointment.time,
    status: LeadRepository.appointment.status,
    patientId: LeadRepository.appointment.patients?.id,
    dentistId: LeadRepository.appointment.dentist?.id,
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