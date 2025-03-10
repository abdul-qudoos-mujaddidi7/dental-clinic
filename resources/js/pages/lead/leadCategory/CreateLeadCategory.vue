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
                                formTitle
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
                                    :label="$t('fullName')"
                                    class="pr-2 "
                                    density="compact"
                                    :rules="[rules.required,rules.name]"
                                ></v-text-field>

                             
                            </div>
                       
                            
                              
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn color="#112F53" class="px-4" @click="save">
                            {{
                                formTitle
                            }}
                        </v-btn>
                    </div>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, reactive,computed} from "vue";
import { useLeadRepository } from "@/store/LeadRepository";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const LeadRepository = useLeadRepository();
const formTitle = computed(() => LeadRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => LeadRepository.isEditMode ? t('update') : t('submit'));
const formRef = ref(null);
const formData = reactive({
    id: LeadRepository.category.id,
    name: LeadRepository.category.name,
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
            await LeadRepository.UpdateCategory(formData.id, formData);
        } else {
            await LeadRepository.CreateCategory(formData);
        }
        LeadRepository.isEditMode=false
    }
};

</script>
