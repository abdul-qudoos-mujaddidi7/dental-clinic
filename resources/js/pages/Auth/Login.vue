<!-- b81B5XC1fMP7fItVMrfkhAiHmfJnMKzPll1pFlCJ78QWx79XVQp06gQY -->
<template>
    <div class="bg-cover">
        <div class="login-page">
            <v-container class="fill-height d-flex align-center justify-center">
                <v-form @submit.prevent="loginFunc" ref="formRef">
                    <div class="form-wrapper">
                        <div class="login-header">
                            <h1>Login </h1>
                        </div>

                        <v-text-field
                            v-model="formData.email"
                            density="compact"
                            placeholder="Email"
                            prepend-inner-icon="mdi-email-outline"
                            variant="outlined"
                            :rules="[rules.required, rules.email]"
                        ></v-text-field>

                        <v-text-field
                            v-model="formData.password"
                            :append-inner-icon="
                                visible ? 'mdi-eye-off' : 'mdi-eye'
                            "
                            :type="visible ? 'text' : 'password'"
                            density="compact"
                            placeholder="enter your password "
                            prepend-inner-icon="mdi-lock-outline"
                            variant="outlined"
                            @click:append-inner="visible = !visible"
                            :rules="[rules.required, rules.password]"
                        ></v-text-field>

                        <v-btn
                            class="submit-btn"
                            color="white"
                            block
                            type="submit"
                        >
                            Log In 
                        </v-btn>
                    </div>
                </v-form>
            </v-container>
        </div>
    </div>
</template>

<script setup>
import { useAuthRepository } from "@/store/AuthRepository";
import { ref, reactive } from "vue";

const AuthRepository = useAuthRepository();

// Form state and visibility for password
const formData = reactive({
    email: "",
    password: "",
});
const visible = ref(false);
const formRef = ref(null);

// Validation rules
const rules = {
    required: (value) => !!value || "This field is required", // Required validation
    email: (value) => /.+@.+\..+/.test(value) || "Invalid email address", // Simple email validation
    password: (value) =>
        (value && value.length >= 3) || "Password must be at least 3 characters long", // Password must be at least 3 characters
};


// Login function
const loginFunc = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        try {
            await AuthRepository.Login(formData);
            console.log("Login successful", formData);
        } catch (error) {
            console.error("Login failed", error);
        }
    }
};
</script>

<style scoped>
.bg-cover {
    background-image: url("https://picsum.photos/1920/1080");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
}

.login-page {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    width: 100vw;
}

.form-wrapper {
    background-color: #ffffff56;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 26rem;
    height: 22rem;
    position: relative;
    backdrop-filter: blur(4px);
}

.login-header h1 {
    font-size: 24px;
    margin-bottom: 20px;
    font-weight: bold;
    text-align: center;
}

.submit-btn {
    background-color: #1e88e5;
    color: white;
    margin-top: 20px;
}

.submit-btn:hover {
    background-color: #1565c0;
}

.v-text-field {
    margin-bottom: 20px;
}

.v-card {
    margin-bottom: 20px;
}
</style>
