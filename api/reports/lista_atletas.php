<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');
require_once('../entities/dto/atleta.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Atletas por federacion');
// Se instancia el módelo Categoría para obtener los datos.
$atleta = new Atleta;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataAtletas = $atleta->readFederaciones()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(107,114,142);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(46, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(46, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(29, 10, 'Nacimiento', 1, 0, 'C', 1);
    $pdf->cell(45, 10, 'Entrenador', 1, 0 , 'C', 1);
    $pdf->cell(20, 10, 'Genero', 1, 1, 'C', 1);
   

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(120,161,175);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataAtletas as $rowAtleta) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Federacion: ' . $rowAtleta['nombre_federacion']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($atleta->setFederacion($rowAtleta['idfederacion'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataAtletas = $atleta->readAtletasFederacion()) {
                // Se recorren los registros fila por fila.
                foreach ($dataAtletas as $rowAtleta) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(46, 10, $pdf->encodeString($rowAtleta['nombre_atleta']), 1, 0);
                    $pdf->cell(46, 10, $pdf->encodeString($rowAtleta['apellido_atleta']), 1, 0);
                    $pdf->cell(29, 10, $rowAtleta['nacimiento'], 1, 0);
                    $pdf->cell(45, 10, $pdf->encodeString($rowAtleta['nombre']), 1, 0);
                    $pdf->cell(20, 10, $pdf->encodeString($rowAtleta['nombre_genero']), 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay atletas '), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Federacion incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay federeaciones para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'atletas.pdf');