export const LocaleConfigs = {
    fa: {
        calendar: "jalali", // "jalali" | "gregorian"
        weekdays: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
        months: [
            "حمل",
            "ثور",
            "جوزا",
            "سرطان",
            "اسد",
            "سنبله",
            "میزان",
            "عقرب",
            "قوس",
            "جدی",
            "دلو",
            "حوت",
        ],
        dir: {
            input: "ltr", 
            picker: "ltr", 
        },
        translations: {
            label: "شمسی",
            picker: "تقویم شمسی",
            prevMonth: "ماه قبل",
            nextMonth: "ماه بعد",
            now: "هم اکنون",
            submit: "تایید",
        },
        inputFormat: "jYYYY/jMM/jDD",        // Gregorian format for backend
displayFormat: "jYYYY",           // Jalali year only for user
    },
  
};
export const styles={
    "primary-color": "#a78bfb",
    "secondary-color": "#ddd6fe",
    "in-range-background": "#ddd6fe",
};