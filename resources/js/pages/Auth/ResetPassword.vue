<template>
  <v-container>
    <v-form @submit.prevent="submit">
      <v-text-field
        v-model="email"
        label="Email"
        type="email"
        required
        :readonly="true"
        outlined
      />
      
      <v-text-field
        v-model="password"
        label="New Password"
        type="password"
        required
        outlined
        :rules="[passwordRules]"
      />
      
      <v-text-field
        v-model="password_confirmation"
        label="Confirm Password"
        type="password"
        required
        outlined
      />
      
      <v-btn type="submit" color="primary">Reset Password</v-btn>
      <p v-if="message" :class="messageClass">{{ message }}</p>
    </v-form>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const token = ref(route.query.token);  // Get token from URL
const email = ref(route.query.email);  // Get email from URL
const password = ref('');
const password_confirmation = ref('');
const message = ref('');
const messageClass = ref('');

// Validation rule for password field (minimum 8 characters)
const passwordRules = (v) => (v && v.length >= 8) || 'Password must be at least 8 characters';

onMounted(() => {
  if (!token.value || !email.value) {
    message.value = "Invalid reset link.";
    messageClass.value = 'error';
  }
});

const submit = async () => {
  try {
    // Send reset request to the backend
    const res = await axios.post('/reset-password', {
      token: token.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    });

    message.value = res.data.message;
    messageClass.value = 'success';
  } catch (e) {
    message.value = e.response?.data?.message || 'Failed to reset password.';
    messageClass.value = 'error';
  }
};
</script>

<style scoped>
.error {
  color: red;
}
.success {
  color: green;
}
</style>
