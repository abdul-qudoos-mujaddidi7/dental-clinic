<template>
    <div class="m-2">
        <div>
            <AppBar mainTitle="Create Permission" subTitle=" Settings" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="primaryOld"
            />
            <v-form ref="formRef">
                <v-row class="py-10">
                    <v-col>
                        <v-text-field
                            v-model="formData.name"
                            label="Role Name *"
                            density="compact"
                            variant="outlined"
                            :rules="[rules.required, rules.validName]"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="formData.description"
                            label="Description"
                            density="compact"
                            variant="outlined"
                            :rules="[rules.required]"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row v-for="(category, index) in permissions" :key="index">
                    <v-col
                        cols="4"
                        v-for="(permission, pIndex) in category.items"
                        :key="pIndex"
                    >
                        <v-card>
                            <v-card-title class="bg-[#ecf1f4] mb-2">{{
                                permission.title
                            }}</v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col>
                                        <v-checkbox
                                            v-model="formData.permissions"
                                            :value="`view${permission.value}`"
                                            label="View"
                                            density="compact"
                                            :class="permission.onlyView ? 'mb-[3.8rem]' : ''"

                                        ></v-checkbox>
                                        <template v-if="!permission.onlyView">
                                            <v-checkbox
                                                v-model="formData.permissions"
                                                :value="`edit${permission.value}`"
                                                label="Edit"
                                                density="compact"
                                            ></v-checkbox>
                                        </template>
                                    </v-col>
                                    <v-col v-if="!permission.onlyView">
                                        <v-checkbox
                                            v-model="formData.permissions"
                                            :value="`create${permission.value}`"
                                            label="Create"
                                            density="compact"
                                        ></v-checkbox>
                                        <v-checkbox
                                            v-model="formData.permissions"
                                            :value="`delete${permission.value}`"
                                            label="Delete"
                                            density="compact"
                                        ></v-checkbox>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-form>
            <div class="d-flex flex-row-reverse mb-6 mx-6 mt-4">
                <v-btn color="#112F53" @click="createRole"> Submit </v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
// Imports
import { useSettingRepository } from "@/store/SettingRepository";
import { reactive, ref } from "vue";
import AppBar from "../../../components/AppBar.vue";
const SettingRepository = useSettingRepository();
const formRef = ref(null);
const rules = {
    required: (value) => !!value || "This field is required.",
    validName: (value) => /^[a-zA-Z\s]*$/.test(value) || "Invalid name format.",
};
const formData = reactive({
    name: "",
    description: "",
    permissions: [],
});
const permissions = reactive([
    // {
    //     items: [{ title: "Dashboard", value: "Dashboard", onlyView: true }],
    // },
    {
        items: [
            { title: "Dashboard", value: "Dashboard" , onlyView: true},
            { title: "Lead", value: "Lead" },
            { title: "Appointment", value: "Appointment" },
        ],
    },
    {
        items: [
            { title: "Cure Cycle", value: "CureCycle" },
            { title: "Expense", value: "Expense" },
            { title: "Bill Expense", value: "BillExpense" },
        ],
    },
    {
        items: [
            { title: "People", value: "People" },
            { title: "Report", value: "Report" },
            { title: "Setting ", value: "Setting" },
        ],
    },
]);

const createRole = async () => {
    if (formRef.value) {
        const isValid = await formRef.value.validate();
        if (isValid) {
            await SettingRepository.CreateRolePermission(formData);
            console.log("Role created successfully:", formData);
        } else {
            console.error("Form validation failed.");
        }
    } else {
        console.error("Form reference is null.");
    }
};
</script>
