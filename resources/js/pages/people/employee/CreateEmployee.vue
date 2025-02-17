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
                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                    label="Name  *"
                                    class="w-50 pr-2 pb-4"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                                <v-text-field
                                    v-model="formData.phone"
                                    variant="outlined"
                                    label="phone  *"
                                    :counter="10"
                                    class="w-50 pl-2 pb-4"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                            </div>

                            <div class="flex">
                                <v-text-field
                                    v-model="formData.email"
                                    variant="outlined"
                                    label="Email  *"
                                    type="email"
                                    class="w-50 pr-2 pb-4"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                                <v-text-field
                                    v-model="formData.salary"
                                    variant="outlined"
                                    label="Salary  *"
                                    class="w-50 pl-2 pb-4"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                            </div>
                            <div class="flex">
                      
                                <v-textarea
                                    v-model="formData.address"
                                    label="Address"
                                    variant="outlined"
                                    density="compact"
                                ></v-textarea>
                            </div>
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
import { ref, reactive } from "vue";
import { usePeopleRepository } from "@/store/PeopleRepository";

const PeopleRepository = usePeopleRepository();
const formRef = ref(null);
const formData = reactive({
    id: PeopleRepository.employee.id,
    name: PeopleRepository.employee.name,
    phone: PeopleRepository.employee.phone,
    salary: PeopleRepository.employee.salary,
    email: PeopleRepository.employee.email,
    address: PeopleRepository.employee.address,
    type:"employee"
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
        if (PeopleRepository.isEditMode) {
            await PeopleRepository.UpdateEmployee(formData.id, formData);
        } else {
            await PeopleRepository.CreateEmployee(formData);
        }
        PeopleRepository.isEditMode = false;
    }
};

formData.date = PeopleRepository.getTodaysDate();
</script>

<style scoped>
.borderStyle {
    border: 1px solid #999;
}
</style>
