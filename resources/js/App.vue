<template>
    <v-layout class="rounded rounded-md side">
        <v-navigation-drawer
            v-model="drawer"
            :rail="rail"
            permanent
            color="#F8F8F8"
            floating
            location="left"
            class="sideBar"
        >
            <NavigationDrawer />
        </v-navigation-drawer>

        <v-main class="d-flex flex-col" style="min-height: 300px">
            <v-card
                variant="flat"
                elevation="1"
                :style="vCardStyle"
                class="min-h-screen d-flex flex-col m-4 ml-4 py-4 px-4 rounded-xl forDash"
            >
                <router-view></router-view>
            </v-card>
        </v-main>
    </v-layout>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { useRoute } from "vue-router"; // Import to get the current route
import NavigationDrawer from "./components/navigationDrawer.vue";
import { useAuthRepository } from "@/store/AuthRepository";

const authRepo = useAuthRepository();
const drawer = ref(true);
const rail = ref(authRepo.rail);

watch(
    () => authRepo.rail,
    (newValue) => {
        rail.value = newValue;
    }
);

// Use Vue Router's `useRoute` to determine the current route
const route = useRoute();
const vCardStyle = computed(() => {
    console.log(route.path);
    return route.path === "/dashboard" // Replace 'dashboard' with the actual name of your route
        ? "background-color:#f8f8f8"
        : "background-color:white";
});
</script>