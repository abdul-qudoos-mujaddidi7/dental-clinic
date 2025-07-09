import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { axios } from "../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useAuthRepository = defineStore("AuthRepository", {
    state() {
        return {
            user: null,
            permissions: [],
            permissio: reactive([]),
            permission: reactive([]),
            role: null,
            isLoading: false,
            error: null,
            isLoggedIn: false,
            router: useRouter(),
            rail: false,
            search: ref(""),
            isEditMode: ref(false),
            totalItems: ref(5),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            createDialog: ref(false),
        };
    },
    actions: {
        toggleRail() {
            this.rail = !this.rail;
        },
        // closeRail() {
        //     this.rail = true; // Enable rail mode
        // },
        // openRail() {
        //     this.rail = false; // Disable rail mode
        // },
        async Login(formData) {
    this.error = null;

    try {
        // Step 1: Login and get token
        const response = await axios.post("/login", formData);

        const token = response.data.access_token;
        const user = response.data.user;

        // Step 2: Save token & user to sessionStorage
        sessionStorage.setItem("token", JSON.stringify(token));
        sessionStorage.setItem("user", JSON.stringify(user));

        // Step 3: Set token for future requests
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        // Step 4: Fetch user permissions from /api/me
        const meResponse = await axios.get("/me");

        const permissions = meResponse.data.data.permissions;
        console.log("Permissions:", permissions);
        const role = meResponse.data.data.role;

        sessionStorage.setItem("permissions", JSON.stringify(permissions));
        sessionStorage.setItem("role", JSON.stringify(role));

        this.permissions = permissions;
        this.role = role;
        this.user = meResponse.data;

        
        // ✅ Toast + Redirect
        toast.success("Login successful!", {
            position: "top-right",
            autoClose: 3000,
            hideProgressBar: false,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            progress: undefined,
        });

        this.router.push("/dashboard");
    } catch (err) {
        // ❌ Handle Error
        toast.error("Login failed! Please check your credentials.", {
            position: "top-right",
            autoClose: 3000,
            hideProgressBar: false,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            progress: undefined,
        });

        this.error = err.response
            ? err.response.data.message
            : "An error occurred!";
    }
},


        async Logout() {
            this.error = null;
            const formData = {
                token: JSON.parse(sessionStorage.getItem("token")),
            };
            try {
                const config = {
                    method: "POST",
                    url: "logout",
                    data: formData,
                };

                const response = await axios(config);
                sessionStorage.removeItem("token");
                sessionStorage.removeItem("permissions");
                sessionStorage.removeItem("user");

                // Show success message using vue3-toastify
                toast.success("Logout successful!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });

                setTimeout(() => {
                    this.router.push("/");
                }, 1000);
            } catch (err) {
                // Show error message using vue3-toastify
                toast.error("Logout failed! Please try again.", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });

                this.error = err.response
                    ? err.response.data.message
                    : "An error occurred!";
            }
        },

        initialize() {
            const storedPermissions = JSON.parse(
                sessionStorage.getItem("permissions")
            );
            if (storedPermissions) {
                this.permissions = storedPermissions;
            }
            const storedUser = JSON.parse(sessionStorage.getItem("user"));
            if (storedUser) {
                this.user = storedUser;
            }

            const token = JSON.parse(sessionStorage.getItem("token"));
            if (token) {
                this.isLoggedIn = true;
            }
        },

        // role permissions == role_permissions
        async fetchRolePermissions({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `role_permissions?page=${page}&perPage=${itemsPerPage}&search=${this.search}`
            );
            this.permissio = response.data.data;
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
               const response = await axios.put("role_permissions/" + id, data);


                // Using Axios to make a post request with async/await and custom headers
        //        if (this.role && this.role.id === id) {
            
        // }
                await this.refreshPermissions();
                this.router.push("/rolePermissions");
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
                   toast.success("Permission Created successful!", {
                    position: "top-right",
                    autoClose: 4000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                this.router.push("/rolePermissions");
                this.fetchRolePermissions({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                 this.error =
                    err.response?.data?.message ||
                    "Failed to create Permission. Please try again.";

                // Show toast
                toast.error(this.error, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
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

        async refreshPermissions() {
        const meResponse = await axios.get("/me");
        const permissions = meResponse.data.data.permissions;
        console.log("Permissions:", permissions);
        const role = meResponse.data.data.role;

        sessionStorage.setItem("permissions", JSON.stringify(permissions));
        sessionStorage.setItem("role", JSON.stringify(role));

        this.permissions = permissions;
        this.role = role;
        this.user = meResponse.data;

   

    sessionStorage.setItem("user", JSON.stringify(this.user));
}

    },
});
