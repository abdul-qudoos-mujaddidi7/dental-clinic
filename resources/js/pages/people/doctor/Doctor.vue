<template>
    <CreateDoctor v-if="PeopleRepository.createDialog" />
    <div>
        <AppBar mainTitle="Doctor" sub-title="people" />
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
                    label="Search ..."
                    append-inner-icon="mdi-magnify"
                    hide-details
                    v-model="PeopleRepository.doctorSearch"
                ></v-text-field>
            </div>
            <div class="btn">
                <v-btn variant="outlined" color="primaryOld" class="px-6">
                    Filter
                </v-btn>
                &nbsp;
                <v-btn
                    @click="CreateDialogShow"
                    color="primaryOld"
                    variant="flat"
                    text="Create"
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
                                theme="cursor-pointer"
                                v-model:items-per-page="
                                    PeopleRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="PeopleRepository.totalItems"
                                :items="PeopleRepository.doctors"
                                :loading="PeopleRepository.loading"
                                :search="PeopleRepository.doctorSearch"
                                @update:options="PeopleRepository.fetchDoctors"
                                :item-key="PeopleRepository.doctors"
                                hover
                                class="w-100 mx-auto"
                            >
                                <template v-slot:item.checkbox="{ item }">
                                    <v-checkbox
                                        :value="item.id"
                                        v-model="selectedIds"
                                        class="w-6 d-flex"
                                    ></v-checkbox>
                                </template>
                                <template v-slot:item.action="{ item }">
                                    <v-menu>
                                        <template v-slot:activator="{ props }">
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
                                                    <v-icon color="tealColor"
                                                        >mdi-square-edit-outline</v-icon
                                                    >
                                                    Edit
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    class="cursor-pointer d-flex gap-3"
                                                    @click="deleteItem(item)"
                                                >
                                                    <v-icon color="error"
                                                        >mdi-delete-outline</v-icon
                                                    >
                                                    Delete
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
                        </v-col>
                    </v-row>
                </v-main>
            </v-app>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import AppBar from "../../../components/AppBar.vue";
import CreateDoctor from "./CreateDoctor.vue";
import { usePeopleRepository } from "@/store/PeopleRepository";
const PeopleRepository = usePeopleRepository();
// bulk delete
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            doctorsIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        PeopleRepository.bulkDeleteDoctor(data);
    } else {
        console.log("No IDs selected.");
    }
};

// delete and update Create
const CreateDialogShow = () => {
    PeopleRepository.doctor = {};
    PeopleRepository.setEditMode(false);
    PeopleRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    PeopleRepository.setEditMode(true);
    PeopleRepository.doctor = {};
    if (Object.keys(PeopleRepository.doctor).length === 0) {
        PeopleRepository.fetchDoctor(item.id)
            .then(() => {
                PeopleRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await PeopleRepository.DeleteDoctor(item.id);
};
// header
const headers = [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: "Name", key: "name", align: "start", sortable: false },
    { title: "Phone", key: "phone", align: "start", sortable: false },

    { title: "Action", key: "action", align: "center", sortable: false },
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
</style>
