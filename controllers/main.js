//Se mandan a llamar las funciones que generan los graficos.
graficoBarrasDeportes();

/*
*Funcion asincrona para mostrar en un gráfico de barras la cantidad de deportes que practican los atletas.
*/
async function graficoBarrasDeportes() {
    //Solicitud para obtener los datos del grafico.
    const DATA = await fetchData(DEPORTES_API, 'cantidadDeportesAtletas')
}