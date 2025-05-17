import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

export default createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "myCustomLightTheme", // initial theme
        themes: {
            myCustomLightTheme: {
                dark: false,
                colors: {
                    primary: "#5499c7",
                    secondary: "#F4D03F",
                    accent: "#8E44AD",
                    success: "#28A745",
                    info: "#17A2B8",
                    warning: "#FFC107",
                    error: "#A91101",
                    primaryOld: "#112F53",
                    tealColor: "#139fa9",
                    tealAccent: "#e7f5f6",
                    tealDark: "#0d6f76",
                    danger: "#B71C1C",
                    background: "#FFFFFF", // important for light bg
                    lightSectionBg: "#F8F8F8", // light section bg

                    tableRowBg: "#ECF1F4",
                    iconWrapperBg: "#ECF1F4",
                },
            },
            myCustomDarkTheme: {
                dark: true,
                colors: {
                    primary: "#5499c7",
                    secondary: "#F4D03F",
                    accent: "#BB86FC",
                    success: "#28A745",
                    info: "#17A2B8",
                    warning: "#FFC107",
                    error: "#CF6679",
                    primaryOld: "#E0E0E0",
                    tealColor: "#00bcd4",
                    tealAccent: "#263238",
                    tealDark: "#0097a7",
                    danger: "#EF5350",
                    background: "#121212", // dark background
                    lightSectionBg: "#1E1E1E", // dark equivalent
                    surface: "#1E1E1E",
                    tableRowBg: "#1e1e1e",
                    iconWrapperBg: "#b0c9d8",
                },
            },
        },
    },
});
