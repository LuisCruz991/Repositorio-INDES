// Ruta de la API para los atletas.
const ENTRENADOR_API = 'business/entrenador.php';



// Formulario de búsqueda.
const SEARCH_FORM = document.getElementById('search-form');
// Formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

// Modal de guardar.
const SAVE_MODAL = new Modal(document.getElementById('save-modal'));

// Evento cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llenar la tabla con los registros disponibles.
    fillTable();
});

// Evento cuando se envía el formulario de búsqueda.
SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault(); // Evitar recargar la página web después de enviar el formulario.
    const FORM = new FormData(SEARCH_FORM); // Datos del formulario.
    fillTable(FORM); // Llenar la tabla con los resultados de la búsqueda.
});

// Evento cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar recargar la página web después de enviar el formulario.
    let action = (document.getElementById('id').value) ? 'update' : 'create'; // Verificar la acción a realizar.
    const FORM = new FormData(SAVE_FORM); // Datos del formulario.
    const JSON = await dataFetch(ENTRENADOR_API, action, FORM); // Guardar los datos del formulario.
    if (JSON.status) {
        fillTable(); // Cargar la tabla nuevamente para visualizar los cambios.
        SAVE_MODAL.toggle(); // Cerrar la caja de diálogo.
        sweetAlert(1, JSON.message, true); // Mostrar un mensaje de éxito.
    } else {
        sweetAlert(2, JSON.exception, false); // Mostrar un mensaje de error.
    }
});

// Llenar la tabla con los registros disponibles.
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(ENTRENADOR_API, action, form);
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
                  ${row.nombre}
                  </td>
                  <td class="px-6 py-4">
                  ${row.apellido}
                  </td>
                  <td class="px-6 py-4">
                  ${row.telefono}
                  </td>
                  <td class="px-6 py-4">
                  ${row.nombre_genero}
                  </td>
                  <td class="px-6 py-4">
                  ${row.direccion}
                  </td>
                  <td class="px-6 py-4">
                  ${row.dui}
                  </td>
                  <td class="px-6 py-4">
                  ${row.correo}
                  </td>
                  <td class="px-6 py-4">
                  ${row.nombre_federacion}
                  </td>
                  <td class="px-6 py-4">
                    <button onclick="openUpdate(${row.identrenador})" 
                      class=" rounded-md w-24 h-8 bg-btnactualizar-color font-medium text-btnactualizar-texto dark:text-blue-500 hover:underline">Actualizar</button>
                  </td>
                  <td class="px-6 py-4">
                    <button onclick="openDelete(${row.identrenador})" 
                      class=" rounded-md w-24 h-8 bg-red-500 font-medium text-white dark:text-blue-500 hover:underline">Eliminar</button>
                  </td>
                  <td class="px-6 py-4">
                  <button onclick="openReport(${row.identrenador})" 
                    class=" rounded-md w-24 h-8 bg-blue-500 font-medium text-white dark:text-blue-500 hover:underline">Ficha</button>
                </td>
                <td class="px-6 py-4">
                <button onclick="openReport2(${row.identrenador})" 
                  class=" rounded-md w-24 h-12 bg-purple-500 font-medium text-white dark:text-blue-500 hover:underline">Ver atletas encargados</button>
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
// Preparar el formulario al momento de insertar un registro.
function openCreate() {
    // Abrir la caja de diálogo que contiene el formulario.
    SAVE_FORM.reset(); // Restaurar los elementos del formulario.
    fillSelect(ENTRENADOR_API, 'readGenero', 'genero');
    fillSelect(ENTRENADOR_API, 'readFederacion', 'f');

}

// Preparar el formulario al momento de actualizar un registro.
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('identrenador', id);
    const JSON = await dataFetch(ENTRENADOR_API, 'readOne', FORM); // Obtener los datos del registro seleccionado.
    if (JSON.status) {
        SAVE_MODAL.show(); // Abrir la caja de diálogo que contiene el formulario.
        SAVE_FORM.reset(); // Restaurar los elementos del formulario.
        // Inicializar los campos del formulario.
        document.getElementById('id').value = JSON.dataset.identrenador;
        document.getElementById('nombre').value = JSON.dataset.nombre;
        document.getElementById('apellido').value = JSON.dataset.apellido;
        document.getElementById('telefono').value = JSON.dataset.telefono;
        fillSelect(ENTRENADOR_API, 'readGenero', 'genero', JSON.dataset.idgenero);
        document.getElementById('direccion').value = JSON.dataset.direccion;
        document.getElementById('dui').value = JSON.dataset.dui;
        document.getElementById('correo').value = JSON.dataset.correo;
        fillSelect(ENTRENADOR_API, 'readFederacion', 'f', JSON.dataset.idfederacion);
    } else {
        sweetAlert(2, JSON.exception, false); // Mostrar un mensaje de error.
    }
}

// Eliminar un registro.
async function openDelete(id) {
    const RESPONSE = await confirmAction('¿Desea eliminar este entrenador de forma permanente?');
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('identrenador', id);
        const JSON = await dataFetch(ENTRENADOR_API, 'delete', FORM); // Eliminar el registro seleccionado.
        if (JSON.status) {
            fillTable(); // Cargar la tabla nuevamente para visualizar los cambios.
            sweetAlert(1, JSON.message, true); // Mostrar un mensaje de éxito.
        } else {
            sweetAlert(2, JSON.exception, false); // Mostrar un mensaje de error.
        }
    }
}


/*
*   Función para abrir el reporte de entrenadores por federacion.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openReportN() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/entrenador_fede.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function openReport(id) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/ficha_entrenador.php`);
    //Se declara el id que se enviara cuando se abra el reporte
    PATH.searchParams.append('identrenador', id);

    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

function openReport2(id) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/entrenador_atleta.php`);
    //Se declara el id que se enviara cuando se abra el reporte
    PATH.searchParams.append('identrenador', id);

    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}





