// Ruta de la API para los atletas.
const ATLETA_API = 'business/atleta.php';
// Ruta de la API para los responsables.
const RESPONSABLE_API = 'business/responsable.php';
// Ruta de la API para los deportes.
const DEPORTE_API = 'business/deporte.php';

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
// Constante del modal para acceder al grafco parametrizado
const GRAPH_MODAL = new Modal(document.getElementById('graph-modal'));

// Constante del modal para acceder al grafco parametrizado
const GRAPH2_MODAL = new Modal(document.getElementById('graph2-modal'));

// Constante del modal para acceder al grafco parametrizado
const GRAPH3_MODAL = new Modal(document.getElementById('graph3-modal'));

// Constante del modal para acceder al grafco parametrizado
const GRAPH4_MODAL = new Modal(document.getElementById('graph4-modal'));



// Modal de guardar.
const SAVE_MODAL = new Modal(document.getElementById('save-modal'));

// Evento cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llenar la tabla con los registros disponibles.
    fillTable();

    // se carga el banner del CRUD 
    // document.getElementById('banner').innerHTML = '<img src="../imagenes/gato-persa.jpg">';
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
    let action = (document.getElementById('ida').value) ? 'update' : 'create'; // Verificar la acción a realizar.
    const FORM = new FormData(SAVE_FORM); // Datos del formulario.
    const JSON = await dataFetch(ATLETA_API, action, FORM); // Guardar los datos del formulario.
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
    const JSON = await dataFetch(ATLETA_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${row.nombre_atleta}
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
                ${row.direccion}

            </td>
            <td class="px-6 py-4">
                ${row.dui}

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
                ${row.nombre_responsable}

            </td>
            <td class="px-6 py-4">
                ${row.nombre_federacion}

            </td>
            <td class="px-6 py-4">
                ${row.nombre}

            </td>
            <td class="px-6 py-4">
            <img src="${SERVER_URL}imagenes/atletas/${row.dui_foto}" class="materialboxed"  width="200px" onerror="this.src='../imagenes/notFound.png';">
            </td>
            <td class="px-6 py-4">
            <img src="${SERVER_URL}imagenes/atletas/${row.pasaporte_foto}" class="materialboxed"  width="200px" onerror="this.src='../imagenes/notFound.png';">
            </td>
            <td>
                <button data-modal-toggle="save-modal"
                    class="rounded-md w-24 h-8 bg-btnactualizar-color font-medium text-btnactualizar-texto dark:text-blue-500 hover:underline"
                    onclick="openUpdate(${row.idatleta})">
                    Actualizar
                </button>
            <td class="px-6 py-4">
                <button class=" rounded-md w-24 h-8 bg-red-500 font-medium text-white dark:text-blue-500 hover:underline"
                    onclick="openDelete(${row.idatleta})">
                    Eliminar</a>
                </button>
            </td>
            <td class="px-6 py-4">
                <button title="Ver datos del o la atleta" onclick="openReport2(${row.idatleta})"
                    class="items-center p-2.5 ml-2 w-15 text-xl font-medium text-white bg-blue-500 rounded-lg border border-green-400 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-400 dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" fill="currentColor">
                        <path
                            d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z" />
                    </svg>
                </button>
            </td>
            <td class="px-6 py-4">
                <button title="Visualizar asistencia" onclick="openHoras(${row.idatleta})"
                    class="items-center p-2.5 ml-2 w-15 text-xl font-medium text-white bg-blue-500 rounded-lg border border-green-400 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-400 dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" fill="currentColor">
                        <path
                            d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z" />
                    </svg>
                </button>
            </td>
            <td class="px-6 py-4">
                <button title="Ver gráficos del o la atleta" onclick="graficoPastelHoras(${row.idatleta})"
                    class="p-2.5 ml-2 w-15 text-xl font-medium text-white bg-green-400 rounded-lg border border-azul-3 hover:bg-azul-3 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-400 dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="currentColor">
                        <path
                            d="M32 32c17.7 0 32 14.3 32 32V400c0 8.8 7.2 16 16 16H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H80c-44.2 0-80-35.8-80-80V64C0 46.3 14.3 32 32 32zM160 224c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32s-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm128-64V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V160c0-17.7 14.3-32 32-32s32 14.3 32 32zm64 32c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V224c0-17.7 14.3-32 32-32zM480 96V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V96c0-17.7 14.3-32 32-32s32 14.3 32 32z" />
                    </svg>
                </button>
            </td>
        </tr>
        `;
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
};
// Preparar el formulario al momento de insertar un registro.
function openCreate() {
    // Abrir la caja de diálogo que contiene el formulario.
    SAVE_FORM.reset(); // Restaurar los elementos del formulario.
    fillSelect(ATLETA_API, 'readGenero', 'genero');
    fillSelect(RESPONSABLE_API, 'readAll', 'responsable');
    fillSelect(ENTRENADOR_API, 'readFederacion', 'federacion');
    fillSelect(ATLETA_API, 'readEntrenador', 'entrenador');
    document.getElementById('title2').innerHTML = '<h1 class="text-center mt-5">Agregar atleta</h1>';
};

// Preparar el formulario al momento de actualizar un registro.
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('idatleta', id);
    const JSON = await dataFetch(ATLETA_API, 'readOne', FORM); // Obtener los datos del registro seleccionado.
    if (JSON.status) {
        SAVE_MODAL.show(); // Abrir la caja de diálogo que contiene el formulario.
        document.getElementById('title2').innerHTML = `<h1 class="text-center py-8">Actualizar datos de:${JSON.dataset.nombre_completo}</h1 > ` ;
        // Inicializar los campos del formulario.
        document.getElementById('ida').value = JSON.dataset.idatleta;
        document.getElementById('nombre').value = JSON.dataset.nombre_atleta;
        document.getElementById('apellido').value = JSON.dataset.apellido_atleta;
        document.getElementById('nacimiento').value = JSON.dataset.nacimiento;
        fillSelect(ATLETA_API, 'readGenero', 'genero', JSON.dataset.idgenero);
        document.getElementById('estatura').value = JSON.dataset.estatura;
        document.getElementById('peso').value = JSON.dataset.peso;
        document.getElementById('camisa').value = JSON.dataset.talla_camisa;
        document.getElementById('short').value = JSON.dataset.talla_short;
        document.getElementById('direccion').value = JSON.dataset.direccion;
        document.getElementById('dui').value = JSON.dataset.dui;
        document.getElementById('celular').value = JSON.dataset.celular;
        document.getElementById('telefono').value = JSON.dataset.telefono_casa;
        document.getElementById('correo').value = JSON.dataset.correo;
        fillSelect(RESPONSABLE_API, 'readAll', 'responsable', JSON.dataset.idresponsable);
        fillSelect(ENTRENADOR_API, 'readFederacion', 'federacion', JSON.dataset.idfederacion);
        fillSelect(ATLETA_API, 'readEntrenador', 'entrenador', JSON.dataset.identrenador);
        document.getElementById('archivo').required = false;
        document.getElementById('archivo2').required = false;

        document.getElementById('clave').disabled = true;
    } else {
        sweetAlert(2, JSON.exception, false); // Mostrar un mensaje de error.
    }
};

// Eliminar un registro.
async function openDelete(id) {
    const RESPONSE = await confirmAction('¿Desea descartar este atleta?');
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('idatleta', id);
        const JSON = await dataFetch(ATLETA_API, 'delete', FORM); // Eliminar el registro seleccionado.
        if (JSON.status) {
            fillTable(); // Cargar la tabla nuevamente para visualizar los cambios.
            sweetAlert(1, JSON.message, true); // Mostrar un mensaje de éxito.
        } else {
            sweetAlert(2, JSON.exception, false); // Mostrar un mensaje de error.
        }
    }
};


/*
* Función para abrir el reporte de productos por categoría.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
function openReport() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/lista_atletas.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
};

// Funcion asincrona para generar un grafico de las horas entrenadas de una atleta
async function graficoPastelHoras(id) {
    const FORM = new FormData();
    FORM.append('idatleta', id);
    // delarando el contenedor del grafico 8
    document.getElementById('graph-container8').innerHTML = '<canvas id="chart8"></canvas>'
    // declarando el contenedor del grafico 4
    document.getElementById('graph-container4').innerHTML = '<canvas id="chart4"></canvas>'
    // declarando el contenedor del grafico 3
    document.getElementById('graph-container3').innerHTML = '<canvas id="chart3" class="rotar"></canvas>'
    // declarando el contenedor del grafico 9
    document.getElementById('graph-container9').innerHTML = '<canvas id="chart9" class="mb-5"></canvas>'
    GRAPH_MODAL.show(); // Abre la caja de diálogo que contiene el formulario.
    const JSON = await dataFetch(ATLETA_API, 'horaAtleta2', FORM); // Obtener los datos de la consulta
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let horas = [];
        let fecha = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            horas.push(row.horas);
            fecha.push(row.fecha_entreno);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        polarGraph('chart8', fecha, horas, 'Horas entrenadas en la semana');
    } else {
        console.log(JSON.exception);
    }
    // Codigo para cargar el grafico de los resultados del atleta
    const JSON2 = await dataFetch(ATLETA_API, 'resultadoAtleta', FORM)
    if (JSON2.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let posicion = [];
        let nombreR = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON2.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            posicion.push(row.posicion);
            nombreR.push(row.nombre_prueba);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        radarGraph('chart3', nombreR, posicion, 'posición', 'Resultados obtenidos');
    }
    else {
        console.log(JSON2.exception);
    }
    // Codigo para cargar el grafico de el presupuesto del atleta
    const JSON3 = await dataFetch(ATLETA_API, 'presupuestoAtleta', FORM)
    if (JSON3.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        const DATA = JSON3.dataset;
        let inversiones = ['Estimulos', 'Fogueo', 'Ayuda', 'Equipamiento', 'Patrocinadore', 'Otro'];
        let montos = [DATA.estimulos, DATA.preparacion_fogues, DATA.ayuda_extranjera, DATA.equipamiento,
        DATA.patrocinadores, DATA.otros];
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        barGraphX('chart9', inversiones, montos, '($)Monto', 'Presupuesto');
        // Titulo del modal
        document.getElementById('title').innerHTML = `<h1 class="text-center mt-5">Gráficos del o la atleta: ${DATA.atleta}</h1 > `;
    }
    else {
        console.log(JSON3.exception);
    }
    // codigo para cargar el grafico de las marcas del atletas
    const JSON4 = await dataFetch(ATLETA_API, 'marcaAtleta', FORM)
    if (JSON4.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let nombreM = [];
        let marca = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON4.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            marca.push(row.marca_obtenida);
            nombreM.push(row.nombre_prueba);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        lineGraph('chart4', nombreM, marca, 'Marca', 'Rendimiento del atleta en base a sus marcas obtenidas');
    }
    else {
        console.log(JSON4.exception);
    }

};

function openReport2(id) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/ficha_atleta.php`);
    //Se declara el id que se enviara cuando se abra el reporte
    PATH.searchParams.append('idatleta', id);

    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
};


// Funcion para abrir el reporte de las horas cumplidas de entrenamiento de un atleta
function openHoras(id) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/horas_cumplidas.php`);
    //Se declara el id que se enviara cuando se abra el reporte
    PATH.searchParams.append('idatleta', id);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
};

// Funcion asincrona para mostrar la imagen seleccionada en el modal. 
async function Preview(input, target) {
    let file = input.files[0];
    let reader = new FileReader();
  
    reader.readAsDataURL(file);
    reader.onload = function () {
      let img = document.getElementById(target);
      img.src = reader.result;
    }
};
