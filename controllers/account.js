/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/


// Constante para completar la ruta de la API.
const USER_API = 'business/usuario.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (JSON.session) {
        HEADER.innerHTML = `
    <div class="container flex flex-wrap items-center justify-between mx-auto">
    <h1 class="titulo-navbar self-center text-4xl font-overpass font-normal whitespace-nowrap dark:text-white">
      Dashboard</h1>
    </a>
    <div class="flex items-center md:order-2">
      <button class="mr-4 w-10 h-10 bg-azul-opaco flex justify-center items-center rounded-full"
        aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray"
          class="bi bi-bell w-8 h-8 rounded-full" viewBox="0 0 16 16">
          <path
            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
        </svg>
      </button>
      <div class="flex flex-col mr-2">
        <h5 class="font-jakarta">${JSON.username}</h5>
        <h6 class="font-jakarta text-gray-600">Admin</h6>
      </div>
      <button type="button"
        class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
        data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <img class="w-11 h-11  rounded-full" src="../imagenes/gato-persa.jpg" alt="user photo">
      </button>
      <!-- Dropdown menu -->
      <div
        class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
        id="user-dropdown">
        <div class="px-4 py-3">
          <span class="block text-sm text-gray-900 dark:text-white">${JSON.username}</span>
          <span
            class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">${JSON.username}</span>
        </div>
        <ul class="py-2" aria-labelledby="user-menu-button">
          <li>
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
          </li>
          <li>
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
          </li>
          <li>
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Earnings</a>
          </li>
          <li>
            <a href="/vistas/index.html"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
              out</a>
          </li>
        </ul>
      </div>
      <button class="sm:hidden block " id="btn-sidebar"> <img src="../imagenes/logo-indes-recortado.png"
          class="w-14" alt=""></button>
    </div>
  </div>
        `;
    } else {
     sweetAlert(3, JSON.exception, false, 'index.html');

    }

    /*
    // Se define el componente Parallax.
    const PARALLAX = `
            <div class="parallax-container">
                <div class="parallax">
                    <img id="parallax" src='../../resources/img/parallax/'>
                </div>
            </div>
        `;
    // Se agrega el componente Parallax antes de la etiqueta footer.
    FOOTER.insertAdjacentHTML('beforebegin', PARALLAX);
    // Se establece el pie del encabezado.
    FOOTER.innerHTML = `
        <div class="container">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h5 class="white-text">Nosotros</h5>
                    <p>
                        <blockquote>
                            <a href="#" class="white-text"><b>Misión</b></a>
                            <span>|</span>
                            <a href="#" class="white-text"><b>Visión</b></a>
                            <span>|</span>
                            <a href="#" class="white-text"><b>Valores</b></a>
                        </blockquote>
                        <blockquote>
                            <a href="#" class="white-text"><b>Términos y condiciones</b></a>
                        </blockquote>
                    </p>
                </div>
                <div class="col s12 m6 l6">
                    <h5 class="white-text">Contáctanos</h5>
                    <p>
                        <blockquote>
                            <a href="https://www.facebook.com/" class="white-text" target="_blank"><b>facebook</b></a>
                            <span>|</span>
                            <a href="https://www.instagram.com/" class="white-text" target="_blank"><b>instagram</b></a>
                            <span>|</span>
                            <a href="https://www.youtube.com/" class="white-text" target="_blank"><b>youtube</b></a>
                        </blockquote>
                        <blockquote>
                            <a href="mailto:dacasoft@outlook.com" class="white-text"><b>Correo electrónico</b></a>
                            <span>|</span>
                            <a href="https://api.whatsapp.com/" class="white-text" target="_blank"><b>WhatsApp</b></a>
                        </blockquote>
                    </p>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <span>© 2018-2023 Copyright CoffeeShop. Todos los derechos reservados.</span>
                <span class="right">Diseñado con
                    <a href="http://materializecss.com/" target="_blank">
                        <img src="../../resources/img/materialize.png" height="20" style="vertical-align:middle" alt="Materialize">
                    </a>
                </span>
            </div>
        </div>
    `;
    // Se inicializa el componente Sidenav para que funcione la navegación lateral.
    M.Sidenav.init(document.querySelectorAll('.sidenav'));
    // Se declara e inicializa un arreglo con los nombres de las imagenes que se pueden utilizar en el efecto parallax.
    const IMAGES = ['img01.jpg', 'img02.jpg', 'img03.jpg', 'img04.jpg', 'img05.jpg'];
    // Se declara e inicializa una constante para obtener un elemento del arreglo de forma aleatoria.
    const ELEMENT = Math.floor(Math.random() * IMAGES.length);
    // Se asigna la imagen a la etiqueta img por medio del atributo src.
    document.getElementById('parallax').src += IMAGES[ELEMENT];
    // Se inicializa el efecto Parallax.
    M.Parallax.init(document.querySelectorAll('.parallax'));
    */
});


