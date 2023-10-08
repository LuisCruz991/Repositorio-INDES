<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['identrenador'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../entities/dto/entrenador.php');
    // Se instancian las entidades correspondientes.
    $entrenador = new Entrenador;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($entrenador->setId($_GET['identrenador']) ) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowEntrenador = $entrenador->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Ficha de ' . $rowEntrenador['nombre']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEntrenador = $entrenador->readFicha()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(107,114,142);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(86, 10, 'Nombre y apellido', 1, 0, 'C', 1);   
                foreach ($dataEntrenador as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['entrenador']), 1, 1, 'C');
                }
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(86, 10, 'Telefono', 1, 0, 'C', 1);   
                foreach ($dataEntrenador as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['telefono']), 1, 1, 'C');
                }
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(86, 10, 'Genero', 1, 0, 'C', 1);   
                foreach ($dataEntrenador as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['nombre_genero']), 1, 1, 'C');
                }
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(86, 10, 'Direccion', 1, 0, 'C', 1);   
                foreach ($dataEntrenador as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['direccion']), 1, 1, 'C');
                }
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(86, 10, 'Dui', 1, 0, 'C', 1);   
                foreach ($dataEntrenador as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['dui']), 1, 1, 'C');
                }
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(86, 10, 'Correo', 1, 0, 'C', 1);   
                foreach ($dataEntrenador as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['correo']), 1, 1, 'C');
                }
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(86, 10, 'Federacion', 1, 0, 'C', 1);   
                foreach ($dataEntrenador as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['nombre_federacion']), 1, 1, 'C');
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para el tipo de material'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Ficha atletav.pdf');
        } else {
            print('Tipo de material inexistente');
        }
    } else {
        print('Tipo de material incorrecto');
    }
} else {
    print('Debe seleccionar un tipo de material');
}