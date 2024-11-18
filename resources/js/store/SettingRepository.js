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
            // permissions
            permissionSearch:ref(""),
            permissions:reactive([]),
            permission:reactive([]),
            // service groups
            serviceGroupSearch:ref(""),
            serviceGroups:reactive([]), 
            serviceGroup:reactive([]),
            // service
            serviceSearch:ref(""),
            services:reactive([]),
            service:reactive([]),
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
            console.log(this.systemSettings,'system setting');

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
            console.log(data,'data')
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
        // role permissions == role_permissions
        async fetchRolePermissions({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `role_permissions?page=${page}&perPage=${itemsPerPage}&search=${this.permissionSearch}`
            );
            this.permissions = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchRolePermission(id) {
            // this.error = null;
            try {
                const response = await axios.get(`role_permissions/${id}`);

                this.permission = response.data.data;
                console.log(this.permission);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateRolePermission(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "role_permissions/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchRolePermissions({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreateRolePermission(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "role_permissions",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.router.push("/rolePermissions");
                this.fetchRolePermissions({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteRolePermission(id) {
            this.isLoading = true;
            this.setting = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "role_permissions/" + id,
                };

                const response = await axios(config);

                // this.setting = response.data.data;
                this.fetchRolePermissions({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // service Group 
        async FetchServiceGroups({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `serviceGroups?page=${page}&perPage=${itemsPerPage}&search=${this.serviceGroupSearch}`
            );
            this.serviceGroups = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchServiceGroup(id) {
            // this.error = null;
            try {
                const response = await axios.get(`serviceGroups/${id}`);

                this.serviceGroup = response.data.data;
                console.log(this.serviceGroup);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateServiceGroup(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "serviceGroups/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchServiceGroups({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
              
                this.error = err;
            }
        },
        async CreateServiceGroup(formData) {
            console.log(formData);
            try {
            
                const config = {
                    method: "POST",
                    url: "serviceGroups",

                    data: formData,
                };
                const response = await axios(config);
                this.FetchServiceGroups({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteServiceGroup(id) {
            this.isLoading = true;
            this.setting = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "serviceGroups/" + id,
                };

                const response = await axios(config);

                // this.setting = response.data.data;
                this.FetchServiceGroups({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // service 
        async FetchServices({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `services?page=${page}&perPage=${itemsPerPage}&search=${this.serviceSearch}`
            );
            this.services = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchService(id) {
            // this.error = null;
            try {
                const response = await axios.get(`services/${id}`);

                this.service = response.data.data;
                console.log(this.serviceGroup);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateService(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "services/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchServices({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
              
                this.error = err;
            }
        },
        async CreateService(formData) {
            console.log(formData);
            try {
            
                const config = {
                    method: "POST",
                    url: "services",

                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;

                this.FetchServices({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteService(id) {
            this.isLoading = true;
            this.setting = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "services/" + id,
                };

                const response = await axios(config);

                // this.setting = response.data.data;
                this.FetchServices({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },


    },
});
