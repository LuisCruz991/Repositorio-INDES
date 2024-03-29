// Constantes para completar las rutas de la API.
const PRESUPUESTO_API = 'business/presupuesto.php';
const CATEGORIA_API = 'business/.php';
const ATLETA_API = 'business/.php';

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
    const JSON = await dataFetch(PRESUPUESTO_API, action, FORM);
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
    const JSON = await dataFetch(PRESUPUESTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {

        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            $ ${row.estimulos}
            </td>
            <td class="px-6 py-4">
            $ ${row.preparacion_fogues}
            </td>
            <td class="px-6 py-4">
            $ ${row.ayuda_extranjera}
            </td>
            <td class="px-6 py-4">
            $ ${row.equipamiento}
            </td>
            <td class="px-6 py-4">
            $ ${row.otros}
            </td>
            <td class="px-6 py-4">
            $ ${row.patrocinadores}
            </td>
            <td class="px-6 py-4">
            ${row.obsevaciones}
            </td>
            <td class="px-6 py-4">
            ${row.anual_mensual}
            </td>
            <td class="px-6 py-4">
            ${row.nombre_atleta}
            </td>
            <td class="px-6 py-4">
              <button onclick="openUpdate(${row.idpresupuesto})" 
                class=" rounded-md w-24 h-8 bg-btnactualizar-color font-medium text-btnactualizar-texto dark:text-blue-500 hover:underline">Actualizar</button>
            </td>
            <td class="px-6 py-4">
              <button onclick="openDelete(${row.idpresupuesto})" 
                class=" rounded-md w-24 h-8 bg-red-500 font-medium text-white dark:text-blue-500 hover:underline">Eliminar</button>
            </td>
          </tr>
            `;
        });
        // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        // Se muestra un mensaje de acuerdo con el resultado.
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
    // Se asigna el título a la caja de diálogo.
    // Llamada a la función para llenar el select del formulario. Se encuentra en el archivo components.js
    fillSelect(PRESUPUESTO_API, 'readCategoria', 'categoria');
    fillSelect(PRESUPUESTO_API, 'readAtleta', 'atleta');


}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idpresupuesto', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PRESUPUESTO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.show();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna el título para la caja de diálogo (modal).
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.idpresupuesto;
        document.getElementById('estimulo').value = JSON.dataset.estimulos;
        document.getElementById('preparacion').value = JSON.dataset.preparacion_fogues;
        document.getElementById('ayuda').value = JSON.dataset.ayuda_extranjera;
        document.getElementById('equipamiento').value = JSON.dataset.equipamiento;
        document.getElementById('otro').value = JSON.dataset.otros;
        document.getElementById('patrocinador').value = JSON.dataset.patrocinadores;
        document.getElementById('observacion').value = JSON.dataset.obsevaciones;
        fillSelect(PRESUPUESTO_API, 'readCategoria', 'categoria', JSON.dataset.idcateg_inversion);
        fillSelect(PRESUPUESTO_API, 'readAtleta', 'atleta', JSON.dataset.idatleta);

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
    const RESPONSE = await confirmAction('¿Desea eliminar el presupuesto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idpresupuesto', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRESUPUESTO_API, 'delete', FORM);
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

