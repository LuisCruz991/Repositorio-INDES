/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/


// Constante para completar la ruta de la API.
const USER_API = 'business/usuario.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const NAV = document.querySelector('nav');
const SIDE = document.getElementById('sidebar');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
  // Petición para obtener en nombre del usuario que ha iniciado sesión.
  const JSON = await dataFetch(USER_API, 'getUser');
  // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
  if (JSON.session) {
    HEADER.innerHTML = `<div class="container flex flex-wrap items-center justify-between mx-auto">
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
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editar perfil</a>
          </li>
          <li>
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Configuración</a>
          </li>
          <li>
            <a href="#" onclick="logOut()"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cerrar sesión</a>
          </li>
        </ul>
      </div>
      <button class="sm:hidden block " id="btn-sidebar"> <img src="../imagenes/logo-indes-recortado.png"
          class="w-14" alt=""></button>
    </div>
  </div>
  <hr class="h-px mb-1 mt-5 bg-gray-200 border-0 dark:bg-gray-700">

        `;

    SIDE.innerHTML = `<div class="min-h-screen bg-gray-100">
  <nav class="sidebar sm:block hidden min-h-screen w-36  overflow-hidden border-r  bg-azul-1 hover:shadow-lg">
    <div class="flex h-screen flex-col justify-between mt-12 pb-6">
      <div class="flex flex-col items-center">
        <button id="boton"> <img src="../imagenes/logo-indes-recortado.png" class="w-14" alt=""></button>
        <div id="sidebar-content">
          <ul class=" mt-10 space-y-10 tracking-wide">
            <!-- Boton para acceder a dashboard -->
            <li class="min-w-max">
              <a href="../vistas/dashboard.html" aria-label="dashboard"
                class="space-y-1 bg-azul-3 w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class=" w-7 h-7 bi bi-house-door-fill"
                  viewBox="0 0 16 16">
                  <path
                    d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" />
                </svg>
                <span class=" text-sm font-medium">Dashboard</span>
              </a>
            </li>
            <!-- Boton para acceder a atletas -->
            <li class="min-w-max">
              <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                class=" peer space-y-1 bg-azul-3  w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white ">
                <svg class="h-10  w-10" fill="currentcolor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <title>run</title>
                  <path
                    d="M13.5,5.5C14.59,5.5 15.5,4.58 15.5,3.5C15.5,2.38 14.59,1.5 13.5,1.5C12.39,1.5 11.5,2.38 11.5,3.5C11.5,4.58 12.39,5.5 13.5,5.5M9.89,19.38L10.89,15L13,17V23H15V15.5L12.89,13.5L13.5,10.5C14.79,12 16.79,13 19,13V11C17.09,11 15.5,10 14.69,8.58L13.69,7C13.29,6.38 12.69,6 12,6C11.69,6 11.5,6.08 11.19,6.08L6,8.28V13H8V9.58L9.79,8.88L8.19,17L3.29,16L2.89,18L9.89,19.38Z" />
                </svg>
                <span class="text-sm  font-medium">Atletas</span>
              </button>
            </li>
            <!-- Dropdown menu de boton de atletas -->
            <div id="dropdownDots"
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-white-700 text-red" aria-labelledby="dropdownMenuIconButton">
                <!-- Boton para acceder a SCRUD de atletas -->
                <li>
                  <a href="../vistas/atletas_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100  text-red">Atletas</a>
                </li><!-- Boton para acceder a SCRUD de atletas -->
                <li>
                  <a href="../vistas/responsable_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100  text-red">Responsables</a>
                </li>
                <!-- Boton para acceder a SCRUD de presupuesto  -->
                <li>
                  <a href="../vistas/presupuesto_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Presupuesto</a>
                </li>
                <!-- Boton para acceder a SCRUD de entrenadores -->
                <li>
                  <a href="../vistas/entrenadores_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Entrenadores</a>
                </li>
                <li>
                  <a href="../vistas/parentesco_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Parentescos</a>
                </li>
              </ul>
            </div>
            <!-- Boton para acceder a vista de agenda -->
            <li class="min-w-max">
              <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownagend"
                class="space-y-1 bg-azul-3  w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                  class="w-8 h-8 bi bi-journal-bookmark-fill" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8V1z" />
                  <path
                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                  <path
                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                </svg>
                <span class="text-sm  font-medium">Agenda</span>
              </button>
            </li>
            <!-- Dropdown menu de boton agenda -->
            <div id="dropdownagend"
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-white-700 text-red" aria-labelledby="dropdownMenuIconButton">
                <!-- Boton para acceder al calendario -->
                <li>
                  <a href="../vistas/agenda.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Calendario</a>
                </li>
                <!-- Boton para acceder al SCRUD de eventos -->
                <li>
                  <a href="../vistas/eventos_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100  text-red">Eventos</a>
                </li>
                <!-- Boton para acceder al SCRUD de tipo de eventos -->
                <li>
                  <a href="../vistas/tipo_event_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tipo
                    Eventos</a>
                </li>
              </ul>
            </div>
            <!-- Boton para acceder a competencias -->
            <li class="min-w-max">
              <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdowncomp"
                class=" peer space-y-1 bg-azul-3  w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 h-8 bi bi-award-fill"
                  viewBox="0 0 16 16">
                  <path
                    d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z" />
                  <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z" />
                </svg>
                <span class="text-sm  font-medium">Competencia</span>
              </button>
            </li>
            <!-- Dropdown menu de boton competencias -->
            <div id="dropdowncomp"
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-white-700 text-red" aria-labelledby="dropdownMenuIconButton">
                <!-- Boton para acceder al SCRUD de pruebas -->
                <li>
                  <a href="../vistas/prueba_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pruebas</a>
                </li>
                <!-- Boton para acceder al SCRUD de records -->
                <li>
                  <a href="../vistas/records_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100  text-red">Records</a>
                </li>
                <!-- Boton para acceder al SCRUD de pruebas -->
                <li>
                  <a href="../vistas/unidad_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Unidades</a>
                </li>
              </ul>
            </div>
            <!-- Boton para acceder a administradores -->
            <li class="min-w-max">
              <a href="../vistas/admin_crud.html" aria-label="dashboard"
                class="space-y-1 bg-azul-3 w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class=" w-7 h-7 bi bi-house-door-fill"
                  viewBox="0 0 16 16">
                  <path
                    d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z" />
                </svg>
                <span class=" text-sm font-medium">Administrador</span>
              </a>
            </li>
            <!-- Boton para acceder a deportes -->
            <li class="min-w-max">
              <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownball"
                class=" peer space-y-1 bg-azul-3  w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                  class="bi bi-trophy-fill" viewBox="0 0 16 16">
                  <path
                    d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935z" />
                </svg>
                <span class="text-sm  font-medium">Deporte</span>
              </button>
            </li>
            <!-- Dropdown menu de boton deportes -->
            <div id="dropdownball"
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-white-700 text-red" aria-labelledby="dropdownMenuIconButton">
                <!-- Boton para acceder al SCRUD de federaciones -->
                <li>
                  <a href="../vistas/federacion_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Federaciones</a>
                </li>
                <!-- Boton para acceder al SCRUD de deportes -->
                <li>
                  <a href="../vistas/deportes_crud.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Deportes</a>
                </li>
                <!-- Boton para acceder al SCRUD de clasificaciones de un deporte -->
                <li>
                  <a href="../vistas/clasif_deportes.html"
                    class="block px-4 py-2 hover:bg-gray-100  text-red">Clasificacion</a>
                </li>
                <!-- Boton para acceder al SCRUD de modalidades deportivas -->
                <li>
                  <a href="../vistas/modalidad_deporte.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Modalidad</a>
                </li>
              </ul>
            </div>
          <!-- Boton para gestionar los paises y los continentes -->
            <li class="min-w-max">
              <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownP"
                class=" mb-7 peer space-y-1 bg-azul-3  w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white ">
                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 448 512" fill="currentColor">
                <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
                <span class="text-sm  font-medium">Países</span>
              </button>
            </li>
            <!-- Dropdown menu de boton Paises -->
            <div id="dropdownP"
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-white-700 text-red" aria-labelledby="dropdownMenuIconButton">
                <!-- Boton para acceder al SCRUD de Paises -->
                <li>
                  <a href="../vistas/paises.html"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Países</a>
                </li>
                <!-- Boton para acceder al SCRUD de Continentes -->
                <li>
                  <a href="../vistas/continente.html"
                    class="block px-4 py-2 hover:bg-gray-100  text-red">Continentes</a>
                </li>
              </ul>
            </div>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</div>
   `;
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


