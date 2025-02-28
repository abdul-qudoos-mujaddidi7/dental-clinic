<template>
    <v-list
        class="flex flex-col min-h-screen"
        @update:model="handleDrawerState"
    >
        <router-link to="/dashboard">
  
            <div class="flex items-center justify-center py-4"  >
                <img
                    src="https://i.pinimg.com/736x/a7/7a/a5/a77aa5d8c889c3beee52aa1a7c7dcf23.jpg"
                    alt="Logo"
                    class="w-[4rem] h-[4rem] rounded-full object-cover  transition-all duration-300"
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
                    >Dashboard
                </v-list-item>
            </router-link>
            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi mdi-gauge"
                value="lead"
                @click="toggleLead"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Lead
            </v-list-item>

            <transition name="slide-fade">
                <v-list v-if="isLeadVisible" class="pl-4">
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
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi mdi-calendar-clock"
                    value="appointment"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Appointment
                </v-list-item>
            </router-link>
            <!-- cure cycle  -->
            <router-link to="cure">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-tooth-outline"
                    value="cure"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Cure Cycle
                </v-list-item>
            </router-link>

            <!-- main lab -->
             <router-link to="mainLaboratory">
            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi-microscope"
                value="lab"
              
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Laboratory
            </v-list-item>
             </router-link>
      

            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi mdi-cash-marker"
                value="expenses"
                @click="toggleList"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Expenses
            </v-list-item>

            <transition name="slide-fade">
                <v-list v-if="isListVisible" class="pl-4">
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
                @click="togglePeople"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                People
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="isPeopleVisible" class="pl-4">
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
            <!-- reports -->
            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi-finance"
                value="Reports"
                @click="toggleReports"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Reports
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="isReportVisible" class="pl-4">
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
                @click="toggleSetting"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Setting
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="isSettingVisible" class="pl-4">
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
            <v-list-item
                prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
                title="John Leider"
                nav
                class="px-4 py-2"
            />
        </div>
    </v-list>
</template>

<script setup>
import { ref } from "vue";

// State for list visibility
const isListVisible = ref(false);
const isPeopleVisible = ref(false);
const isLeadVisible = ref(false);
const isCureVisible = ref(false);
const isSettingVisible = ref(false);
const isReportVisible = ref(false);

//
// Toggle for list items
const toggleList = () => {
    isListVisible.value = !isListVisible.value;
};
const togglePeople = () => {
    isPeopleVisible.value = !isPeopleVisible.value;
};
const toggleLead = () => {
    isLeadVisible.value = !isLeadVisible.value;
};
const toggleCure = () => {
    isCureVisible.value = !isCureVisible.value;
};
const toggleSetting = () => {
    isSettingVisible.value = !isSettingVisible.value;
};
const toggleReports = () => {
    isReportVisible.value = !isReportVisible.value;
};

// Define navigation items in a structured list for cleaner handling
const navItems = [
    {
        to: "/expense",
        title: "All Expense",
        icon: "mdi mdi-circle-medium",
        value: "AllExpenses",
    },
    {
        to: "/billExpense",
        title: "Bill Expense",
        icon: "mdi mdi-circle-medium",
        value: "billExpense",
    },

    {
        to: "/expenseProducts",
        title: "Products",
        icon: "mdi mdi-circle-medium",
        value: "expense product",
    },
    {
        to: "/expenseCat",
        title: "Category",
        icon: "mdi mdi-circle-medium",
        value: "categories",
    },
];
const peopleItems = [
    {
        to: "/employee",
        title: "Employee",
        icon: "mdi mdi-circle-medium",
        value: "employee",
    },
    {
        to: "/patients",
        title: "Patient",
        icon: "mdi mdi-circle-medium",
        value: "AllExpenses",
    },
    {
        to: "/user",
        title: "User",
        icon: "mdi mdi-circle-medium",
        value: "user",
    },

    {
        to: "/owners",
        title: "Owner",
        icon: "mdi mdi-circle-medium",
        value: "owner",
    },

    {
        to: "/supplier",
        title: "Supplier",
        icon: "mdi mdi-circle-medium",
        value: "supplier",
    },
    {
        to: "/doctors",
        title: "Doctor",
        icon: "mdi mdi-circle-medium",
        value: "categories",
    },
    {
        to: "/ownerPickup",
        title: "Owner Pickup",
        icon: "mdi mdi-circle-medium",
        value: "ownerPickup",
    },
    {
        to: "/laboratory",
        title: "Laboratory",
        icon: "mdi mdi-circle-medium",
        value: "lab",
    },
];
const leadItems = [
    {
        to: "/lead",
        title: "Lead",
        icon: "mdi mdi-circle-medium",
        value: "lead",
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

const settingItems = [
    {
        to: "/systemSetting",
        title: "System Setting",
        icon: "mdi mdi-circle-medium",
        value: "system ",
    },
    {
        to: "/rolePermissions",
        title: "Role Permissions",
        icon: "mdi mdi-circle-medium",
        value: "roles  ",
    },

    {
        to: "/serviceGroup",
        title: "Service Group",
        icon: "mdi mdi-circle-medium",
        value: "service group  ",
    },

    {
        to: "/service",
        title: "Service",
        icon: "mdi mdi-circle-medium",
        value: "service   ",
    },
    {
        to: "/dental-types",
        title: "Dental Types",
        icon: "mdi mdi-circle-medium",
        value: "Dental   ",
    },
];
const reportItems = [
    {
        to: "/profitLoss",
        title: "Profit & Loss",
        icon: "mdi mdi-circle-medium",
        value: "profit",
    },
    {
        to: "/patientsReport",
        title: "Patient",
        icon: "mdi mdi-circle-medium",
        value: "patients report ",
    },

    {
        to: "/categoryReport",
        title: "Expense Category",
        icon: "mdi mdi-circle-medium",
        value: "cat report  ",
    },

    {
        to: "/productReport",
        title: "Expense Product",
        icon: "mdi mdi-circle-medium",
        value: "expense pro report    ",
    },
    {
        to: "/pickupReport",
        title: "Pickup",
        icon: "mdi mdi-circle-medium",
        value: "pickup report    ",
    },
    {
        to: "/serviceReport",
        title: "Service Report ",
        icon: "mdi mdi-circle-medium",
        value: "patients report",
    },
];

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
