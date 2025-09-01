import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { axios } from "../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import i18n from "@/i18n"; // Adjust the path correctly if it's in `src/i18n/index.js`

const { t } = i18n.global;

// Helper functions for session storage
const saveToSession = (key, value) => {
    sessionStorage.setItem(key, JSON.stringify(value));
};

const getFromSession = (key) => {
    const value = sessionStorage.getItem(key);
    return value ? JSON.parse(value) : null;
};

// Helper function for toast notifications
const showToast = (message, type = "success") => {
    const options = {
        position: "top-right",
        autoClose: 3000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
    };
    type === "success" ? toast.success(message, options) : toast.error(message, options);
};

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

        async Login(formData) {
            this.error = null;

            try {
                const response = await axios.post("/login", formData);
                const { access_token: token, user } = response.data;

                saveToSession("token", token);
                saveToSession("user", user);

                axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

                await this.refreshPermissions();

                showToast(t("toast.loginSuccess"));
                this.router.push("/dashboard");
            } catch (err) {
                this.error = err.response?.data?.message || t("toast.cureUpdateFailed");
                showToast(this.error, "error");
            }
        },

        async Logout() {
            this.error = null;

            try {
                await axios.post("logout", { token: getFromSession("token") });

                sessionStorage.clear();

                showToast("Logout successful!");
                setTimeout(() => {
                    this.router.push("/");
                }, 1000);
            } catch (err) {
                this.error = err.response?.data?.message || "An error occurred!";
                showToast("Logout failed! Please try again.", "error");
            }
        },

        initialize() {
            this.permissions = getFromSession("permissions") || [];
            this.user = getFromSession("user") || null;
            this.isLoggedIn = !!getFromSession("token");
        },

        async fetchRolePermissions({ page, itemsPerPage }) {
            this.isLoading = true;

            try {
                const response = await axios.get(
                    `role_permissions?page=${page}&perPage=${itemsPerPage}&search=${this.search}`
                );
                this.permissions = response.data.data;
                this.totalItems = response.data.meta.total;
            } catch (err) {
                this.error = err.response?.data?.message || "Failed to fetch role permissions.";
            } finally {
                this.isLoading = false;
            }
        },

        async refreshPermissions() {
            try {
                const meResponse = await axios.get("/me");
                const { permissions, role } = meResponse.data.data;

                saveToSession("permissions", permissions);
                saveToSession("role", role);

                this.permissions = permissions;
                this.role = role;
                this.user = meResponse.data;

                saveToSession("user", this.user);
            } catch (err) {
                this.error = err.response?.data?.message || "Failed to refresh permissions.";
            }
        },
    },
});
