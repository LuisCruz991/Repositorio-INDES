// Constante para completar la ruta de la API.
const ATLETA_API = 'business/atleta.php';
const EVENTO_API = 'business/evento.php';


//Se mandan a llamar las funciones que generan los graficos.
graficoPastelGenero();
graficoBarrasTipo();





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
        pieGraph('chart7', genero_atleta, cantidades, 'Cantidad de atletas', 'Cantidad de atletas por genero');
    } else {
        document.getElementById('chart7').remove();
        console.log(JSON.exception);
    }
}


/*
*   Función asíncrona para mostrar en un gráfico de barras segun la cantidad de eventos por tipo.
*   Parámetros: ninguno.
*/
async function graficoBarrasTipo() {
    // Petición para obtener los datos del gráfico.
    const JSON = await dataFetch(PRODUCTO_API, 'cantidadEventosTipo');
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
        barGraphY('chart6', tipo_evento, cantidades, 'Cantidad de productos', 'Cantidad de productos por marca');
    } else {
        document.getElementById('chart6').remove();
        console.log(JSON.exception);
    }
}