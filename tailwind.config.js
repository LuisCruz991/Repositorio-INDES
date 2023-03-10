/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./vistas/*.html","./node_modules/flowbite/*.js"],
  theme: {
    extend: {
      colors: {
        'primario': '#334257',
        'btn-hover': '#548CA8',
        'azul-3': '#548CA8',
        'azul-2': '#476072'

      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}






