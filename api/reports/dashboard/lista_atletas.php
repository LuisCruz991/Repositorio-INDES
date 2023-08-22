<?php
require_once('../../helpers/report.php');
require_once('../../entities/dto/atleta.php');


// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
    // Se instancian las entidades correspondientes.
    $atleta = new Atleta;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($dataAtletas = $atleta->readAtletasFederacion()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Atletas por federacion');
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(45, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(45, 10, 'Apellido', 1, 0, 'C', 1);
                $pdf->cell(46, 10, 'Nacimiento', 1, 0, 'C', 1);
                $pdf->cell(46, 10, 'Genero', 1, 1, 'C', 1);
                $pdf->cell(46, 10, 'Dui', 1, 1, 'C', 1);
                $pdf->cell(46, 10, 'Celular', 1, 1, 'C', 1);
                $pdf->cell(46, 10, 'Correo', 1, 1, 'C', 1);
                $pdf->cell(46, 10, 'Federacion', 1, 1, 'C', 1);
                $pdf->cell(46, 10, 'Entrenador', 1, 1, 'C', 1);

                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataAtletas as $rowAtleta) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(45, 10, $pdf->encodeString($rowAtleta['nombre_atleta']), 1, 0);
                    $pdf->cell(45, 10, $pdf->encodeString($rowAtleta['apellido_atleta']), 1, 0);
                    $pdf->cell(30, 10, $rowAtleta['nacimiento'], 1, 0);
                    $pdf->cell(30, 10, $pdf->encodeString($rowAtleta['nombre_genero']), 1, 0);
                    $pdf->cell(30, 10, $rowAtleta['dui'], 1, 0);
                    $pdf->cell(30, 10, $rowAtleta['celular'], 1, 0);
                    $pdf->cell(45, 10, $pdf->encodeString($rowAtleta['correo']), 1, 0);
                    $pdf->cell(45, 10, $pdf->encodeString($rowAtleta['nombre_federacion']), 1, 0);
                    $pdf->cell(45, 10, $pdf->encodeString($rowAtleta['nombre']), 1, 0);

                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay atletas'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'lista_atletas.pdf');
        } else {
            print('Atleta inexistente');
        }



