// Constante para completar la ruta de la API.
const ATLETA_API = 'business/dashboard/atleta.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Inicialización del componente Modal para que funcionen las cajas de diálogo.

// Constante para establecer la modal de guardar.
const SAVE_MODAL = document.getElementById('save-modal');

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
    const JSON = await dataFetch(RESPONSABLE_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se cierra la caja de diálogo.
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
    const JSON = await dataFetch(ATLETA_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="w-4 p-4">
                    <div class="flex items-center">
                      <input id="checkbox-table-search-1" type="checkbox"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                  </td>
                  <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  ${row.nombre.atleta}
                  </td>
                  <td class="px-6 py-4">
                  ${row.apellido_atleta}
                  </td>
                  <td class="px-6 py-4">
                  ${row.nacimiento}

                  </td>
                  <td class="px-6 py-4">
                  ${row.nombre_genero}

                  </td>
                  <td class=" px-6 py-4">
                  ${row.estatura}

                  </td>

                  <td class="px-6 py-4">
                  ${row.peso}

                  </td>
                  <td class="px-6 py-4">
                  ${row.talla_camisa}

                  </td>
                  <td class="px-6 py-4">
                  ${row.talla_short}

                  </td>
                  <td class="px-6 py-4">
                  ${row.atletas.direccion}

                  </td>
                  <td class="px-6 py-4">
                  ${row.atletas.dui}

                  </td>
                  <td class="px-6 py-4">
                  ${row.celular}

                  </td>
                  <td class="px-6 py-4">
                  ${row.telefono_casa}

                  </td>
                  <td class="px-6 py-4">
                  ${row.correo}

                  </td>
                  <td class="px-6 py-4">
                  ${row.facebook}

                  </td>
                  <td class="px-6 py-4">
                  ${row.instagram}

                  </td>
                  <td class="px-6 py-4">
                  ${row.twitter}

                  </td>
                  <td class="px-6 py-4">
                  ${row.nombre_madre}

                  </td>
                  <td class="px-6 py-4">
                  ${row.nombre_deporte}

                  </td>
                  <td class="px-6 py-4">
                  ${row.nombre}

                  </td>
                  <td class="px-6 py-4">
                    <button data-modal-target="staticModal" data-modal-toggle="staticModal"
                      class=" rounded-md w-24 h-8 bg-btnactualizar-color font-medium text-btnactualizar-texto dark:text-blue-500 hover:underline">Actualizar</button>
                    <!-- Inicio del modal -->
                  </td>
                  <td class="px-6 py-4">
                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                      class=" rounded-md w-24 h-8 bg-red-500 font-medium text-white dark:text-blue-500 hover:underline">Eliminar</a>
                    </button>
                  </td>
                </tr>

            `;
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.

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
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Ingresar responsable';
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idresponsable', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(RESPONSABLE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna título a la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar responsables';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idresponsable;
        document.getElementById('nombre_madre').value = JSON.dataset.nombre_madre;
        document.getElementById('direccion_madre').value = JSON.dataset.direccion_madre;
        document.getElementById('telefono_madre').value = JSON.dataset.telefono_madre;
        document.getElementById('nombre_padre').value = JSON.dataset.nombre_padre;
        document.getElementById('direccion_padre').value = JSON.dataset.direccion_padre;
        document.getElementById('telefono_padre').value = JSON.dataset.telefono_padre;
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
    const RESPONSE = await confirmAction('¿Desea eliminar los responsables de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idresponsable', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(RESPONSABLE_API, 'delete', FORM);
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