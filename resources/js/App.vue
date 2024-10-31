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

        <v-main class="d-flex flex-col" style="min-height: 300px"  >
            <v-card
            variant="flat"
            elevation="2"
                class="bg-white min-h-screen d-flex flex-col m-4 ml-4 py-8 px-4 rounded-xl"  
            >
                <!-- <router-view></router-view> -->
                <AppBar mainTitle="idk" subTitle="mani" />
                <!-- <table
                class="min-w-50 table-auto border-collapse border border-red-300"
            >
                <thead>
                    <tr
                        class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white"
                    >
                        <th
                            class="px-6 py-3 text-left border-b border-gray-300"
                        >
                            Name
                        </th>
                        <th
                            class="px-6 py-3 text-left border-b border-gray-300"
                        >
                            Age
                        </th>
                        <th
                            class="px-6 py-3 text-left border-b border-gray-300"
                        >
                            Email
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-blue-100 hover:bg-blue-200 transition duration-300"
                    >
                        <td class="px-6 py-4 border-b border-gray-300">
                            John Doe
                        </td>
                        <td class="px-6 py-4 border-b border-gray-300">25</td>
                        <td class="px-6 py-4 border-b border-gray-300">
                            john@example.com
                        </td>
                    </tr>
                    <tr
                        class="bg-green-100 hover:bg-green-200 transition duration-300"
                    >
                        <td class="px-6 py-4 border-b border-gray-300">
                            Jane Smith
                        </td>
                        <td class="px-6 py-4 border-b border-gray-300">30</td>
                        <td class="px-6 py-4 border-b border-gray-300">
                            jane@example.com
                        </td>
                    </tr>
                    <tr
                        class="bg-yellow-100 hover:bg-yellow-200 transition duration-300"
                    >
                        <td class="px-6 py-4 border-b border-gray-300">
                            Mike Johnson
                        </td>
                        <td class="px-6 py-4 border-b border-gray-300">28</td>
                        <td class="px-6 py-4 border-b border-gray-300">
                            mike@example.com
                        </td>
                    </tr>
                    <tr
                        class="bg-pink-100 hover:bg-pink-200 transition duration-300"
                    >
                        <td class="px-6 py-4 border-b border-gray-300">
                            Emily Davis
                        </td>
                        <td class="px-6 py-4 border-b border-gray-300">22</td>
                        <td class="px-6 py-4 border-b border-gray-300">
                            emily@example.com
                        </td>
                    </tr>
                </tbody>
            </table> -->
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
