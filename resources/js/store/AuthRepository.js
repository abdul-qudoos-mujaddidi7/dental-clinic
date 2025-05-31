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

            role: null,
            isLoading: false,
            error: null,
            isLoggedIn: false,
            router: useRouter(),
            rail: false,
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
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "/login",
                    data: formData,
                };

                const response = await axios(config);
                this.permissions = response.data.permissions;
                this.role = response.data.roles;
                this.user = response.data.user;
                console.log(this.user);

                sessionStorage.setItem(
                    "token",
                    JSON.stringify(response.data.access_token)
                );
                sessionStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user)
                );
                sessionStorage.setItem(
                    "permissions",
                    JSON.stringify(response.data.permissions)
                );

                // Show success message using vue3-toastify
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
                // Show error message using vue3-toastify
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
    },
});
