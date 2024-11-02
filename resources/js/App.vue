<template>
    <!-- <v-responsive class="border rounded" max-height="300"> -->
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
                class="bg-white min-h-screen d-flex flex-col m-4 ml-4 py-4 px-4 rounded-xl"
            >
                <!-- <router-view></router-view> -->

                <router-view></router-view>
            </v-card>
        </v-main>
    </v-layout>
    <!-- </v-responsive> -->
</template>

<script setup>
// Components are temporarily removed for testing
import AppBar from "./components/AppBar.vue";
import NavigationDrawer from "./components/navigationDrawer.vue";
import { ref, watch } from "vue";
import { useAuthRepository } from "@/store/AuthRepository"; // Adjust the import path if necessary
const authRepo = useAuthRepository();

const drawer = ref(true); // Set to true to make the sidebar open by default
const rail = ref(authRepo.rail); // Bind to the store state

// Watch the store's rail state and update local rail variable
watch(
    () => authRepo.rail,
    (newValue) => {
        rail.value = newValue;
    }
);
</script>
