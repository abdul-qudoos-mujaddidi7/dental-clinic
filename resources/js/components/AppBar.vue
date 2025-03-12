<template>
    <v-toolbar density="compact" class="" color="white" :order="order">
        <v-btn icon="mdi mdi-menu" @click="toggleSidebar"></v-btn>
        <span dir="rtl" class="breadCrumbSub"> {{ subTitle }}</span> &nbsp; -
        &nbsp;
        <span dir="rtl" class="breadCrumbTitle"> {{ mainTitle }}</span>
        <v-spacer></v-spacer>

        <div class="icon-bar">
            <!-- Render the icons with button-like styling -->
            <div
                class="icon-wrapper"
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
            <div class="icon-wrapper">
                <v-menu transition="scale-transition">
                    <template #activator="{ props }">
                        <v-btn
                            icon="mdi-web"
                            flat
                            fluid
                            class="icon bg-head"
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
                                class="d-flex justify-between align-center gap-4"
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

            <div class="icon-wrapper">
                <!-- <BellIcon class="icon" /> -->
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
                        fill="url(#pattern0_5826_2941)"
                    />
                    <defs>
                        <pattern
                            id="pattern0_5826_2941"
                            patternContentUnits="objectBoundingBox"
                            width="1"
                            height="1"
                        >
                            <use
                                xlink:href="#image0_5826_2941"
                                transform="scale(0.01)"
                            />
                        </pattern>
                        <image
                            id="image0_5826_2941"
                            width="100"
                            height="100"
                            xlink:href="data:image/png;base64,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"
                        />
                    </defs>
                </svg>
            </div>
        </div>
    </v-toolbar>
</template>

<script setup>
import { useAuthRepository } from "@/store/AuthRepository";
import { useI18n } from "vue-i18n";
import { ref ,computed} from "vue";
const AuthRepository = useAuthRepository();

const toggleFullscreen = async () => {
    try {
        if (!document.fullscreenElement) {
            // Enter fullscreen mode
            await document.documentElement.requestFullscreen();
        } else {
            // Exit fullscreen mode
            await document.exitFullscreen();
        }
    } catch (err) {
        console.error("Failed to toggle fullscreen mode:", err);
    }
};

const { t, locale } = useI18n();
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});

const isRtl = ref(false); // Reactive property for RTL

// Define items with icons for language switcher
const items = ref([
    { title: t("english"), lang: "en", icon: "/assets/english.png" },
    { title: t("dari"), lang: "fa", icon: "/assets/dari.png" },
]);

// Function to change language and toggle RTL
const changeLanguage = (lang) => {
    locale.value = lang;
    isRtl.value = lang === "fa"; // Assume 'fa' is the locale code for Dari
};
const toggleSidebar = () => {
    AuthRepository.toggleRail(); // This will update the store and trigger reactivity
};

defineProps(["mainTitle", "subTitle"]);

const order = 0;
</script>

<style scoped>
.icon-bar {
    display: flex;
    gap: 0.5rem;
}

.icon-wrapper {
    background-color: #112f531a; /* Light gray background */
    padding: 0.4rem;
    border-radius: 0.5rem; /* Rounded corners */
    display: flex;
    justify-content: center;
    align-items: center;
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
