<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');
require_once('../entities/dto/entrenador.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Entrenadores por federacion');
// Se instancia el módelo Categoría para obtener los datos.
$entrenador = new Entrenador;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataEntrenador = $entrenador->readFederacion()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(107,114,142);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(44, 10, 'Nombre y apellido', 1, 0, 'C', 1);
    $pdf->cell(36, 10, 'Telefono', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'DUI', 1, 0, 'C', 1);
    $pdf->cell(66, 10, 'Correo', 1, 1, 'C', 1);
   

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(120,161,175);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', 'B', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataEntrenador as $rowEntrenador) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Federacion: ' . $rowEntrenador['nombre_federacion']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($entrenador->setFederacion($rowEntrenador['idfederacion'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEntrenador = $entrenador->readEntrenadorFederacion()) {
                // Se recorren los registros fila por fila.
                foreach ($dataEntrenador as $rowEntrenador) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(44, 10, $pdf->encodeString($rowEntrenador['entrenador']), 1, 0, 'C');
                    $pdf->cell(36, 10, $pdf->encodeString($rowEntrenador['telefono']), 1, 0, 'C');
                    $pdf->cell(40, 10, $pdf->encodeString($rowEntrenador['dui']), 1, 0, 'C');
                    $pdf->cell(66, 10, $pdf->encodeString($rowEntrenador['correo']), 1, 1, 'C');
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay entrenadores '), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Federacion incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay federeaciones para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'entrenadores.pdf');