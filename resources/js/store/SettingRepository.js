import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";

export let useSettingRepository = defineStore("SettingRepository", {
    state() {
        return {
            isEditMode: ref(false),
            router: useRouter(),
            search: ref(""),
            serverItems: ref(""),
            loadingTable: ref(true),
            loading: ref(true),
            totalItems: ref(5),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            createDialog: ref(false),
            // systemSettings
            systemSettings:reactive([]),
            systemSetting:reactive([]),
        };
    },
    actions: {
        setEditMode(EditMode) {
            console.log(EditMode, "editMode");
            this.EditMode = EditMode;
        },
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDay()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
        // systemSettings
        async FetchSystemSettings() {
            this.loading = true;

            const response = await axios.get(`systemSettings`);
            this.systemSettings = response.data.data;
            // this.totalItems = response.data.meta.total;
            
            this.loading = false;
        },
        async fetchSystemSetting(id) {
            console.log(id)
            // this.error = null;
            try {
                const response = await axios.get(`systemSettings/${id}`);

                this.systemSetting = response.data.data;
                console.log(this.systemSetting);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateSystemSetting(data) {
            try {
                const config = {
                    method: "POST",
                    url: "systemSettings/updateSettings/" + 1,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },

                    data: data,
                };
                const response = await axios(config);
                this.FetchSystemSettings({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreateSystemSetting(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "systemSettings",
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchSystemSettings({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteSystemSetting(id) {
            this.isLoading = true;
            this.owners = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "systemSettings/" + id,
                };

                const response = await axios(config);

                // this.patients = response.data.data;
                this.fetchSystemSettings({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
    },
});
