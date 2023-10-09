// Constante para completar la ruta de la API.
const ATLETA_API = 'business/atleta.php';
const EVENTO_API = 'business/evento.php';
const RECORDS_API = 'business/record.php';
const FEDERACIONES_API = 'business/federacion.php';
const API = '../api/';



//Se mandan a llamar las funciones que generan los graficos.
graficoPastelGenero();
graficoBarrasTipo();
graficoBarrasAtletas();
graficoPastelFederaciones();


PROXIMO = document.getElementById('event');
NUM = document.getElementById('total');
A1 = document.getElementById('n1');
A2 = document.getElementById('n2');
A3 = document.getElementById('n3');





/*
*Funcion asincrona para mostrar en un gráfico de pastel con la cantidad de atletas por un genero
* Parámetros: ninguno.
*/
async function graficoPastelGenero() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(ATLETA_API, 'cantidadAtletasGenero');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let genero_atleta = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            genero_atleta.push(row.nombre_genero);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        doughnutGraph('chart7', genero_atleta, cantidades, 'Cantidad de atletas por genero');
    } else {
        document.getElementById('chart7').remove();
        console.log(JSON.exception);
    }
};


/*
* Función asíncrona para mostrar en un gráfico de barras segun la cantidad de eventos por tipo.
* Parámetros: ninguno.
*/
async function graficoBarrasTipo() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(EVENTO_API, 'cantidadEventosTipo');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let tipo_evento = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            tipo_evento.push(row.nombre);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        pieGraph('chart6', tipo_evento, cantidades, 'Cantidad de eventos por categoría');
    } else {
        document.getElementById('chart6').remove();
        console.log(JSON.exception);
    }
};

// funcion para generar el grafico de los atletas con mas titulos
async function graficoBarrasAtletas() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(RECORDS_API, 'readAtletasTitulos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let nombre_atleta = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            nombre_atleta.push(row.nombre_atleta);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraphX('chart1', nombre_atleta, cantidades, 'Cantidad de titulos', 'Top 5 atletas con mas titulos');
    } else {
        document.getElementById('chart1').remove();
        console.log(JSON.exception);
    }
};

