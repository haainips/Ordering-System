/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            backgroundImage: {
                "shimmer-gradient":
                    "linear-gradient(-90deg, #f0f0f0 0%, #e0e0e0 50%, #f0f0f0 100%)",
            },
            animation: {
                shimmer: "shimmer 1.5s infinite",
            },
            keyframes: {
                shimmer: {
                    "0%": { backgroundPosition: "200% 0" },
                    "100%": { backgroundPosition: "-200% 0" },
                },
            },
        },
    },
    plugins: [],
};

