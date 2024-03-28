/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/*.html.twig",
    "./templates/**/*.html.twig",
    "./assets/react/controllers/*.jsx",
    "./assets/react/controllers/**/*.jsx",
  ],
  safelist: [
    {
      pattern: /(bg|border|text)-(red|green|blue|gray)-(100|200|300|400|500|600|700)/,
    },
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("tailwind-animatecss"),
  ],
}

