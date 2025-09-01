import axios from "axios";
import router from "./router";

// Set baseURL for all axios requests
axios.defaults.baseURL = "/api/";

// Set default headers
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.post["Content-Type"] = "application/json";

// Request interceptor for auth token
axios.interceptors.request.use(
  (config) => {
    const token = sessionStorage.getItem("token");
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    } else {
      delete config.headers["Authorization"];
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
        console.warn("Unauthorized - maybe redirect to login");
        router.push("/login");
        // You can trigger a logout or redirect here
      }
    }
    console.error("API error:", error);
    return Promise.reject(error);
  }
);

// Export axios for explicit import if needed
export { axios };      // named export
export default axios;  // default export
