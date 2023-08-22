<?php
require_once('../../helpers/report.php');
require_once('../../entities/dto/pruebas.php');
require_once('../../entities/dto/depote.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Pruebas por deportes');
// Se instancia el módelo Categoría para obtener los datos.
$deporte = new Deporte;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataDeporte = $deporte->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(62, 10, 'Numero de prueba', 1, 0, 'C', 1);
    $pdf->cell(62, 10, 'Nombre prueba', 1, 0, 'C', 1);
    $pdf->cell(62, 10, 'Modalidad', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataDeporte as $rowDeporte) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Deporte: ' . $rowDeporte['nombre_deporte']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $prueba = new Prueba;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($prueba->setDeporte($rowDeporte['iddeporte'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPrueba = $producto->pruebasDeportes()) {
                // Se recorren los registros fila por fila.
                foreach ($dataPrueba as $rowPruebas) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(62, 10, $pdf->encodeString($rowPruebas['idprueba']), 1, 0);
                    $pdf->cell(62, 10, $rowPruebas['nombre_prueba'], 1, 0);
                    $pdf->cell(62, 10, $rowPruebas['nombre_modalidad'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay pruebas del deporte'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Deporte incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay deportes para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
