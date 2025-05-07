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
                            {{ PeopleRepository.isEditMode ? $t("update") : $t("create") }}
                        </h2>
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider class="border-opacity-100 mx-6"></v-divider>

                    <v-card-text>
                        <v-form ref="formRef" class="pt-4">
                            <div class="w-100 flex">
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                     :label="$t('name')"
                                    class="pb-4 w-100"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-text-field>
                                <!-- <v-autocomplete
                                    v-model="formData.type"
                                    :items="selectType"
                                    :return-object="false"
                                    variant="outlined"
                                    :label="$t('type')"

                                    class="pr-2 pl-2 pb-4 w-50"
                                    style="width: 45%"
                                    item-value="id"
                                    item-title="name"
                                    density="compact"
                                    :rules="[rules.required]"
                                ></v-autocomplete> -->
                            </div>

                            <v-text-field
                                v-model="formData.phone"
                                variant="outlined"
                                :label="$t('phone')"

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
                            {{ PeopleRepository.isEditMode ? $t("update") : $t("submit") }}
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
import Supplier from "./Supplier.vue";

const PeopleRepository = usePeopleRepository();
const formRef = ref(null);

const selectType = [
    { id: "supplier", name: "Supplier" },
    { id: "customer", name: "Customer" },
];
const formData = reactive({
    id: PeopleRepository.supplier.id,
    name: PeopleRepository.supplier.name,
    phone: PeopleRepository.supplier.phone,
    type: "supplier",
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
            await PeopleRepository.UpdateSupplier(formData.id, formData);
        } else {
            await PeopleRepository.CreateSupplier(formData);
        }
    }
};
</script>
