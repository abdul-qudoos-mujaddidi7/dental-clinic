<template>
    <v-list
        class="flex flex-col min-h-screen"
        @update:model="handleDrawerState"
    >
        <router-link to="/dashboard">
            <div class="flex items-center justify-center py-4">
                <img
                    :src="SettingRepository.systemSettings.photo"
                    alt="Logo"
                    class="w-[4rem] h-[4rem] rounded-full object-cover transition-all duration-300"
                />
            </div>
        </router-link>

        <!-- Scrollable content with hidden scrollbar -->
        <div class="scrollable-content overflow-y-auto max-h-[80vh]">
            <router-link to="/dashboard">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    value="home"
                    prepend-icon="mdi mdi-home-lightning-bolt-outline"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                    >{{ t("dashboard") }}
                </v-list-item>
            </router-link>
            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi mdi-gauge"
                value="lead"
                @click="toggleMenu('lead')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                {{ t("leads") }}
            </v-list-item>

            <transition name="slide-fade">
                <v-list v-show="activeMenu === 'lead'" class="pl-4">
                    <router-link
                        v-for="item in leadItems"
                        :key="item.to"
                        :to="item.to"
                    >
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>
            <!-- appointment -->
            <router-link to="appointments">
                <v-list-item
                    @click="toggleMenu('appointment')"
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi mdi-calendar-clock"
                    value="appointment"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    {{ t("appointment") }}
                </v-list-item>
            </router-link>
            <!-- cure cycle  -->
            <router-link to="cure">
                <v-list-item
                    @click="toggleMenu('cureCycle')"
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-tooth-outline"
                    value="cure"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    {{ t("cureCycle") }}
                </v-list-item>
            </router-link>

            <!-- main lab -->
            <router-link to="mainLaboratory">
                <v-list-item
                    @click="toggleMenu('inboundLaboratory')"
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-microscope"
                    value="in lab"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    {{ t("inboundLaboratory") }}
                </v-list-item>
            </router-link>
            <router-link to="laboratory">
                <v-list-item
                    @click="toggleMenu('outboundLaboratory')"
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-microscope"
                    value="out lab"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    {{ t("outboundLaboratory") }}
                </v-list-item>
            </router-link>

            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi mdi-cash-marker"
                value="expenses"
                @click="toggleMenu('expense')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                {{ t("expense") }}
            </v-list-item>

            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'expense'" class="pl-4">
                    <router-link
                        v-for="item in navItems"
                        :key="item.to"
                        :to="item.to"
                    >
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>
            <!-- people -->
            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi mdi-card-account-details-outline"
                value="people"
                @click="toggleMenu('people')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                {{ t("people") }}
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'people'" class="pl-4">
                    <router-link
                        v-for="item in peopleItems"
                        :key="item.to"
                        :to="item.to"
                    >
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>
            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi-finance"
                value="Reports"
                @click="toggleMenu('reports')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                {{ t("reports") }}
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'reports'" class="pl-4">
                    <router-link
                        v-for="item in reportItems"
                        :key="item.to"
                        :to="item.to"
                    >
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>
            <!-- setting -->
            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi-cog-outline"
                value="Setting"
                @click="toggleMenu('setting')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                {{ t("setting") }}
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'setting'" class="pl-4">
                    <router-link
                        v-for="item in settingItems"
                        :key="item.to"
                        :to="item.to"
                    >
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>
        </div>
        <div class="mt-auto">
            <hr />
            <!-- Profile Clickable Item -->
            <v-list-item
                :prepend-avatar="
                    user.photo ||
                    'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?semt=ais_hybrid&w=740'
                "
                :title="user.name"
                :subtitle="user.email"
                nav
                class="px-4 py-2 cursor-pointer"
                @click="dialog = true"
            />

            <!-- Profile Pop-up (Dialog) -->
            <v-dialog v-model="dialog" max-width="350">
                <v-card class="text-center">
                    <v-card-text>
                        <v-avatar size="80">
                            <img
                                :src="
                                    user.photo ||
                                    'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?semt=ais_hybrid&w=740'
                                "
                                alt="Profile Photo"
                            />
                        </v-avatar>
                        <h3 class="mt-3">{{ user.name }}</h3>
                        <p class="text-gray-500">{{ user.email }}</p>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="error" block @click="logout"
                            >Log Out</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </v-list>
</template>

