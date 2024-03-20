/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/*.html.twig",
    "./templates/**/*.html.twig",
    "./assets/react/controllers/*.jsx",
    "./assets/react/controllers/**/*.jsx",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("tailwind-animatecss"),
  ],
}

