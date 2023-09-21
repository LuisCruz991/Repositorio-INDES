// Constante para establecer el formulario de registro del primer usuario.
const SIGNUP_FORM = document.getElementById('signup-form');
// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById('login-form');

// Evento cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const JSON = await dataFetch(USER_API, 'readUsers');
    // Comprobar si existe una sesión, de lo contrario continuar con el flujo normal.
    if (JSON.session) {
        // Redirigir a la página web de bienvenida.
        location.href = 'dashboard.html';
    } else if (JSON.status) {
        // Mostrar el formulario para iniciar sesión.
        document.getElementById('login-contenedor').classList.remove('hidden');
        sweetAlert(4, JSON.message, true);
    } else {
        // Mostrar el formulario para registrar el primer usuario.
        document.getElementById('signup-contenedor').classList.remove('hidden');
        sweetAlert(4, JSON.exception, true);
    }
});

// Evento cuando se envía el formulario de registro del primer usuario.
SIGNUP_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar recargar la página web después de enviar el formulario.
    const FORM = new FormData(SIGNUP_FORM); // Obtener los datos del formulario.
    const JSON = await dataFetch(USER_API, 'signup', FORM); // Registrar el primer usuario del sitio privado.
    // Comprobar si la respuesta es satisfactoria, de lo contrario mostrar un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'index.html'); // Mostrar mensaje de éxito y redirigir a la página de inicio.
    } else {
        sweetAlert(2, JSON.exception, false); // Mostrar mensaje de error.
    }
});

// Evento cuando se envía el formulario de inicio de sesión.
LOGIN_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar recargar la página web después de enviar el formulario.
    const FORM = new FormData(LOGIN_FORM); // Obtener los datos del formulario.
    const JSON = await dataFetch(USER_API, 'login', FORM); // Iniciar sesión.
    // Comprobar si la respuesta es satisfactoria, de lo contrario mostrar un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'dashboard.html'); // Mostrar mensaje de éxito y redirigir al panel de control.
    } else {
        sweetAlert(2, JSON.exception, false); // Mostrar mensaje de error.
    }
});

function mostrarContrasenia() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const passwordInput = document.getElementById('clave');
    const passwordButton = document.getElementById('password-visible');
    if (passwordInput.type === 'password') {
        passwordInput.type = "text";
        passwordButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="white" class="bi ml-2 h-10 w-10 bi-eye-slash-fill" viewBox="0 0 16 16">
        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
      </svg>` ;
    }
    else {
        passwordInput.type = 'password';
        passwordButton.innerHTML = ` <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="ml-2 w-10 h-10  bi bi-eye-fill" viewBox="0 0 16 16">
        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
      </svg>` ;

    }

    

    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}


function mostrarContraseniaSignUp() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const passwordInput = document.getElementById('confirmar');
    const passwordButton = document.getElementById('password-visibles');
    if (passwordInput.type === 'password') {
        passwordInput.type = "text";
        passwordButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="white" class="bi ml-2 h-10 w-10 bi-eye-slash-fill" viewBox="0 0 16 16">
        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
      </svg>` ;
    }
    else {
        passwordInput.type = 'password';
        passwordButton.innerHTML = ` <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="ml-2 w-10 h-10  bi bi-eye-fill" viewBox="0 0 16 16">
        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
      </svg>` ;

    }

    

    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}
