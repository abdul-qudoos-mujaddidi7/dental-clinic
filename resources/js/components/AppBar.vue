<template>
  <v-toolbar density="compact" :order="order" color="background">

        <div class="tool h-10" :dir="dir">
            <div>
                <v-btn icon="mdi mdi-menu" @click="toggleSidebar"></v-btn>
                <span dir="rtl" class="breadCrumbSub"> {{ subTitle }}</span>
                &nbsp; - &nbsp;
                <span dir="rtl" class="breadCrumbTitle"> {{ mainTitle }}</span>
                <!-- <v-spacer></v-spacer> -->
            </div>

            <div class="icon-bar">
                <!-- Render the icons with button-like styling -->
                <div
                    class="icon-wrapper bg-iconWrapperBg"
                    @click="toggleFullscreen"
                    style="cursor: pointer"
                >
                    <svg
                        width="20"
                        height="20"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                    >
                        <rect
                            width="16"
                            height="16"
                            fill="url(#pattern0_5826_4251)"
                        />
                        <defs>
                            <pattern
                                id="pattern0_5826_4251"
                                patternContentUnits="objectBoundingBox"
                                width="1"
                                height="1"
                            >
                                <use
                                    xlink:href="#image0_5826_4251"
                                    transform="scale(0.01)"
                                />
                            </pattern>
                            <image
                                id="image0_5826_4251"
                                width="100"
                                height="100"
                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAADL0lEQVR4nO3dv05UQRTH8e8CESpjxMg+gVqjPoMmKr1/ooIvYBYRjAVWxkKQxAR8ANDSxATFUNDDO6gkaCUWYL9mklOQhXvZve7MPcv9fZJpd87M2TtzCbNnQEREREREREREpLr6gCvAXaABTBdot4D+iDGGzx4rGFvDxnbZxupWHVgAfgHNLrTPwECEOMNnfulSjD+BN8AIjtSAKeBvlwbZPNAmIsT7KEKc+8CkzUWphoAPEQbYtLYUIeZ3EeN9b3NSilrkZDRtze626cgxr5T1pExFHtgPYDhC3OEztyPHHpav5Bv4/jFB7QGbwHqH7SvwOvJGGeKfs746jW+zzbEn3egXcoL5DTwATnFyDQIPgd2ceZhPFUxfzqttSMYFquNiTlJ2Uu0lV3O+FeHJqJrxnPkIfzxGdydn3TzJy1Te8pW1p9wmgScZnYfNrqq2ynzbepHR+QbVtZExJ2GuolNCDlNCnFFCnFFCnFFCnFFCnFFCnFFCnFFCnFFCnFFCnCk1Ic8zOg//Tauq9Yw5CXMV3VhG5+HfrlU1lzEnN1N03m+H2FoPJLg6LJZY/YiDE6spTzYO2CG2ReBppNMhvWbYjhgt2tzEOHUpIiIiIiIiIiIiIiIiIiIiBU6e3AfeWv2o05pBztiPPMOc3Et54iT8GP5Ty5GXb8DZCiflHPC9ZU4+pioccD3jUNhLqutVxpxcS9H5s4zO16iutYw5mUnRuX4WfZhOvzujhDijhDijhDijhDijhDijhDijhDijhDijhDijhDhTakJUBNNZEcy8MrGhZGrVDJZdJjavkHIov101E2UXUu6zm2WOCmDXym9XxSUPpcaxa36yvhW7Vn77JC9fg/Zk/MmZh1BuI5mRNq5s2LfNrsh1FXNWriKWut1eUOS6iq02r6s4T2KTxwT1v227hy90eUwJanbnUq9deTQTOeZlSjRkdy7FGtxSj10KtlzmpWAHn5RGG+tqkTae+DW1aNsra5k6bqOft9e9bgxyNeLFkq31voq2HXsBSb6Bd/rEjNpf9A07RNZJmwVuRD6K2W/V3mYLxNewsY16uEhSRERERERERESEkvwDZNYrhwPCZysAAAAASUVORK5CYII="
                            />
                        </defs>
                    </svg>
                </div>
                <div class="icon-wrapper bg-iconWrapperBg">
                    <v-menu transition="scale-transition">
                        <template #activator="{ props }">
                            <v-btn
                                icon="mdi-web"
                                flat
                                fluid
                             
                                class="icon bg-head "
                                size="small"
                                v-bind="props"
                            ></v-btn>
                        </template>

                        <v-list>
                            <v-list-item
                                v-for="item in items"
                                :key="item.title"
                                @click="changeLanguage(item.lang)"
                            >
                                <div
                                    class="d-flex justify-between align-center gap-4 bg-iconWrapperBg"
                                >
                                    <v-list-item-icon>
                                        <img
                                            :src="item.icon"
                                            alt="Language Icon"
                                            class="icon-size"
                                            width="22"
                                            height="22"
                                        />
                                    </v-list-item-icon>
                                    <v-list-item-title>{{
                                        item.title
                                    }}</v-list-item-title>
                                </div>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>

                <div class="icon-wrapper bg-iconWrapperBg">
                    <v-btn flat fluid class="" icon @click="toggleTheme">
                        <v-icon>{{
                            isDarkTheme
                                ? "mdi-weather-night-partly-cloudy"
                                : "mdi-weather-sunny"
                        }}</v-icon>
                    </v-btn>
                </div>
            </div>
        </div>
    </v-toolbar>
