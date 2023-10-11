/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/


// Constante para completar la ruta de la API. 
const USER_API = 'business/usuario.php';
const ADMIN_API = 'business/admin.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const NAV = document.querySelector('nav');
const SIDE = document.getElementById('sidebar');
const PASSWORD_MODAL = new Modal(document.getElementById('password-modal'));
const PASSWORD_FORM = document.getElementById('password-form');
const PROFILE_MODAL = new Modal(document.getElementById('profile-modal'));
const PROFILE_FORM = document.getElementById('profile-form');

const FILENAME = location.pathname.substring(location.pathname.lastIndexOf('/') + 1);
const BANNER = FILENAME.replace('html', 'png');
// se obtine el titulo del sitio web 
const TITULO = document.title;

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
  // Petición para obtener en nombre del usuario que ha iniciado sesión.
  const JSON = await dataFetch(USER_API, 'getUser');
  // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
  if (JSON.session) {
    setInterval(() => {
      //Se coloca la cantidad de tiempo maxima de inactividad en milisegundos
      TiempoInactividad();
    }, 1800000);
    if (JSON.status) {
      HEADER.innerHTML = `<div class="h-24 container flex flex-wrap items-center justify-between mx-auto" style="background: url(../imagenes/banner/${BANNER});  border-radius: 15px; background-color: rgb(80 87 122);">
    <!-- Titulo de la pagina  -->
    <h1 class="px-5 font-medium text-white md:text-4xl text-xl">${TITULO}</h1>
    <!-- Opciones del usuario -->
    <div class="relative flex items-end md:order-2 mr-5">
    <div class flex flex-col> 
    <button type="button"
    class="flex mr-4 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
    id="user-menu-button" aria-expanded="false" data-collapse-toggle="user-dropdown" onclick="toggleDropdown('user-dropdown')"
    data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <!-- Imagen de usuario  -->
        <img class="w-11 h-11  rounded-full" src="../imagenes/img_users/user.jpg" alt="user photo">
      </button>
      <!-- Dropdown menu -->
      <div class="z-50 hidden w-fit-content  mt-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute "
      id="user-dropdown">
        <div class="px-4 py-3">
          <!-- Nombre de usuario  -->
          <span class="block text-sm text-gray-900 dark:text-white">${JSON.username}</span>
          <!-- Nivel de usuario  -->
          <span
            class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">Admin</span>
        </div>
        <ul class="py-2" aria-labelledby="user-menu-button">
          <!-- Acciones del usuario -->
          <li>
             <button onclick="openPassword()" 
             class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Clave</a>
             </li>
          <li>
          <button onclick="openProfile()" 
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Configuración</a>
          </li>
          <li>
            <a href="#" onclick="logOut()"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
      <div class="flex flex-col ml-2 mr-2">
        <!-- Nombre de usuario  -->
        <h5 class="font-jakarta text-white">${JSON.username}</h5>
        <!-- Nivel de usuario  -->
        <h6 class="font-jakarta text-gray-300">Admin</h6>
      </div>
      <button onclick="toggleSidebar()" class="sm:hidden block " id="btn-sidebar"> <img src="../imagenes/logo-indes-recortado.png"
          class="w-14" alt=""></button>
    </div>
  </div>

        `;

      SIDE.innerHTML = `<div class="min-h-screen bg-gray-100">
  <nav id="side"  class="sidebar sm:block hidden min-h-screen w-36  overflow-hidden border-r  bg-azul-1 hover:shadow-lg">
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
               <button aria-controls="dropdownatleta" data-collapse-toggle="dropdownatleta"   onclick="toggleDropdown('dropdownatleta')"
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
            <div id="dropdownatleta"
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-fit-content dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-white-700 text-red" aria-labelledby="dropdownatleta">
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
              <button id="dropdownMenuIconButton" data-collapse-toggle="dropdownagend"   onclick="toggleDropdown('dropdownagend')"
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
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-fit-content dark:bg-gray-700 dark:divide-gray-600">
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
              <button id="dropdownMenuIconButton" data-collapse-toggle="dropdowncomp"  onclick="toggleDropdown('dropdowncomp')"
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
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-fit-content dark:bg-gray-700 dark:divide-gray-600">
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
            <!-- Boton para gestionar los paises y los continentes -->
            <li class="min-w-max">
              <button id="dropdownMenuIconButton" data-collapse-toggle="dropdownP" onclick="toggleDropdown('dropdownP')"
                class=" mb-7 peer space-y-1 bg-azul-3  w-[6.5rem] h-[4.8rem] group flex flex-col items-center justify-center rounded-lg  py-1 text-white ">
                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 448 512" fill="currentColor">
                <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
                <span class="text-sm  font-medium">Países</span>
              </button>
            </li>
            <!-- Dropdown menu de boton Paises -->
            <div id="dropdownP"
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-fit-content dark:bg-gray-700 dark:divide-gray-600">
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
            <!-- Boton para acceder a deportes -->
            <li class="min-w-max">
              <button id="dropdownMenuIconButton" data-collapse-toggle="dropdownball"  onclick="toggleDropdown('dropdownball')"
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
              class="z-10 hidden bg-azul-opaco divide-y divide-gray-100 rounded-lg shadow w-fit-content dark:bg-gray-700 dark:divide-gray-600">
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
          </ul>
        </div>
      </div>
    </div>
  </nav>
</div>
   `;
    }else {
      sweetAlert(3, JSON.exception, false, 'index.html');
  }
  }else {
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

async function TiempoInactividad() {
  const JSON = await dataFetch(USER_API, 'TiempoInactividad');
  if (JSON.status) {
    sweetAlert(1, JSON.message, true);
  } else {
    clearInterval();
    // Redireccionamiento a la pagina de inicio del sistema
    sweetAlert(2, JSON.exception, false, '../vistas/index.html');
  }
}

function toggleDropdown(dropdownId) {
  const dropdown = document.getElementById(dropdownId);
  dropdown.classList.toggle('hidden');
}

PASSWORD_FORM.addEventListener('submit', async (event) => {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Constante tipo objeto con los datos del formulario.
  const FORM = new FormData(PASSWORD_FORM);
  // Petición para actualizar la constraseña.
  const JSON = await dataFetch(USER_API, 'cambiarClave', FORM);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
      // Se cierra la caja de diálogo.
      SAVE_MODAL.toggle();

      // Se muestra un mensaje de éxito.
      sweetAlert(1, JSON.message, true);
  } else {
      sweetAlert(2, JSON.exception, false);
  }
});

