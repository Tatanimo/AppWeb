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
                "Roboto": ["'Roboto'", "Arial", "serif"],
            },
            colors: {
                "beige": "rgba(227, 209, 189)",
                "beige-hover": "#ccbcaa",
                "turquoise": "rgba(49, 163, 157)",
                "blue-dark-purple": "#6882C0",
                "blue-purple": "rgba(152, 165, 212)",
                "blue-purple-hover": "#8995bf",
                "light-gray": "rgba(217, 217, 217)",
                "orange": "rgba(245, 156, 35, 1)",
                "dark-blue": "#112137",
            },
            backgroundImage: {
                "hero-img": "url('./../../public/img/background/hero_cat_bg.png')",
                "cat-legs-bg": "url('./../../public/img/background/cat-legs-bg.png')",
                "petsitter-search": "url('./../../public/img/background/girl-wearing-dog.png')",
                "veterinarian-search": "url('./../../public/img/background/veterinarian-with-cat.png')",
                "chat-shape-blue": "url('./../../public/img/shape/chat-shape-blue.svg')",
                "chat-shape-turquoise": "url('./../../public/img/shape/chat-shape-turquoise.svg')",
            }
        },
    },
    plugins: [
        require("tailwind-animatecss"),
        flowbite.plugin(),
    ],
});
