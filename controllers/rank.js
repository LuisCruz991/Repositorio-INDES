// Constante para acceder a la api de deportes 
const API_DEPORTE = 'business/deporte.php';
// Constante para acceder a la api del ranking
const API_RANKING = 'business/rank.php';

// Constante donde se cargan los deportes
const DEPORTE = document.getElementById('deporte');

// Constante donde se cargan las modalidades
const MODALIDAD = document.getElementById('modalidad');


//Evento para cuando se carga la pagina
document.addEventListener('DOMContentLoaded', async () => {
    document.getElementById('buscar').disabled = true;
    //Nos aseguramos de que los campos esten vacios
    document.getElementById('filtro-modalidad').value = '';
    //Nos aseguramos de que los campos esten vacios
    document.getElementById('filtro-deporte').value = '';
    // se hace la solicitu de leer los deportes
    const JSON = await dataFetch(API_DEPORTE, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de los deportes.
        DEPORTE.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan los botones de cada deporte.
            DEPORTE.innerHTML += `
            <button id="sport"
                class="mt-8 ml-2 mb-8 w-64 h-64 bg-azul-1 rounded-lg hover:bg-gray-500 shadow-xl flex-wrap justify-center items-center"
                onclick="getFiltro1('${row.nombre_deporte}')">
                <h1 class="text-3xl text-white mb-8">${row.nombre_deporte}</h1>
                <img src="../imagenes/elements/deportes/${row.nombre_deporte}.png" onerror="this.src='../imagenes/notFound.png'"
                    class="mx-auto mt-8 w-32 h-32">
            </button>
            `;
        });
    } else {
        // se muestra un mensaje de error en dado caso
        sweetAlert(2, JSON.exception, false);
    }
});

// Funcion asincrona para cargar el primer filtro de la busqueda
async function getFiltro1(filtro) {
    let filtro1 = document.getElementById('f-deporte');
    filtro1.classList.remove('hidden');
    filtro1.innerHTML = `<h1 class="text-white py-1.5 px-3">${filtro}</h1>`;
    document.getElementById('filtro-deporte').value = `${filtro}`;

    FORM = new FormData();
    FORM.append('filtro', filtro);

    const JSON = await dataFetch(API_RANKING, 'readModalidad', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        MODALIDAD.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            MODALIDAD.innerHTML += `
            <button id="mod"
                class="mt-8 ml-2 mb-8 w-64 h-64 bg-azul-1 rounded-lg hover:bg-gray-500 shadow-xl flex-wrap justify-center items-center"
                onclick="getFiltro2('${row.nombre_modalidad}')">
                <h1 class="text-3xl text-white mb-8">${row.nombre_modalidad}</h1>
                <img src="../imagenes/elements/modalidades/${row.nombre_modalidad}.png"
                    onerror="this.src='../imagenes/notFound.png'" class="mx-auto mt-8 w-32 h-32">
            </button>
            `;
        });
    } else {
        sweetAlert(2, JSON.exception, false);
        MODALIDAD.innerHTML = '';
        document.getElementById('f-modalidad').innerHTML = '';
        document.getElementById('filtro-modalidad').value = '';
    }
};

// funcion asincrona para cargar el segundo filtro
 function getFiltro2(filtro) {
    document.getElementById('buscar').disabled = false;
    let filtro2 = document.getElementById('f-modalidad');
    filtro2.classList.remove('hidden');
    filtro2.innerHTML = `<h1 class="text-white py-1.5 px-3">${filtro}</h1>`;
    document.getElementById('filtro-modalidad').value = `${filtro}`;
};


