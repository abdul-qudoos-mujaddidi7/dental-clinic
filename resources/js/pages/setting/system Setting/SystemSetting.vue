<template>
    <div class="all-expense rounded-xl mt-4">
        <div class="card rounded-xl bg-white">
            <AppBar mainTitle="System Settings"  subTitle="setting"/>
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div class="overflow-x-hidden pt-6 w-full">
                <v-app>
                    <v-main class="main rounded-xl ">

                        <form
                            @submit.prevent="CreateComponySetting"
                            class="px-6 pb-4  border-2  rounded-xl"
                        >
                        <h1 class=" p-6">System Setting </h1>

                            <v-row>
                                <v-divider
                                :thickness="2"
                                class="border-opacity-100 mb-8 "
                                color="#d3e2f8"
                            ></v-divider>
                                <v-col cols="10" class="">
                                    <v-text-field
                                        v-model="
                                            SettingRepository.systemSettings
                                                .name
                                        "
                                        :rules="[rules.required, rules.name]"
                                        :counter="10"
                                        label=" * company name  "
                                        variant="outlined"
                                        density="compact"
                                        class="mb-4"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="
                                            SettingRepository.systemSettings.phone
                                        "
                                        :rules="[rules.required, rules.number]"
                                        :counter="10"
                                        label=" * Phone Number "
                                        variant="outlined"
                                        density="compact"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2" class="pb-10">
                                    <button
                                        @click.prevent="triggerFileInput"
                                        class="file-input-button"
                                    >
                                        <v-icon
                                            v-if="
                                                !SettingRepository.systemSettings
                                                    .photo
                                            "
                                            size="x-large"
                                            color="blue-grey-lighten-2"
                                        >
                                            mdi-camera
                                        </v-icon>
                                        <img
                                            v-else
                                            :src="
                                                SettingRepository.systemSettings
                                                    .photo
                                            "
                                            alt="Selected Image"
                                            class="w-full h-full object-cover"
                                        />
                                    </button>
                                    <input
                                        type="file"
                                        ref="fileInput"
                                        accept="image/*"
                                        @change.prevent="handleFileChange"
                                        class="hidden"
                                    />
                                </v-col>
                            </v-row>

                            <div class="d-flex">
                                <v-text-field
                                    v-model="
                                        SettingRepository.systemSettings.address
                                    "
                                    :rules="[rules.required]"
                                    label="* Address"
                                    variant="outlined"
                                    density="compact"
                                    class="pr-2"
                                ></v-text-field>
                                <v-text-field
                                    v-model="SettingRepository.systemSettings.email"
                                    :rules="[rules.required, rules.email]"
                                    label=" * Email "
                                    variant="outlined"
                                    density="compact"
                                    type="email"
                                    class="pl-2"
                                ></v-text-field>
                            </div>

                            <div>
                                <v-btn
                                    class="me-4"
                                    color="primaryOld"
                                    type="submit"
                                    >submit</v-btn
                                >
                            </div>
                        </form>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useSettingRepository } from "@/store/SettingRepository";
import { useRoute, useRouter } from "vue-router";
import AppBar from "@/components/AppBar.vue"
const SettingRepository = useSettingRepository();

import { reactive } from "vue";
const routeParams = useRouter();
const routeParam = useRoute();
// let formData = {}; // Change to object instead of array
let formData = [];
SettingRepository.FetchSystemSettings(routeParam.params.id).then((res) => {
    formData = reactive({
        id: SettingRepository.systemSettings.id, // Store the transfer ID
        name: SettingRepository.systemSettings.name,
        phone: SettingRepository.systemSettings.phone,
        email: SettingRepository.systemSettings.email,
        address: SettingRepository.systemSettings.address,
        photo: SettingRepository.systemSettings.photoUrl,
    });
});
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Set the Blob URL for preview
        SettingRepository.systemSettings.photo = URL.createObjectURL(file);
        // Store the actual file for upload
        SettingRepository.systemSettings.logo = file;
    }
};

const triggerFileInput = () => {
    const fileInput = document.querySelector('input[type="file"]');
    fileInput.click();
};
const rules = {
    required: (value) => !!value || "This Part is Require",
    name: (value) => /^[a-zA-Z\s\u0600-\u06FF]*$/.test(value) || "Invalid Name",
    email: (value) =>
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || "The email is Not valid",
    number: (value) => /^\d+$/.test(value) || "Invalid Number",
};

const CreateComponySetting = async () => {
    formData = reactive({
        id:1,
        name: SettingRepository.systemSettings.name,
        phone: SettingRepository.systemSettings.phone,
        email: SettingRepository.systemSettings.email,
        address: SettingRepository.systemSettings.address,
        logo: SettingRepository.systemSettings.logo,
    });

    await SettingRepository.UpdateSystemSetting(formData);
};
</script>

<style scoped>
.file-input-button {
    display: block;
    width: 150px;
    height: 150px;
    border: 2px solid #ccc;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
}

.file-input-button img {
    width: 100%;
    height: 100%;
    object-fit: cover;

    /* Make the image cover the entire area */
}

.file-input-button::before {
    content: ""; /* Hide the "Choose File" text */
    display: block;
    text-align: center;
    font-size: 16px;
    color: #666;
}

.file-input-button:hover {
    background-color: #f0f0f0; /* Change the background color on hover */
}

.hidden {
    display: none;
}
</style>
