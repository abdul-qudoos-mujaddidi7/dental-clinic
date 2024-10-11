/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php", // This includes all Blade views in the resources folder
    "./src/**/*.{vue,js,ts,jsx,tsx}", // This covers your Vue components
    "./resources/js/**/*.vue" // Add this for Vue components located in Laravel's resources folder
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
