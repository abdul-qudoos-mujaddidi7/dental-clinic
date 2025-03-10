<template>
    <v-layout class="rounded rounded-md side">
<<<<<<< HEAD
    <v-navigation-drawer
      v-model="drawer"
      :rail="rail"
      permanent
      color="#F8F8F8"
      floating
      :location="location"
      class="sideBar"
    
    >
      <NavigationDrawer />
    </v-navigation-drawer>
=======
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
>>>>>>> 942de8020f2a25c687d003a441441ce0014bd494

        <v-main
            class="d-flex flex-col custom-scrollbar"
            style="min-height: 300px; overflow: auto"
        >
            <v-card
                variant="flat"
                elevation="1"
                :style="vCardStyle"
                class="min-h-screen d-flex flex-col m-4 ml-4 py-4 px-4 rounded-xl"
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
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();

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

const location= computed(()=>{
    if (locale.value === "fa") {
    return 'right' // Reverse the order for Farsi
  }

  return 'left'
})
</script>
