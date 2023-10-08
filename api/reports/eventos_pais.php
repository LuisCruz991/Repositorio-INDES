<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');
require_once('../entities/dto/evento.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Eventos por paises');
// Se instancia el módelo Categoría para obtener los datos.
$evento = new Event;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataEvento = $evento->readPais()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(107,114,142);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(66, 10, 'Direccion', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Tipo de Evento', 1, 1, 'C', 1);
   

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(120,161,175);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', 'B', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataEvento as $rowEvento) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Pais: ' . $rowEvento['nombre_pais']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($evento->setPais($rowEvento['idpais'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEvento = $evento->readEventoPais()) {
                // Se recorren los registros fila por fila.
                foreach ($dataEvento as $rowEvento) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(40, 20, $pdf->encodeString($rowEvento['nombre_evento']), 1, 0, 'C');
                    $pdf->cell(40, 20, $pdf->encodeString($rowEvento['fecha_evento']), 1, 0, 'C');
                    $pdf->cell(66, 20, $pdf->encodeString($rowEvento['direccion_sede']), 1, 0, 'C');
                    $pdf->cell(40, 20, $pdf->encodeString($rowEvento['nombre']), 1, 0, 'C');
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay eventos '), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Pais incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay paises para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'eventos.pdf');