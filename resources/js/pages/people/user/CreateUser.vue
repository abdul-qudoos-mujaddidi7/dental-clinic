<template>
    <v-dialog
        transition="dialog-top-transition"
        width="50rem"
        v-model="PeopleRepository.createDialog"
        class="rtl-dialog"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3">
                <v-card-title class="px-2 pt-4 d-flex justify-space-between">
                    <h2 class="font-weight-bold pl-4">
                        {{
                            PeopleRepository.isEditMode
                                ? $t("update")
                                : $t("create")
                        }}
                    </h2>
                    <v-btn variant="text" @click="isActive.value = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider class="border-opacity-100 mx-6"></v-divider>

                <v-card-text>
                    <v-form ref="formRef">
                        <v-row>
                            <v-col cols="9">
                                <v-text-field
                                    v-model="formData.firstName"
                                    variant="outlined"
                                    :label="t('name')"
                                    class="pb-4"
                                    density="compact"
                                    :rules="[rules.required, rules.name]"
                                ></v-text-field>

                                <v-text-field
                                    v-model="formData.phone"
                                    variant="outlined"
                                    :label="t('phone')"
                                    density="compact"
                                    :counter="10"
                                    type="tel"
                                    class="pb-4"
                                    :rules="[rules.required, rules.phoneNumber]"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <div class="photo-upload-container">
                                    <v-file-input
                                        type="file"
                                        ref="inputRef"
                                        style="display: none"
                                        @change="onChangeImage"
                                    ></v-file-input>

                                    <img
                                        :src="imageSrc"
                                        class="photo-preview"
                                        v-show="imageSrc !== null"
                                    />

                                    <div class="photo-overlay">
                                        <button
                                            v-if="!imageSrc"
                                            type="button"
                                            @click="OpenWindow(inputRef)"
                                            class="overlay-button"
                                        >
                                            <v-icon
                                                size="x-large"
                                                color="blue-grey-lighten-2"
                                                >mdi-camera</v-icon
                                            >
                                        </button>
                                        <button
                                            v-if="imageSrc"
                                            type="button"
                                            @click="CloseWindow()"
                                            class="close-button"
                                        >
                                            <v-icon size="lg" color="red"
                                                >mdi-close</v-icon
                                            >
                                        </button>
                                        <button
                                            v-if="imageSrc"
                                            type="button"
                                            @click="OpenWindow(inputRef)"
                                            class="edit-button"
                                        >
                                            <v-icon size="small"
                                                >mdi-pencil</v-icon
                                            >
                                        </button>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>

                        <div class="flex w-100">
                            <v-text-field
                                v-model="formData.email"
                                variant="outlined"
                                density="compact"
                                :label="t('email')"
                                :rules="[rules.required, rules.email]"
                                class="w-50 pb-4 pr-2"
                            >
                            </v-text-field>
                            <v-text-field
                                v-model="formData.password"
                                :label="t('password')"
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
                                :label="t('role')"
                                :rules="[rules.required]"
                                class="w-50 pb-4 pr-2"
                            >
                            </v-autocomplete>
                            <div class="w-50 pl-2">
                                <div class="w-100 h-75 pb-[1.1rem] d-flex">
                                    <div
                                        class="w-100 rounded flex justify-end borderStyle"
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
                            PeopleRepository.isEditMode
                                ? $t("update")
                                : $t("create")
                        }}
                    </v-btn>
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
import { usePeopleRepository } from "@/store/PeopleRepository";

const PeopleRepository = usePeopleRepository();
const formRef = ref(null);
const formData = reactive({
    id: PeopleRepository.user.id,
    profile_picture: PeopleRepository.user.profilePicture,
    firstName: PeopleRepository.user.firstName,
    phone: PeopleRepository.user.phone,
    status: PeopleRepository.user.status,
    email: PeopleRepository.user.email,
    password: PeopleRepository.user.password,
    roleId: PeopleRepository.user.role?.id,
    lastName: "amn",
});
// profile_picture configuration      |
let imageSrc = ref(PeopleRepository.user.profilePicture);
const inputRef = ref(null);
const onChangeImage = (e) => {
    imageSrc.value = URL.createObjectURL(e.target.files[0]);
    formData.profile_picture = e.target.files[0];
};
const OpenWindow = (action) => {
    if (action) {
        ref(action).value.click();
    }
};
const CloseWindow = () => {
    imageSrc.value = null;
    formData.profile_picture = null;
};
// image configuration^
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
    if (!isValid) return;

    const isImageUrl =
        typeof formData.profile_picture === "string" &&
        formData.profile_picture.startsWith("http");

    const payload = { ...formData };

    // Only include the profile_picture if it's a File (i.e., newly selected)
    if (isImageUrl) {
        delete payload.profile_picture;
    }

    if (PeopleRepository.isEditMode) {
        await PeopleRepository.UpdateUser(formData.id, payload);
    } else {
        await PeopleRepository.CreateUser(payload);
    }
};

PeopleRepository.fetchRoleForUser();
</script>
<style scoped>
.borderStyle {
    border: 1px solid #999;
}
.photo-upload-container {
    position: relative;
    display: inline-block;
    height: 8rem;
    width: 8rem;
    margin-left: 2rem;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 1px solid gray;
}

.photo-preview {
    height: 100%;
    width: 100%;
    object-fit: cover;
}

.photo-overlay {
    position: absolute;
    top: 0;
    height: 100%;
    width: 100%;
    border-radius: 0.5rem;
    background-color: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
}

.overlay-button {
    border: none;
    background-color: transparent;
    cursor: pointer;
}

.close-button {
    position: absolute;
    bottom: -0.25rem;
    right: -0.25rem;
    border: none;
    background-color: transparent;
    /* color: #060505; */
    cursor: pointer;
}

.edit-button {
    position: absolute;
    top: -0.25rem;
    right: -0.25rem;
    border: none;
    background-color: transparent;
    color: #777777;
    cursor: pointer;
}
</style>
