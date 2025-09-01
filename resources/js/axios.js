import axios from "axios";
import router from "./router";

// Set baseURL for all axios requests
axios.defaults.baseURL = "/api/";

// Set default headers
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.post["Content-Type"] = "application/json";

// Enable credentials for cross-origin requests
axios.defaults.withCredentials = true;

// Normalize token string: trim and strip surrounding quotes
const normalizeToken = (token) => {
    if (!token) return null;
    return String(token).trim().replace(/^['"]|['"]$/g, "");
};

// Helpers to set/clear token programmatically
const setAuthToken = (token) => {
    if (token) {
        const normalizedToken = normalizeToken(token);
        localStorage.setItem("token", normalizedToken);
        axios.defaults.headers.common["Authorization"] = `Bearer ${normalizedToken}`;
    } else {
        clearAuthToken();
    }
};

const clearAuthToken = () => {
    localStorage.removeItem("token");
    delete axios.defaults.headers.common["Authorization"];
};

// Request interceptor for auth token
axios.interceptors.request.use(
    (config) => {
        const token = normalizeToken(localStorage.getItem("token"));
        if (token) {
            config.headers = config.headers || {};
            config.headers.Authorization = `Bearer ${token}`;
        } else if (config.headers) {
            delete config.headers.Authorization;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

// Response interceptor for error handling
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response) {
            if (error.response.status === 401) {
                console.warn("Unauthorized - redirecting to login");
                clearAuthToken(); // Clear token on unauthorized
                router.push("/login"); // Redirect to login page
            }
        }
        console.error("API error:", error);
        return Promise.reject(error);
    }
);

// Helper to set content type for POST requests
const setContentType = (contentType) => {
    axios.defaults.headers.post["Content-Type"] = contentType;
};

export { axios, setContentType, setAuthToken, clearAuthToken };