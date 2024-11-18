<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="SettingRepository.createDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2 class="font-weight-bold pl-4">
                            {{
                                SettingRepository.isEditMode
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
                            <v-text-field
                                v-model="formData.name"
                                variant="outlined"
                                label="Service Name  *"
                                class="pb-4"
                                density="compact"
                                :rules="[rules.required]"
                            ></v-text-field>

                            <v-text-field
                                v-model="formData.description"
                                variant="outlined"
                                label="Description *"
                                density="compact"
                                class="pb-4"
                                :rules="[rules.required]"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                SettingRepository.isEditMode
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
import { useSettingRepository } from "@/store/SettingRepository";

const SettingRepository = useSettingRepository();
const formRef = ref(null);

const formData = reactive({
    id: SettingRepository.service.id,
    name: SettingRepository.service.name,
    description: SettingRepository.service.description,

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
        if (SettingRepository.isEditMode) {
            await SettingRepository.UpdateService(formData.id, formData);
        } else {
            await SettingRepository.CreateService(formData);
        }
    }
};
</script>
