// Constantes para completar las rutas de la API.
const PRUEBA_API = 'business/prueba.php';
const DEPORTE_API = 'business/deporte.php';
const EVENTO_API = 'business/evento.php';
const MODALIDAD_API = 'business/modalidad.php';

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

// Inicialización del componente Modal para que funcionen las cajas de diálogo.

// Constante para establecer la modal de guardar.
const SAVE_MODAL = new Modal(document.getElementById('save-modal'));

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PRUEBA_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se cierra la caja de diálogo.
        SAVE_MODAL.toggle();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);

    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRUEBA_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                  <td>${row.idprueba}</td>
                  <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  ${row.nombre_prueba}
                  </td>
                  <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  ${row.nombre_deporte}
                  </td>
                  <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  ${row.nombre_evento}
                  </td>
                  <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  ${row.nombre_modalidad}
                  </td>
                  <td class="px-6 py-4">
                    <button onclick="openUpdate(${row.idprueba})" 
                      class=" rounded-md w-24 h-8 bg-btnactualizar-color font-medium text-btnactualizar-texto dark:text-blue-500 hover:underline">Actualizar</button>
                  </td>
                  <td class="px-6 py-4">
                    <button onclick="openDelete(${row.idprueba})" 
                      class=" rounded-md w-24 h-8 bg-red-500 font-medium text-white dark:text-blue-500 hover:underline">Eliminar</button>
                  </td>
                </tr>

            `;
        });
        // Se   inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openCreate() {
    // Se abre la caja de diálogo que contiene el formulario.
    
    // Se restauran los elementos del formulario.
    SAVE_FORM.reset();
    // Llamada a la función para llenar el select del formulario. Se encuentra en el archivo components.js
    fillSelect(DEPORTE_API, 'readAll', 'deporte');
    fillSelect(EVENTO_API, 'readAll', 'evento');
    fillSelect(MODALIDAD_API, 'readAll', 'modalidad');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idprueba', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PRUEBA_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.show();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna título a la caja de diálogo.
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idprueba;
        document.getElementById('nombre').value = JSON.dataset.nombre_prueba;
        fillSelect(DEPORTE_API, 'readAll', 'deporte', JSON.dataset.iddeporte);
        fillSelect(EVENTO_API, 'readAll', 'evento', JSON.dataset.idevento);
        fillSelect(MODALIDAD_API, 'readAll', 'modalidad', JSON.dataset.idmodalidad);

        // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la prueba de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idprueba', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRUEBA_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

/*
*   Función para abrir el reporte de entrenadores por federacion.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openReport() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/pruebas_deportes.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}