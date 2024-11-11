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
                       
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                    label="Name *"
                                    class="pb-4"
                                    density="compact"
                                    :rules="[rules.required]"
                                  
                                ></v-text-field>
                     
                            
                            <v-text-field
                                v-model="formData.phone"
                                variant="outlined"
                                label="Phone *"
                                density="compact"
                                :counter="10"
                                type="tel"
                                class="pb-4"
                                :rules="[rules.required]"
                            ></v-text-field>

                       
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
    id: PeopleRepository.owner.id,
    name: PeopleRepository.owner.name,
    phone: PeopleRepository.owner.phone,
  
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
            await PeopleRepository.UpdateOwner(formData.id, formData);
        } else {
            await PeopleRepository.CreateOwner(formData);
        }
    }
};

</script>