PROFILE_FORM.addEventListener('submit', async (event) => {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Constante tipo objeto con los datos del formulario.
  const FORM = new FormData(PROFILE_FORM);
  // Petición para actualizar la constraseña.
  const JSON = await dataFetch(ADMIN_API, 'editProfile', FORM);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
      // Se cierra la caja de diálogo.
      // Se muestra un mensaje de éxito.
      sweetAlert(1, JSON.message, true);
  } else {
      sweetAlert(2, JSON.exception, false);
  }
});

async function openPassword() {
  // Se abre la caja de diálogo que contiene el formulario.

  const FORM = new FormData();
  // Petición para obtener los datos del registro solicitado.
  const JSON = await dataFetch(USER_API, 'readProfile', FORM);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
    // // Se abre la caja de diálogo que contiene el formulario.
    PASSWORD_MODAL.show();
    // Se restauran los elementos del formulario.
    PASSWORD_FORM.reset();
    // Se inicializan los campos del formulario.
    document.getElementById('usuario').value = JSON.dataset.nombre_usuario;
    document.getElementById('correo').value = JSON.dataset.correo_usuario;
  } else {
    sweetAlert(2, JSON.exception, false);
  }
  // Se restauran los elementos del formulario.
}

function toggleSidebar() {
  const sidebar = document.getElementById('side');
  sidebar.classList.toggle('hidden');
}

async function openProfile() {
  // Se abre la caja de diálogo que contiene el formulario.

  const FORM = new FormData();
  // Petición para obtener los datos del registro solicitado.
  const JSON = await dataFetch(USER_API, 'readProfile', FORM);
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
  if (JSON.status) {
    // // Se abre la caja de diálogo que contiene el formulario.
    PROFILE_MODAL.show();
    // Se restauran los elementos del formulario.
    PROFILE_FORM.reset();
    // Se inicializan los campos del formulario.
    document.getElementById('id').value = JSON.dataset.idadministrador;
    document.getElementById('nombre').value = JSON.dataset.nombre_usuario;
    document.getElementById('email').value = JSON.dataset.correo_usuario;
  } else {
    sweetAlert(2, JSON.exception, false);
  }
  // Se restauran los elementos del formulario.
}


