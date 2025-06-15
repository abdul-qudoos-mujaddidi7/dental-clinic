<template>
    <v-layout class="rounded rounded-md side">
        <v-navigation-drawer
            v-model="drawer"
            :rail="rail"
            permanent
            floating
            :location="dir"
            class="sideBar bg-lightSectionBg"
        >
            <NavigationDrawer :dir="isRtl ? 'rtl' : 'ltr'" />
        </v-navigation-drawer>

        <v-main class="d-flex flex-col" style="min-height: 300px">
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
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useAuthRepository } from "@/store/AuthRepository";


// Determine if the language is RTL
const isRtl = ref(['fa', 'pa'].includes(locale.value));

// Watch for locale changes
watch(locale, (newLocale) => {
    isRtl.value = ['fa', 'pa'].includes(newLocale);
});

// Drawer and rail state
const authRepo = useAuthRepository();
const drawer = ref(true);
const rail = ref(authRepo.rail);

// Sync rail state with authRepo
watch(
    () => authRepo.rail,
    (newValue) => {
        rail.value = newValue;
    }
);

// Layout direction (used for drawer alignment etc.)
const dir = computed(() => (isRtl.value ? 'right' : 'left'));


// Use Vue Router's `useRoute` to determine the current route
const route = useRoute();
import { useTheme } from "vuetify";

const theme = useTheme();

const vCardStyle = computed(() => {
    const colors = theme.current.value.colors;

    if (route.path === "/dashboard") {
        return `background-color: ${colors.background};`;
    }

    return `background-color: ${colors.background};`;
});
</script>

<style scoped>
.scrollable-content {
    max-height: 80vh;
    overflow-y: auto;
    /* direction: ltr; */
}
.scrollable-content::-webkit-scrollbar {
    width: 4px;
    display: none;
}

.scrollable-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.scrollable-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.scrollable-content::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
