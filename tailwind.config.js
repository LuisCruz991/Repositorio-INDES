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
        'azul-opaco': '#E2E8F0',
        'tabla-color-2': '#F9FAFC',
        
      },
      fontFamily:{
        overpass:['overpass'],
        jakarta:['plus jakarta sans']
      },
      width: {
        '124': '28rem',
        '126': '30rem',
        '128': '32rem',
      },
      height: {
        '124': '28rem',
        '126': '30rem',
        '128': '32rem',
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}





