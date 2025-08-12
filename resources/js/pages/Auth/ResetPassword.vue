<template>
  <div class="bg-cover">
    <div class="login-page">
      <v-container class="fill-height d-flex align-center justify-center">
        <v-form @submit.prevent="submit" ref="formRef">
          <div class="form-wrapper">
            <div class="login-header">
              <h1>Reset Password</h1>
            </div>

            <v-text-field
              v-model="email"
              label="Email"
              type="email"
              readonly
              density="compact"
              prepend-inner-icon="mdi-email-outline"
              variant="outlined"
            />

            <v-text-field
              v-model="password"
              label="New Password"
              type="password"
              density="compact"
              prepend-inner-icon="mdi-lock-outline"
              variant="outlined"
              :rules="[passwordRules]"
            />

            <v-text-field
              v-model="password_confirmation"
              label="Confirm Password"
              type="password"
              density="compact"
              prepend-inner-icon="mdi-lock-outline"
              variant="outlined"
            />

            <v-btn type="submit" block class="submit-btn">
              Reset Password
            </v-btn>

            <p v-if="message" :class="messageClass + ' mt-4 text-center'">{{ message }}</p>
          </div>
        </v-form>
      </v-container>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

const route = useRoute()
const router = useRouter()

const token = ref(route.query.token)
const email = ref(route.query.email)
const password = ref('')
const password_confirmation = ref('')
const message = ref('')
const messageClass = ref('')
const formRef = ref(null)

const passwordRules = (v) => (v && v.length >= 8) || 'Password must be at least 8 characters'

onMounted(() => {
  if (!token.value || !email.value) {
    message.value = 'Invalid reset link.'
    messageClass.value = 'error'
  }
})

const submit = async () => {
  const isValid = await formRef.value.validate()
  if (!isValid) return

  try {
    const res = await axios.post('/reset-password', {
      token: token.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })

    // Show toast notification
    toast.success('Password reset successfully! Redirecting to login...', {
      autoClose: 3000,
      theme: 'colored',
    })

    // Optional visual message (if needed)
    message.value = res.data.message
    messageClass.value = 'success'

    // Redirect after a short delay
    setTimeout(() => {
      router.push('/')
    }, 3000)
  } catch (e) {
    message.value = e.response?.data?.message || 'Failed to reset password.'
    messageClass.value = 'error'

    toast.error(message.value, {
      autoClose: 4000,
      theme: 'colored',
    })
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

.error {
  color: red;
}

.success {
  color: green;
}
</style>
