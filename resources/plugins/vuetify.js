import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

export default createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "myCustomTheme",
        themes: {
            myCustomTheme: {
                dark: false, // Set to true if you want a dark theme
                colors: {
                    primary: "#5499c7",
                    secondary: "#F4D03F",
                    accent: "#8E44AD",
                    success: "#28A745",
                    info: "#17A2B8",
                    warning: "#FFC107",
                    error: "#A91101",
                    // ========================================
                    primaryOld: "#112F53",
                    tealColor: "#139fa9",
                    tealAccent: "#e7f5f6",
                    tealDark: "#0d6f76",
                    danger: "#B71C1C",
                },
            },
        },
    },
});
