/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./vistas/*.html","./node_modules/flowbite/*.js"],
  theme: {
    extend: {
      colors: {
        'primario': '#334257',
        'btn-hover': '#548CA8',
        'azul-1': '#6B728E',
        'azul-2': '#476072',
      },
      fontFamily:{
        overpass:['overpass']
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}





