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