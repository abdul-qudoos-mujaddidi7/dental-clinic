<template>
    <div class="login-page">
        <v-container class="fill-height d-flex align-center justify-center">
            <v-form @submit.prevent="checkEmail" ref="formRef">
                <div class="form-wrapper">
                    <h2 class="text-center mb-4">Reset Password</h2>

                    <v-text-field
                        v-model="email"
                        label="Enter your email"
                        prepend-inner-icon="mdi-email-outline"
                        variant="outlined"
                        density="compact"
                        :rules="[rules.required, rules.email]"
                    ></v-text-field>

                    <v-btn type="submit" block color="primaryOld">Submit</v-btn>

                    <div v-if="showResetForm" class="mt-4 w-100">
                        <v-text-field
                            v-model="newPassword"
                            label="New Password"
                            type="password"
                            prepend-inner-icon="mdi-lock-outline"
                            variant="outlined"
                        ></v-text-field>
                        <v-text-field
                            v-model="confirmPassword"
                            label="Confirm Password"
                            type="password"
                            prepend-inner-icon="mdi-lock-outline"
                            variant="outlined"
                        ></v-text-field>
                        <v-btn @click="resetPassword" color="primaryOld" block>Reset</v-btn>
                    </div>
                </div>
            </v-form>
        </v-container>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const email = ref("");
const newPassword = ref("");
const confirmPassword = ref("");
const showResetForm = ref(false);
const formRef = ref(null);
const router = useRouter();

const rules = {
    required: (v) => !!v || "Required",
    email: (v) => /.+@.+\..+/.test(v) || "Invalid email",
};

const checkEmail = async () => {
    try {
        await axios.post("/api/forgot-password", { email: email.value });
        showResetForm.value = true;
    } catch (err) {
        alert("Email not found.");
    }
};

const resetPassword = async () => {
    try {
        await axios.post("/api/reset-password", {
            email: email.value,
            password: newPassword.value,
            password_confirmation: confirmPassword.value,
        });
        alert("Password changed successfully!");
        router.push("/login");
    } catch (err) {
        alert("Reset failed. Make sure passwords match.");
    }
};
</script>

<style scoped>
.form-wrapper {
    background-color: #ffffff56;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    /* max-width: 400px; */
    width: 30rem;
    backdrop-filter: blur(4px);
}
</style>