// Funcion para generar el grafico de la cantidad de atletas por federacione
async function graficoPastelFederaciones() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(FEDERACIONES_API, 'cantidadAtletasFederaciones');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let atletas = [];
        let federaciones = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            atletas.push(row.cantidad);
            federaciones.push(row.siglas);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraphY('chart4', federaciones, atletas, 'Numero de atletas', 'Cantidad de atletas por federación');
    } else {
        document.getElementById('chart4').remove();
        atletas.push(row.cantidad);
        federaciones.push(row.siglas);
    };
};

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Constante que guarda el resultado de ejecutuar la consulta
    const JSON = await dataFetch(EVENTO_API, 'nextEvents');
    // Constante que guarda el resultado de ejecutuar la consulta
    const JSON2 = await dataFetch(ATLETA_API, 'numAtletas');
    // Constante que guarda el resultado de ejecutuar la consulta
    const JSON3 = await dataFetch(ATLETA_API, 'atleta1');
    // Constante que guarda el resultado de ejecutuar la consulta
    const JSON4 = await dataFetch(ATLETA_API, 'atleta2');
    // Constante que guarda el resultado de ejecutuar la consulta
    const JSON5 = await dataFetch(ATLETA_API, 'atleta3');

    // Metodo para cargar el proximo evento
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        PROXIMO.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PROXIMO.innerHTML += `
            <div>
                <p class="text-white mb-2 text-sm">${row.nombre_evento}</p>
                <img src="${SERVER_URL}/imagenes/eventos/logos/${row.logo_evento}" onerror="this.src='../imagenes/notFound.png'"
                    class="h-10 mx-auto">
            </div>
            `;
        });

    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        PROXIMO.textContent = JSON.exception;
    }
    // Metodo para cargar el numero de atletas
    if (JSON2.status) {
        // se declara la variable
        NUM.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON2.dataset.forEach(row => {
            NUM.innerHTML += `
        <div class="inline-flex">
            <svg fill="currentcolor" class="text-white w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
            </svg>
            <h1 class="text-md ml-1 mt-2 text-white underline decoration-red-500">${row.num}</h1>
        </div>
        `;
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        NUM.textContent = JSON.exception;
    }
    // Metodo para cargar el numero de atletas
    if (JSON3.status) {
        // se declara la variable
        A1.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON3.dataset.forEach(row => {
            A1.innerHTML += `
        <div class="w-24 h-10 rounded-r-md border-2 bg-yellow-300 border-yellow-400 mt-3" >
        <h1 class="text-xs" style="color: #171a4a;">${row.nombre}</h1>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" fill="currentcolor" class="ml-2 mt-2" style="color: #FFD700;"><path d="M400 0H176c-26.5 0-48.1 21.8-47.1 48.2c.2 5.3 .4 10.6 .7 15.8H24C10.7 64 0 74.7 0 88c0 92.6 33.5 157 78.5 200.7c44.3 43.1 98.3 64.8 138.1 75.8c23.4 6.5 39.4 26 39.4 45.6c0 20.9-17 37.9-37.9 37.9H192c-17.7 0-32 14.3-32 32s14.3 32 32 32H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H357.9C337 448 320 431 320 410.1c0-19.6 15.9-39.2 39.4-45.6c39.9-11 93.9-32.7 138.2-75.8C542.5 245 576 180.6 576 88c0-13.3-10.7-24-24-24H446.4c.3-5.2 .5-10.4 .7-15.8C448.1 21.8 426.5 0 400 0zM48.9 112h84.4c9.1 90.1 29.2 150.3 51.9 190.6c-24.9-11-50.8-26.5-73.2-48.3c-32-31.1-58-76-63-142.3zM464.1 254.3c-22.4 21.8-48.3 37.3-73.2 48.3c22.7-40.3 42.8-100.5 51.9-190.6h84.4c-5.1 66.3-31.1 111.2-63 142.3z"/></svg>
        `;
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        A1.textContent = JSON.exception;
    }
    // Metodo para cargar el numero de atletas
    if (JSON4.status) {
        // se declara la variable
        A2.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON4.dataset.forEach(row => {
            A2.innerHTML += `
        <div class="w-20 h-10 rounded-r-md" style="border-color: #C0C0C0; border-width: 2px; background-color: #a9a9a9;">
        <h1 class="text-xs" style="color: #171a4a;">${row.nombre}</h1>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" fill="currentcolor" class="ml-2" style="color: #d4d2d2;" viewBox="0 0 384 512"><path d="M173.8 5.5c11-7.3 25.4-7.3 36.4 0L228 17.2c6 3.9 13 5.8 20.1 5.4l21.3-1.3c13.2-.8 25.6 6.4 31.5 18.2l9.6 19.1c3.2 6.4 8.4 11.5 14.7 14.7L344.5 83c11.8 5.9 19 18.3 18.2 31.5l-1.3 21.3c-.4 7.1 1.5 14.2 5.4 20.1l11.8 17.8c7.3 11 7.3 25.4 0 36.4L366.8 228c-3.9 6-5.8 13-5.4 20.1l1.3 21.3c.8 13.2-6.4 25.6-18.2 31.5l-19.1 9.6c-6.4 3.2-11.5 8.4-14.7 14.7L301 344.5c-5.9 11.8-18.3 19-31.5 18.2l-21.3-1.3c-7.1-.4-14.2 1.5-20.1 5.4l-17.8 11.8c-11 7.3-25.4 7.3-36.4 0L156 366.8c-6-3.9-13-5.8-20.1-5.4l-21.3 1.3c-13.2 .8-25.6-6.4-31.5-18.2l-9.6-19.1c-3.2-6.4-8.4-11.5-14.7-14.7L39.5 301c-11.8-5.9-19-18.3-18.2-31.5l1.3-21.3c.4-7.1-1.5-14.2-5.4-20.1L5.5 210.2c-7.3-11-7.3-25.4 0-36.4L17.2 156c3.9-6 5.8-13 5.4-20.1l-1.3-21.3c-.8-13.2 6.4-25.6 18.2-31.5l19.1-9.6C65 70.2 70.2 65 73.4 58.6L83 39.5c5.9-11.8 18.3-19 31.5-18.2l21.3 1.3c7.1 .4 14.2-1.5 20.1-5.4L173.8 5.5zM272 192a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM1.3 441.8L44.4 339.3c.2 .1 .3 .2 .4 .4l9.6 19.1c11.7 23.2 36 37.3 62 35.8l21.3-1.3c.2 0 .5 0 .7 .2l17.8 11.8c5.1 3.3 10.5 5.9 16.1 7.7l-37.6 89.3c-2.3 5.5-7.4 9.2-13.3 9.7s-11.6-2.2-14.8-7.2L74.4 455.5l-56.1 8.3c-5.7 .8-11.4-1.5-15-6s-4.3-10.7-2.1-16zm248 60.4L211.7 413c5.6-1.8 11-4.3 16.1-7.7l17.8-11.8c.2-.1 .4-.2 .7-.2l21.3 1.3c26 1.5 50.3-12.6 62-35.8l9.6-19.1c.1-.2 .2-.3 .4-.4l43.2 102.5c2.2 5.3 1.4 11.4-2.1 16s-9.3 6.9-15 6l-56.1-8.3-32.2 49.2c-3.2 5-8.9 7.7-14.8 7.2s-11-4.3-13.3-9.7z"/></svg>                   
        `;
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        A2.textContent = JSON.exception;
    }
    // Metodo para cargar el numero de atletas
    if (JSON5.status) {
        // se declara la variable
        A3.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON5.dataset.forEach(row => {
            A3.innerHTML += `
        <div class="w-16 h-10 rounded-r-md rounded-b-lg" style="border-color: #CD7F32; border-width: 2px; background-color: #b26e2a;">
        <h1 class="text-xs " style="color: #171a4a;">${row.nombre}</h1>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" fill="currentcolor" class="ml-2" style="color:#CD7F32;" viewBox="0 0 384 512"><path d="M173.8 5.5c11-7.3 25.4-7.3 36.4 0L228 17.2c6 3.9 13 5.8 20.1 5.4l21.3-1.3c13.2-.8 25.6 6.4 31.5 18.2l9.6 19.1c3.2 6.4 8.4 11.5 14.7 14.7L344.5 83c11.8 5.9 19 18.3 18.2 31.5l-1.3 21.3c-.4 7.1 1.5 14.2 5.4 20.1l11.8 17.8c7.3 11 7.3 25.4 0 36.4L366.8 228c-3.9 6-5.8 13-5.4 20.1l1.3 21.3c.8 13.2-6.4 25.6-18.2 31.5l-19.1 9.6c-6.4 3.2-11.5 8.4-14.7 14.7L301 344.5c-5.9 11.8-18.3 19-31.5 18.2l-21.3-1.3c-7.1-.4-14.2 1.5-20.1 5.4l-17.8 11.8c-11 7.3-25.4 7.3-36.4 0L156 366.8c-6-3.9-13-5.8-20.1-5.4l-21.3 1.3c-13.2 .8-25.6-6.4-31.5-18.2l-9.6-19.1c-3.2-6.4-8.4-11.5-14.7-14.7L39.5 301c-11.8-5.9-19-18.3-18.2-31.5l1.3-21.3c.4-7.1-1.5-14.2-5.4-20.1L5.5 210.2c-7.3-11-7.3-25.4 0-36.4L17.2 156c3.9-6 5.8-13 5.4-20.1l-1.3-21.3c-.8-13.2 6.4-25.6 18.2-31.5l19.1-9.6C65 70.2 70.2 65 73.4 58.6L83 39.5c5.9-11.8 18.3-19 31.5-18.2l21.3 1.3c7.1 .4 14.2-1.5 20.1-5.4L173.8 5.5zM272 192a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM1.3 441.8L44.4 339.3c.2 .1 .3 .2 .4 .4l9.6 19.1c11.7 23.2 36 37.3 62 35.8l21.3-1.3c.2 0 .5 0 .7 .2l17.8 11.8c5.1 3.3 10.5 5.9 16.1 7.7l-37.6 89.3c-2.3 5.5-7.4 9.2-13.3 9.7s-11.6-2.2-14.8-7.2L74.4 455.5l-56.1 8.3c-5.7 .8-11.4-1.5-15-6s-4.3-10.7-2.1-16zm248 60.4L211.7 413c5.6-1.8 11-4.3 16.1-7.7l17.8-11.8c.2-.1 .4-.2 .7-.2l21.3 1.3c26 1.5 50.3-12.6 62-35.8l9.6-19.1c.1-.2 .2-.3 .4-.4l43.2 102.5c2.2 5.3 1.4 11.4-2.1 16s-9.3 6.9-15 6l-56.1-8.3-32.2 49.2c-3.2 5-8.9 7.7-14.8 7.2s-11-4.3-13.3-9.7z"/></svg>                   
        `;
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        A3.textContent = JSON.exception;
    }
    //Metodo para ejecutar la solicitud php que cargara las noticias
    fetch(`${API}helpers/news.php`)
        .then(response => response.json())
        .then(data => {
            // Se define la variable que guardara los datos de una noticia
            let noticias = '';
            // Si la respuesta es satisfactoria se recorre cada conjunto (array) de datos
            if (data.status === 'ok') {
                data.articles.forEach(article => {
                    noticias += `
                        <div class="mt-3 ml-3 mr-3 mb-10 w-auto h-max bg-gray-50 border-b-2 border-azul-1 shadow-md rounded-md overflow-scroll">
                        <div class="py-2 px-2 min-w-fit h-autoflex justify-center">
                          <h1 class="text-center">${article.title}</h1>
                        </div>
                        <div class=" flex justify-center ml-2 mr-2 mb-2 max-w-fit max-h-fit">
                          <img src="${article.urlToImage}" class="rounded-md mb-2 max-w-fit max-h-fit" onerror="this.src='../imagenes/notFound.png'">
                        </div>
                        <p class="text-left ml-2 font-overpass">${article.description ? article.description : 'Descripción no disponible'}</p>
                        <a href="${article.url}"
                          class="flex justify-center p-4 font-medium text-blue-600 dark:text-blue-500 hover:underline">Leer
                          más</a>
                      </div>
                    `;
                });
            } else {
                // En caso de no haber resultados se muestra un mensaje
                noticias = '<p class="text-center">No hay noticias que buscar.</p>';
            }
            //En caso de exito se cargan todas las noticias encontradas 
            document.getElementById('news').innerHTML = noticias;
        }) // En caso de que de error se muestra el error en la consola y se muestra un mensaje de error
        .catch(error => {
            console.error('Error fetching the news:', error);
            document.getElementById('news').innerHTML = '<p>Error al buscar noticias.</p>';
        });

});