// funcion asincrona para hacer la busqueda
async function buscar() {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // la constante del primer lugar
    const N1 = document.getElementById('n1');
    // Constante del segundo lugar
    const N2 = document.getElementById('n2');
    // Constante del tercer lugar
    const N3 = document.getElementById('n3');
    // Constante del resto de atletas
    const REST = document.getElementById('rest');

    // se valida que la modalidad deportiva no sea nula 
    if (document.getElementById('filtro-modalidad').value == '') {
        sweetAlert(4, 'Por favor seleccione una modalidad deportiva');
    }
    else {
        // Constante tipo objeto con los datos del formulario.
        const FORM = new FormData();
        // se le concatena el valor del deporte al formulario
        FORM.append('deporte', document.getElementById('filtro-deporte').value);
        // se le concatena el valor de la modalidad al formulario
        FORM.append('modalidad', document.getElementById('filtro-modalidad').value);
        // se hace la solicitud al servidor
        const JSON = await dataFetch(API_RANKING, 'readN1', FORM);
        if (JSON.status) {
            // Se inicializa el contenedor de productos.
            N1.innerHTML = '';
            // Se recorre el conjunto de registros fila por fila a través del objeto row.
            JSON.dataset.forEach(row => {
                // Se crean y concatenan las tarjetas con los datos de cada producto.
                N1.innerHTML += `
                <div class="h-20 rounded-xl shadow-xl w-full border-2 border-yellow-300 mb-4 inline-flex items-center justify-between">
                    <div class="inline-flex items-center">
                    <img src="../imagenes/elements/number1.png" alt="" srcset="" class="w-16 mt-3 ml-3">
                    <h1 class="ml-3 mr-2 text-2xl" style="color: rgb(227, 198, 9);">#1</h1>
                    </div>
                    <h1 class="px-6 text-xl ml-8 mr-8">${row.nombre}</h1>
                    <div class="inline-flex mr-8">
                    <h1 class="px-6">El salvador</h1>
                    <img src="../api/imagenes/banderas/64e2d2d082470.png" class="w-20 h-10"
                        onerror="this.src='../imagenes/notFound.png'">
                </div>
                </div>
                `;
            });
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    };

    // se establece un nuevo formulario
    const FORM2 = new FormData();
    // se le concatena el valor del deporte al formulario
    FORM2.append('deporte', document.getElementById('filtro-deporte').value);
    // se le concatena el valor de la modalidad al formulario
    FORM2.append('modalidad', document.getElementById('filtro-modalidad').value);
    // se hace la solicitud al servidor
    const JSON2 = await dataFetch(API_RANKING, 'readN2', FORM2);
    if (JSON2.status) {
        // Se inicializa el contenedor de productos.
        N2.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON2.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            N2.innerHTML += `
                <div class="h-20 rounded-xl shadow-xl w-full border-2 mb-4 inline-flex items-center justify-between"
                style="border-color: #C0C0C0;">
                <div class="inline-flex items-center">
                <img src="../imagenes/elements/2nd.png" alt="" srcset="" class="w-20 mb-2.5">
                <h1 class="ml-2 mr-2 text-2xl" style="color: #C0C0C0;;">#2</h1>
                </div>
                <h1 class="px-6 text-xl ml-8 mr-8">${row.nombre}</h1>
                <div class="inline-flex mr-8">
                <h1 class="px-6">El salvador</h1>
                <img src="../api/imagenes/banderas/64e2d2d082470.png" class="w-20 h-10"
                    onerror="this.src='../imagenes/notFound.png'">
                </div>
            </div>
                `;
        });
    } else {
        sweetAlert(2, JSON2.exception, false);

    }

    // se establece un nuevo formulario
    const FORM3 = new FormData();
    // se le concatena el valor del deporte al formulario
    FORM3.append('deporte', document.getElementById('filtro-deporte').value);
    // se le concatena el valor de la modalidad al formulario
    FORM3.append('modalidad', document.getElementById('filtro-modalidad').value);
    // se hace la solicitud al servidor
    const JSON3 = await dataFetch(API_RANKING, 'readN3', FORM3);
    if (JSON3.status) {
        // Se inicializa el contenedor de productos.
        N3.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON3.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            N3.innerHTML += `
            <div class="h-20 rounded-xl shadow-xl w-full border-2 mb-4 inline-flex items-center justify-between"
            style="border-color: #CD7F32;">
            <div class="inline-flex items-center">
            <img src="../imagenes/elements/3rd.png" alt="" srcset="" class="w-16 mb-5 ml-1">
            <h1 class="ml-3 mr-2 text-2xl" style="color: #CD7F32;;">#3</h1>
            </div>
            <h1 class="px-6 text-xl ml-8 mr-8">${row.nombre}</h1>
            <div class="inline-flex mr-8">
                <h1 class="px-6">El salvador</h1>
                <img src="../api/imagenes/banderas/64e2d2d082470.png" class="w-20 h-10"
                 onerror="this.src='../imagenes/notFound.png'">
            </div>
            
                `;
        });
    }
    else {
        sweetAlert(2, JSON3.exception, false);

    }

    // se establece un nuevo formulario
    const FORM4 = new FormData();
    // se le concatena el valor del deporte al formulario
    FORM4.append('deporte', document.getElementById('filtro-deporte').value);
    // se le concatena el valor de la modalidad al formulario
    FORM4.append('modalidad', document.getElementById('filtro-modalidad').value);
    // se hace la solicitud al servidor
    const JSON4 = await dataFetch(API_RANKING, 'readRest', FORM4);
    if (JSON4.status) {
        // Se inicializa el contenedor de productos.
        REST.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON4.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            REST.innerHTML += `
                <div
                class="h-20 rounded-xl shadow-xl w-full border-2  mb-4 inline-flex items-center justify-between">
                <h1 class="px-6 text-2xl">#${row.num}</h1>
                <h1 class="px-6 text-xl ml-8 mr-8">${row.nombre}</h1>
                <div class="inline-flex mr-8">
                    <h1 class="px-6">El salvador</h1>
                    <img src="../api/imagenes/banderas/64e2d2d082470.png" class="w-20 h-10"
                        onerror="this.src='../imagenes/notFound.png'">
                </div>
            </div>
                `;
        });
    }
    else {
        sweetAlert(2, JSON4.exception, false);
    }
    document.getElementById('rank').classList.remove('hidden');
    document.getElementById('contenido').classList.add('hidden');

};

// Funcion asincrona para limpiar los filtros de busqueda
async function clean() {
    document.getElementById('filtro-deporte').value = '';
    document.getElementById('filtro-modalidad').value = '';
    document.getElementById('f-deporte').classList.add('hidden');
    document.getElementById('f-modalidad').classList.add('hidden');
};