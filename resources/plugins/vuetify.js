import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

export default createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'myCustomTheme',
        themes: {
            myCustomTheme: {
                dark: false, // Set to true if you want a dark theme
                colors: {
                    primaryOld:"#112F53",
                    primary: "#5499c7",     // Your primary color
                    secondary: "#F4D03F",   // Your secondary color
                    accent: "#8E44AD",      // Accent color, optional
                    success: "#28A745",     // Success messages
                    info: "#17A2B8",        // Information alerts
                    warning: "#FFC107",     // Warnings
                    error: "#DC3545" ,
                           // Errors
                    tealColor:"#139fa9",
                    tealAccent:"#e7f5f6",
                    tealDark:"#0d6f76",
                    danger:"#B71C1C",
                },
            },
        },
    },
});
