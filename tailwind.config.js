/** @type {import('tailwindcss').Config} */
export default {
    prefix: "tw-",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("@tailwindcss/typography")],
};