</template>

<script setup>
import { useAuthRepository } from "@/store/AuthRepository";
import { useI18n } from "vue-i18n";
import {useTheme} from "vuetify"
import { ref, computed, watch, onMounted } from "vue";

const AuthRepository = useAuthRepository();
const { t, locale } = useI18n();
const theme = useTheme();

// Initialize with saved language or default to 'en'
const savedLang = localStorage.getItem("locale") || 'en';
locale.value = savedLang;
const isRtl = ref(['fa', 'pa'].includes(savedLang)); // Check if saved language is RTL

watch(locale, (newLocale) => {
    isRtl.value = ['fa', 'pa'].includes(newLocale);
    localStorage.setItem("locale", newLocale); // Save to localStorage on change
});

const toggleFullscreen = async () => {
    try {
        if (!document.fullscreenElement) {
            await document.documentElement.requestFullscreen();
        } else {
            await document.exitFullscreen();
        }
    } catch (err) {
        console.error("Failed to toggle fullscreen mode:", err);
    }
};

const dir = computed(() => {
    return ['fa', 'pa'].includes(locale.value) ? "rtl" : "ltr";
});

// Define items with icons for language switcher
const items = ref([
    { title: t("english"), lang: "en", icon: "/assets/english.png" },
    { title: t("dari"), lang: "fa", icon: "/assets/dari.png" },
    { title: t("pashto"), lang: "pa", icon: "/assets/dari.png" },
]);

// Function to change language
const changeLanguage = (lang) => {
    locale.value = lang;
};

const toggleSidebar = () => {
    AuthRepository.toggleRail();
};

const toggleTheme = () => {
  theme.global.name.value = theme.global.name.value === 'myCustomLightTheme'
    ? 'myCustomDarkTheme'
    : 'myCustomLightTheme'
}

const isDarkTheme = computed(() => theme.global.current.value.dark)
defineProps(["mainTitle", "subTitle"]);

const order = 0;
</script>

<style scoped>
.icon-bar {
    display: flex;
    gap: 0.5rem;
}

.icon-wrapper {
    /* background-color: #112f531a;      */
    padding: 0.4rem;
    border-radius: 0.5rem; /* Rounded corners */
    display: flex;
    justify-content: center;
    align-items: center;
}

.tool {
    display: flex;
    width: 100%;
    justify-content: space-between;

    /* background-color: aquamarine; */
}
.icon {
    width: 24px;
    height: 24px;
    color: #000; /* Black color for the icons */
}

.breadCrumbTitle {
    cursor: pointer;
}

.breadCrumbSub {
    opacity: 0.6;
    cursor: pointer;
}
</style>
