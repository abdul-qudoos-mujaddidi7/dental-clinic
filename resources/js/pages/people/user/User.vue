<template>
    <CreateUser v-if="PeopleRepository.createDialog" />
    <div class="all-expense rounded-xl" :dir="dir">
        <div class="card rounded-xl">
            <AppBar :mainTitle="$t('user')" :sub-title="$t('people')" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>

            <div class="btn-search pt-12 pb-6">
                <div class="text-field w-25">
                    <v-text-field
                        :loading="loading"
                        color="primaryOld"
                        density="compact"
                        variant="outlined"
                        :label="$t('search')"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="PeopleRepository.userSearch"
                    ></v-text-field>
                </div>
                <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click="CreateDialogShow"
                        color="primaryOld"
                        variant="flat"
                        :text="$t('create')"
                        class="px-6"
                    >
                    </v-btn>
                </div>
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    :dir="dir"
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        PeopleRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="PeopleRepository.totalItems"
                                    :items="PeopleRepository.users"
                                    :loading="PeopleRepository.loading"
                                    :search="PeopleRepository.userSearch"
                                    @update:options="
                                        PeopleRepository.FetchUsers
                                    "
                                    :item-key="PeopleRepository.users"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- ========================== -->
                                    <template v-slot:item.name="{ item }">
                                        <div
                                            style="
                                                display: flex;
                                                align-items: center;
                                            "
                                            @click="show(item)"
                                        >
                                            <!-- Container for the image -->

                                            <div
                                                style="
                                                    width: 50px;
                                                    height: 50px;
                                                    overflow: hidden;
                                                    margin-right: 10px;
                                                "
                                            >
                                                <!-- Use inline styles to make the avatar square -->
                                                <v-avatar
                                                    size="42"
                                                    style="
                                                        width: 100%;
                                                        height: 100%;
                                                        border-radius: 0;
                                                    "
                                                >
                                                    <img
                                                        :src="
                                                            item.profilePicture
                                                        "
                                                        alt="Profile Photo"
                                                        style="
                                                            width: 100%;
                                                            height: auto;
                                                            object-fit: cover;
                                                        "
                                                    />
                                                </v-avatar>
                                            </div>
                                            <!-- Display the name with some space -->
                                            <span style="margin-right: 10px">{{
                                                item.firstName
                                            }}</span>
                                        </div>
                                    </template>
                                    <!-- ================================= -->
                                    <!-- Checkbox for selecting rows -->

                                    <template v-slot:item.checkbox="{ item }">
                                        <v-checkbox
                                            :value="item.id"
                                            v-model="selectedIds"
                                            class="w-6 d-flex"
                                        ></v-checkbox>
                                    </template>
                                    <template v-slot:item.status="{ item }">
                                        <div class="pr-14">
                                            <v-switch
                                                v-model="item.status"
                                                color="#0080FF"
                                                :label="
                                                    item.status
                                                        ? 'Active'
                                                        : 'Un Active '
                                                "
                                                @change="updateState(item)"
                                                class="switchStyle"
                                                hide-details
                                            ></v-switch>
                                        </div>
                                    </template>

                                    <template v-slot:item.action="{ item }">
                                        <v-menu>
                                            <template
                                                v-slot:activator="{ props }"
                                            >
                                                <v-btn
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                    variant="text"
                                                ></v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title
                                                        @click="edit(item)"
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon
                                                            color="tealColor"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        {{ t("edit") }}
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item)
                                                        "
                                                    >
                                                        <v-icon color="error"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        {{ t("delete") }}
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                </v-data-table-server>
                                <v-btn
                                    class="header-button"
                                    v-if="selectedIds.length > 0"
                                    @click="sendSelectedIds"
                                    color="#B71C1C"
                                    flat
                                    text="delete"
                                >
                                </v-btn>
                                <v-dialog
                                    v-model="dialogVisible"
                                    max-width="800px"
                                >
                                    <v-card>
                                        <v-card-actions>
                                            <v-btn
                                                color="primary"
                                                class=""
                                                @click="dialogVisible = false"
                                            >
                                                <v-icon>mdi mdi-close</v-icon>
                                            </v-btn>
                                        </v-card-actions>
                                        <v-card-text>
                                            <v-img
                                                :src="imageSrc"
                                                max-height="550px"
                                                contain
                                            ></v-img>
                                        </v-card-text>
                                    </v-card>
                                </v-dialog>
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateUser from "./CreateUser.vue";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { usePeopleRepository } from "@/store/PeopleRepository";
const PeopleRepository = usePeopleRepository();
const imageSrc = ref();
const dialogVisible = ref(false);
// direction
const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});
const show = (item) => {
    imageSrc.value = item.profilePicture;
    dialogVisible.value = true;
};

// bulk delete
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            usersIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        PeopleRepository.bulkDeleteUser(data);
    } else {
        console.log("No IDs selected.");
    }
};
const updateState = async (item) => {
    const formData = {
        status: item.status,
    };
    await PeopleRepository.CreateForSwitch(formData, item.id);
};

// delete and update Create
const CreateDialogShow = () => {
    PeopleRepository.user = {};
    PeopleRepository.setEditMode(false);
    PeopleRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    PeopleRepository.setEditMode(true);
    PeopleRepository.user = {};
    if (Object.keys(PeopleRepository.user).length === 0) {
        PeopleRepository.FetchUser(item.id)
            .then(() => {
                PeopleRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await PeopleRepository.DeleteUser(item.id);
};
// header
const headers = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("profile"), key: "name", align: "start", sortable: false },
    { title: t("email"), key: "email", align: "start", sortable: false },
    { title: t("phone"), key: "phone", align: "start", sortable: false },
    { title: t("role"), key: "role.name", align: "start", sortable: false },
    { title: t("status"), key: "status", align: "start", sortable: false },
    { title: t("action"), key: "action", align: "center", sortable: false },
];
</script>

<style scoped>
.v-data-table-server {
    position: relative;
}
.header-button {
    position: absolute;
    top: 0.7rem;
    left: 0.7rem;
    z-index: 1;
}
.switchStyle > :nth-child(1) > :nth-child(1) > :nth-child(1) {
    width: 40px; /* Adjusted width for the switch background */
    height: 20px; /* Adjusted height for the switch background */
    border-radius: 30px; /* Ensures the edges are round */

    transition: background-color 0.3s ease;
}

/* Target the switch thumb (dot) */
.switchStyle > :nth-child(1) > :nth-child(1) > :nth-child(1) > :nth-child(1) {
    width: 18px; /* Adjusted width for the thumb */
    height: 18px; /* Adjusted height for the thumb */
    border-radius: 20px; /* Makes it fully circular */

    transition: all 0.3s ease; /* Smooth animation */
}
</style>
