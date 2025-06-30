<template>
  <v-form @submit.prevent="submit">
    <v-text-field v-model="email" label="Email" required />
    <v-btn type="submit">Send Reset Link</v-btn>
    <p>{{ message }}</p>
  </v-form>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const email = ref('')
const message = ref('')
const rules = {
    required: (v) => !!v || "Required",
    email: (v) => /.+@.+\..+/.test(v) || "Invalid email",
};

const submit = async () => {
  try {
    await axios.post('/forgot-password', { email: email.value })
    message.value = res.data.message
  } catch (e) {
    message.value = e.response.data.message || 'Error occurred'
  }
}
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