<script setup>
import { computed, ref, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";
const { t } = useI18n();
import { useAuthRepository } from "../store/AuthRepository";
import { useSettingRepository } from "../store/SettingRepository";
const SettingRepository = useSettingRepository();
SettingRepository.FetchSystemSettings();
const route = useRoute();
const AuthRepository = useAuthRepository();
console.log(SettingRepository.systemSettings, "shajryan ");
console.log(AuthRepository.user, "data");
const dialog = ref(false);

const user = ref({
    name: "",
    email: "",
    photo: "",
});

onMounted(() => {
    const storedUser = sessionStorage.getItem("user");
    if (storedUser) {
        const parsed = JSON.parse(storedUser);
        user.value.name = parsed.name;
        user.value.email = parsed.email;
        user.value.photo = parsed.photo;
    }
});

const logout = () => {
    console.log("Logging out...");
    AuthRepository.Logout();

    // Implement your logout logic here
};

const activeMenu = ref(null);

const toggleMenu = (menu) => {
    activeMenu.value = activeMenu.value === menu ? null : menu;
};

// Define navigation items in a structured list for cleaner handling
const navItems = computed(() => [
    {
        to: "/expense",
        title: t("expense"),
        icon: "mdi mdi-circle-medium",
        value: "AllExpenses",
    },
    {
        to: "/billExpense",
        title: t("billExpense"),
        icon: "mdi mdi-circle-medium",
        value: "billExpense",
    },

    {
        to: "/expenseProducts",
        title: t("products"),
        icon: "mdi mdi-circle-medium",
        value: "expense product",
    },
    {
        to: "/expenseCat",
        title: t("categories"),
        icon: "mdi mdi-circle-medium",
        value: "categories",
    },
]);
// salary
const salaryItems = computed(() => [
    {
        to: "/salary",
        title: t("salary"),
        icon: "mdi mdi-circle-medium",
        value: "salary",
    },

    // {
    //     to: "/appointments",
    //     title: "Appointments",
    //     icon: "mdi mdi-circle-medium",
    //     value: "appointments",
    // },
]);
const peopleItems = computed(() => [
    {
        to: "/employee",
        title: t("employee"),
        icon: "mdi mdi-circle-medium",
        value: "employee",
    },
    {
        to: "/patients",
        title: t("patients"),
        icon: "mdi mdi-circle-medium",
        value: "AllExpenses",
    },
    {
        to: "/user",
        title: t("user"),
        icon: "mdi mdi-circle-medium",
        value: "user",
    },

    {
        to: "/owners",
        title: t("owners"),
        icon: "mdi mdi-circle-medium",
        value: "owner",
    },

    {
        to: "/supplier",
        title: t("supplier"),
        icon: "mdi mdi-circle-medium",
        value: "supplier",
    },
    {
        to: "/customer",
        title: t("customer"),
        icon: "mdi mdi-circle-medium",
        value: "customer",
    },

    {
        to: "/doctors",
        title: t("doctor"),
        icon: "mdi mdi-circle-medium",
        value: "categories",
    },
]);
const labItems = [
    {
        to: "/mainLaboratory",
        title: "Main Laboratory",
        icon: "mdi mdi-circle-medium",
        value: "mainLab",
    },
    {
        to: "/leadCategory",
        title: "Lead Category",
        icon: "mdi mdi-circle-medium",
        value: "user",
    },
    {
        to: "/leadStage",
        title: "Lead Stage",
        icon: "mdi mdi-circle-medium",
        value: "stage",
    },
    // {
    //     to: "/appointments",
    //     title: "Appointments",
    //     icon: "mdi mdi-circle-medium",
    //     value: "appointments",
    // },
];

const leadItems = computed(() => [
    {
        to: "/lead",
        title: t("leads"),
        icon: "mdi mdi-circle-medium",
        value: "lead",
    },
    {
        to: "/leadCategory",
        title: t("leadCategory"),
        icon: "mdi mdi-circle-medium",
        value: "user",
    },
    {
        to: "/leadStage",
        title: t("leadStage"),
        icon: "mdi mdi-circle-medium",
        value: "leadStage", // Adjust value as needed
    },

    // {
    //     to: "/appointments",
    //     title: "Appointments",
    //     icon: "mdi mdi-circle-medium",
    //     value: "appointments",
    // },
]);

const settingItems = computed(() => [
    {
        to: "/systemSetting",
        title: t("systemSetting"),
        icon: "mdi mdi-circle-medium",
        value: "system ",
    },
    {
        to: "/moneyAcc",
        title: t("moneyAccount"),
        icon: "mdi mdi-circle-medium",
        value: "money acc   ",
    },
    {
        to: "/rolePermissions",
        title: t("rolePermission"),
        icon: "mdi mdi-circle-medium",
        value: "roles  ",
    },

    // {
    //     to: "/serviceGroup",
    //     title: "Service Group",
    //     icon: "mdi mdi-circle-medium",
    //     value: "service group  ",
    // },

    {
        to: "/service",
        title: t("service"),
        icon: "mdi mdi-circle-medium",
        value: "service   ",
    },
    {
        to: "/dental-types",
        title: t("dentalTypes"),
        icon: "mdi mdi-circle-medium",
        value: "Dental   ",
    },
]);
const reportItems = computed(() => [
    {
        to: "/profitLoss",
        title: t("profitLoss"),
        icon: "mdi mdi-circle-medium",
        value: "profit",
    },
    {
        to: "/patientsReport",
        title: t("patient"),
        icon: "mdi mdi-circle-medium",
        value: "patients report ",
    },

    {
        to: "/categoryReport",
        title: t("expenseCategory"),
        icon: "mdi mdi-circle-medium",
        value: "cat report  ",
    },

    {
        to: "/productReport",
        title: t("expenseProduct"),
        icon: "mdi mdi-circle-medium",
        value: "expense pro report    ",
    },
    {
        to: "/serviceReport",
        title: t("service"),
        icon: "mdi mdi-circle-medium",
        value: "patients report",
    },
]);

function handleDrawerState(isOpen) {
    if (isOpen) {
        document.body.style.overflow = "hidden";
    } else {
        document.body.style.overflow = "";
    }
}
</script>

<style scoped>
/* Hide scrollbar across all browsers */
/* .child {
    font-size: 14px;
    transition: color 0.3s;
} */
.child > :nth-child(3) {
    /* background-color: red; */
    display: flex;
    justify-content: flex-start;
    width: 2rem;
}

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

/* Smooth slide transition */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* Styling for child items */
.child {
    font-size: 0.875rem;
    transition: color 0.3s ease;
}
.child:hover {
    color: #333;
}
.borderRadius {
    border-top-right-radius: 8px !important;
    border-bottom-right-radius: 8px !important;
}
</style>
