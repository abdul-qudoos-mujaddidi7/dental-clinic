<template>
    <div class="bg-cover">
        <div class="login-page">
            <div class="lang-switch">
                <LangSwticher />
            </div>
            <!-- Language Switch Button -->

            <!-- Login Form -->
            <v-container class="fill-height d-flex align-center justify-center">
                <v-form
                    @submit.prevent="loginFunc"
                    ref="formRef"
                    lazy-validation
                >
                    <div class="form-wrapper">
                        <div class="login-header">
                            <h1>{{ $t("login.title") }}</h1>
                        </div>

                        <v-text-field
                            v-model="formData.email"
                            density="compact"
                            :placeholder="$t('login.email')"
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
                            :placeholder="$t('login.password')"
                            prepend-inner-icon="mdi-lock-outline"
                            variant="outlined"
                            @click:append-inner="visible = !visible"
                            :rules="[rules.required, rules.password]"
                        ></v-text-field>
                        <v-btn
                            class="submit-btn"
                            color="primaryOld"
                            block
                            type="submit"
                        >
                            {{ $t("login.button") }}
                        </v-btn>

                        <div class="text-end pt-4 text-primaryOld">
                            <router-link to="/forgot-password">
                                <a
                                    @click="goToForgotPassword"
                                    class="forgot-link"
                                >
                                    {{ $t("login.forgot") }}
                                </a>
                            </router-link>
                        </div>
                    </div>
                </v-form>
            </v-container>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useI18n } from "vue-i18n";

import { useAuthRepository } from "@/store/AuthRepository";
import AppBar from "../../components/AppBar.vue";
import LangSwticher from "../../components/LangSwticher.vue";

const formIsValid = ref(false);

const router = useRouter();
const { t, locale } = useI18n();
const AuthRepository = useAuthRepository();

const formData = reactive({
    email: "",
    password: "",
});
const visible = ref(false);
const formRef = ref(null);

// Validation rules
const rules = {
    required: (v) => !!v || t("validation.required"),
    email: (v) => /.+@.+\..+/.test(v) || t("validation.email"),
    password: (v) =>
        (!!v && v.trim().length >= 3) || t("validation.passwordLength"),
};

const validateForm = async () => {
    const result = await formRef.value?.validate();
    formIsValid.value = !!result?.valid;
};

// Login
const loginFunc = async () => {
    // 1. Check that both fields exist in the DOM
    const emailInput = document.querySelector(
        'input[type="text"][placeholder]'
    );
    const passwordInput = document.querySelector(
        'input[type="password"], input[type="text"][placeholder="' +
            t("login.password") +
            '"]'
    );

    // 2. Validate that inputs are present and not empty
    if (
        !emailInput ||
        !passwordInput ||
        emailInput.value.trim().length === 0 ||
        passwordInput.value.trim().length < 3
    ) {
        alert(t("validation.bothFields"));
        return;
    }

    // 3. Vue validation
    const isValid = await formRef.value?.validate?.();
    if (!isValid?.valid) {
        console.warn("Validation failed");
        return;
    }

    try {
        await AuthRepository.Login(formData);
        console.log("Login successful");
    } catch (err) {
        console.error("Login failed", err);
    }
};

onMounted(() => {
    const observer = new MutationObserver(() => {
        const input = document.querySelector('input[type="password"]');
        if (!input) formData.password = "";
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });
});

const goToForgotPassword = () => {};
// Language switch logic
const languages = [
    { title: t("english"), lang: "en", icon: "/assets/english.png" },
    { title: t("دری"), lang: "fa", icon: "/assets/dari.png" },
    { title: t("پښتو"), lang: "pa", icon: "/assets/dari.png" },
];

const changeLanguage = (lang) => {
    locale.value = lang;
};
</script>

<style scoped>
.forgot-link {
    font-size: 0.9rem;
    color: primaryOld;
    cursor: pointer;
    text-decoration: underline;
    margin-top: -10px;
    display: inline-block;
}
.forgot-link:hover {
    color: primaryOld;
}
.bg-cover {
    background-image: url("https://picsum.photos/1920/1080");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
}
.login-page {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    width: 100vw;
}
.lang-switch {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 10;
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
.lang-switch {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 10;
}
</style>
