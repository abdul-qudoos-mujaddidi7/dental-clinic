<template>
    <router-view></router-view>
</template>

<script setup>
import { useSettingRepository } from "./store/SettingRepository";
const SettingRepository = useSettingRepository();
SettingRepository.FetchSystemSettings();
// import { ref, watch, computed } from "vue";
// import { useRoute } from "vue-router"; // Import to get the current route
// import NavigationDrawer from "./components/navigationDrawer.vue";
// import { useAuthRepository } from "@/store/AuthRepository";

// const authRepo = useAuthRepository();
// const drawer = ref(true);
// const rail = ref(authRepo.rail);

// watch(
//     () => authRepo.rail,
//     (newValue) => {
//         rail.value = newValue;
//     }
// );


// // Use Vue Router's `useRoute` to determine the current route
// const route = useRoute();
// const vCardStyle = computed(() => {
//     console.log(route.path);
//     return route.path === "/dashboard" // Replace 'dashboard' with the actual name of your route
//         ? "background-color:#f8f8f8"
//         : "background-color:white";
// });
</script>

