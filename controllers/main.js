// Constante para completar la ruta de la API.
const ATLETA_API = 'business/atleta.php';
const EVENTO_API = 'business/evento.php';
const RECORDS_API = 'business/record.php';
const FEDERACIONES_API = 'business/federacion.php';




//Se mandan a llamar las funciones que generan los graficos.
graficoPastelGenero();
graficoBarrasTipo();
graficoBarrasAtletas();
graficoPastelFederaciones();


PROXIMO = document.getElementById('event');
NUM = document.getElementById('total');





/*
*Funcion asincrona para mostrar en un gráfico de pastel con la cantidad de atletas por un genero 
*   Parámetros: ninguno.
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
*   Función asíncrona para mostrar en un gráfico de barras segun la cantidad de eventos por tipo.
*   Parámetros: ninguno.
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
            <img src="${SERVER_URL}/imagenes/eventos/logos/${row.logo_evento}" onerror="this.src='../imagenes/notFound.png'" class="h-10 mx-auto">
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
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            NUM.innerHTML += `
            <div class="inline-flex">
            <svg fill="currentcolor" class="text-white w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>                  
            <h1 class="text-md ml-1 mt-2 text-white underline decoration-red-500">${row.num}</h1>
            </div>
            `;
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        NUM.textContent = JSON.exception;
    }

    
});




