<template>
    <div class="all-expense rounded-xl">
        <div class="card rounded-xl">
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
                        :label="t('search')"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="PeopleRepository.peopleAccSearch"
                    ></v-text-field>
                </div>
                <!-- <div class="btn">
                    <v-btn variant="outlined" color="primaryOld" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click="CreateDialogShow"
                        color="primaryOld"
                        variant="flat"
                        :text="t('create')"

                        class="px-6"
                    >
                    </v-btn>
                </div> -->
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                :dir="dir"
                                    :class="
                                        dir === 'rtl'
                                            ? 'rtl-border'
                                            : 'ltr-border'
                                    "
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        PeopleRepository.itemsPerPage
                                    "
                                    v-model:patientIdForView="
                                        PeopleRepository.patientIdForView
                                    "
                                    :headers="headers"
                                    :items-length="PeopleRepository.totalItems"
                                    :items="PeopleRepository.peopleAccounts"
                                    :loading="PeopleRepository.loading"
                                    :search="PeopleRepository.peopleAccSearch"
                                    @update:options="callFunction"
                                    :item-key="PeopleRepository.peopleAccounts"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <template v-slot:item.checkbox="{ item }">
                                        <v-checkbox
                                            :value="item.id"
                                            v-model="selectedIds"
                                            class="w-0 d-flex"
                                        ></v-checkbox>
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
import { usePeopleRepository } from "@/store/PeopleRepository";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useRoute } from "vue-router";
const route = useRoute();

const PeopleRepository = usePeopleRepository();
// PeopleRepository.FetchPeopleAccounts(route.params.id);
const callFunction = () => {
    PeopleRepository.FetchPeopleAccounts(
        { page: 1, itemsPerPage: 10 },
        route.params.id
    );
};

// bulk delete
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        const data = {
            customerIds: selectedIds.value,
        };

        console.log("Sending data:", data);

        PeopleRepository.bulkDeleteCustomer(data);
    } else {
        console.log("No IDs selected.");
    }
};

const dir = computed(() => {
    return locale.value === "fa" ? "rtl" : "ltr"; // Correctly set "rtl" and "ltr"
});
// delete and update Create
const CreateDialogShow = () => {
    PeopleRepository.customer = {};
    PeopleRepository.setEditMode(false);
    PeopleRepository.createDialog = true;
};

const edit = (item) => {
    console.log(item, "me");
    PeopleRepository.setEditMode(true);
    PeopleRepository.customer = {};
    if (Object.keys(PeopleRepository.customer).length === 0) {
        PeopleRepository.FetchCustomer(item.id)
            .then(() => {
                PeopleRepository.createDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await PeopleRepository.DeleteCustomer(item.id);
};
// header
const headers = [
    { title: t("date"), key: "date", align: "start", sortable: false },
    { title: t("amount"), key: "amount", align: "center", sortable: false },
    {
        title: t("paymentType"),
        key: "payment_type",
        align: "end",
        sortable: false,
    },
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
