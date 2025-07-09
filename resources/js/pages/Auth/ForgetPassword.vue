<template>
  <div class="bg-cover">
    <div class="login-page">
      <v-container class="fill-height d-flex align-center justify-center">
        <v-form @submit.prevent="submit" ref="formRef">
          <div class="form-wrapper">
            <div class="login-header">
              <h1>Forget Password</h1>
            </div>

            <v-text-field
              v-model="email"
              density="compact"
              placeholder="Enter your email"
              prepend-inner-icon="mdi-email-outline"
              variant="outlined"
              :rules="[rules.required, rules.email]"
            ></v-text-field>

            <v-btn
              class="submit-btn"
              color="primaryOld"
              block
              type="submit"
            >
              Send Reset Link
            </v-btn>

            <p class="mt-4 text-center text-primaryOld">{{ message }}</p>
          </div>
        </v-form>
      </v-container>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const email = ref('')
const message = ref('')
const formRef = ref(null)

const rules = {
  required: (v) => !!v || "This field is required",
  email: (v) => /.+@.+\..+/.test(v) || "Invalid email address",
}

const submit = async () => {
  const isValid = await formRef.value.validate()
  if (!isValid) return

  try {
    const res = await axios.post('/forgot-password', { email: email.value })
    message.value = res.data.message
  } catch (e) {
    message.value = e.response?.data?.message || 'An error occurred'
  }
}
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
</style>
