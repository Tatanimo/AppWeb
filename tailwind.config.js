const flowbite = require("flowbite-react/tailwind");
const withMT = require("@material-tailwind/react/utils/withMT");

/** @type {import("tailwindcss").Config} */
module.exports = withMT({
    content: [
        "./assets/**/*.js",
        "./templates/*.html.twig",
        "./templates/**/*.html.twig",
        "./assets/react/controllers/*.jsx",
        "./assets/react/controllers/**/*.jsx",
        flowbite.content(),
    ],
    safelist: [
        {
            pattern: /(bg|border|text)-(red|green|blue|gray)-(100|200|300|400|500|600|700)/,
        },
    ],
    theme: {
        extend: {
            fontFamily: {
                "serif": ["'Playfair Display'", "Arial", "serif"],
                "ChunkFive": ["'Chunk Five'", "Arial", "serif"],
            },
            colors: {
                "beige": "rgba(227, 209, 189)",
                "turquoise": "rgba(49, 163, 157)",
                "blue-purple": "rgba(152, 165, 212)",
                "light-gray": "rgba(217, 217, 217)",
            },
            backgroundImage: {
                "hero-img": "url('./../../public/img/background/hero_cat_bg.png')",
            },
        },
    },
    plugins: [
        require("tailwind-animatecss"),
        flowbite.plugin(),
    ],
});
