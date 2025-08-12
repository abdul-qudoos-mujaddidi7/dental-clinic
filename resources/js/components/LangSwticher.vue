<template>
    <v-menu transition="scale-transition">
        <template #activator="{ props }">
            <v-btn
                v-bind="props"
                variant="text"
                class="d-flex align-center text-capitalize font-medium"
            >
                <v-icon left>mdi-web</v-icon>
                <span class="mr-1">{{ $t("select_language") }}</span>
                <v-icon size="small">mdi-chevron-down</v-icon>
            </v-btn>
        </template>

        <v-list>
            <v-list-item
                v-for="item in languages"
                :key="item.lang"
                @click="changeLanguage(item.lang)"
            >
                <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script setup>
import { useI18n } from "vue-i18n";
import { ref } from "vue";

const { t, locale } = useI18n();

const languages = [
    { title: t("english"), lang: "en" },
    { title: t("دری"), lang: "fa" },
    { title: t("پښتو"), lang: "pa" },
];

const changeLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem("locale", lang);
};
</script>

<style scoped>
.icon-wrapper {
    padding: 0.4rem;
    border-radius: 0.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
