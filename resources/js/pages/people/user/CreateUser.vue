<template>
 
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

                    <v-card-text >
                        <v-form ref="formRef" >
                            <v-text-field
                                v-model="formData.firstName"
                                variant="outlined"
                                label="Name *"
                                class="pb-4"
                                density="compact"
                                :rules="[rules.required, rules.name]"
                            ></v-text-field>

                            <v-text-field
                                v-model="formData.phone"
                                variant="outlined"
                                label="Phone *"
                                density="compact"
                                :counter="10"
                                type="tel"
                                class="pb-4"
                                :rules="[rules.required, rules.phoneNumber]"
                            ></v-text-field>
                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.email"
                                    variant="outlined"
                                    density="compact"
                                    label="Email *"
                                    :rules="[rules.required, rules.email]"
                                    class="w-50 pb-4 pr-2"
                                >
                                </v-text-field>
                                <v-text-field
                                    v-model="formData.password"
                                    label="Password *"
                                    variant="outlined"
                                    density="compact"
                                    :rules="[rules.required, rules.password]"
                                    class="w-50 pb-4 pl-2"
                                >
                                </v-text-field>
                            </div>
                            <div class="flex w-100">
                                <v-autocomplete
                                    v-model="formData.roleId"
                                    :items="PeopleRepository.roleForUser"
                                    item-value="id"
                                    item-title="name"
                                    variant="outlined"
                                    density="compact"
                                    label="Role *"
                                    :rules="[rules.required]"
                                    class="w-50 pb-4 pr-2"
                                >
                                </v-autocomplete>
                                <div class="w-50 pl-2">
                                    <div class="w-100 h-75 pb-[1.1rem] d-flex">
                                        <div
                                            class="w-100 rounded flex justify-end borderStyle   "
                                        >
                                            <v-switch
                                                v-model="formData.status"
                                                :true-value="1"
                                                :false-value="0"
                                                class="pr-2"
                                                :color="
                                                    formData.status
                                                        ? '#ED4B9E'
                                                        : 'grey'
                                                "
                                                :label="
                                                    formData.status
                                                        ? ' Active'
                                                        : 'Un active'
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
                                PeopleRepository.isEditMode
                                    ? "Update"
                                    : "Submit"
                            }}
                        </v-btn>
                    </div>
                </v-card>
            </template>
        </v-dialog>

</template>

<script setup>
import { ref, reactive } from "vue";
import { usePeopleRepository } from "@/store/PeopleRepository";

const PeopleRepository = usePeopleRepository();
const formRef = ref(null);
const formData = reactive({
    id: PeopleRepository.user.id,
    firstName: PeopleRepository.user.firstName,
    phone: PeopleRepository.user.phone,
    status: PeopleRepository.user.status,
    email: PeopleRepository.user.email,
    password: PeopleRepository.user.password,
    roleId: PeopleRepository.user.role?.name,
    lastName:"amn"
});
const rules = {
    required: (value) => !!value || "This field is required.",
    name: (value) =>
        /^[a-zA-Z\u0600-\u06FF\s]*$/.test(value) ||
        "Please enter a valid name.",
    password: (value) =>
        (value && value.length >= 8) ||
        "Password must be at least 8 characters.",
    email: (value) =>
        /^\S+@\S+\.\S+$/.test(value) || "Please enter a valid email address.",
    number: (value) => /^[0-9]+$/.test(value) || "Please enter a valid number.",
    phoneNumber: (value) =>
        /^(\+?[0-9]{10,15})$/.test(value) ||
        "Please enter a valid phone number (10-15 digits).",
};

const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        if (PeopleRepository.isEditMode) {
            await PeopleRepository.UpdateUser(formData.id, formData);
        } else {
            await PeopleRepository.CreateUser(formData);
        }
    }
};
PeopleRepository.fetchRoleForUser()
</script>
<style  scoped>
.borderStyle{
    border: 1px solid #999;
}
</style>
