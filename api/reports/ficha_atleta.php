<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idatleta'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../entities/dto/atleta.php');
    // Se instancian las entidades correspondientes.
    $atleta = new Atleta;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($atleta->setId($_GET['idatleta']) ) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowAtleta = $atleta->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Ficha de ' . $rowAtleta['nombre_atleta']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataAtleta = $atleta->readFicha()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(107,114,142);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(100, 10, 'Nombre y apellido', 1, 0, 'C', 1);
                $pdf->cell(43, 10, 'Nacimiento', 1, 0, 'C', 1);
                $pdf->cell(43, 10, 'Genero', 1, 1, 'C', 1);


                
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataAtleta as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['atleta']), 1, 0, 'C');
                    $pdf->cell(43, 10, $pdf->encodeString($rowDatos['nacimiento']), 1, 0, 'C');
                    $pdf->cell(43, 10, $pdf->encodeString($rowDatos['nombre_genero']), 1, 1, 'C');
                }
                
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(100, 10, 'Estatura y peso', 1, 0, 'C', 1);
                $pdf->cell(86, 10, 'Talla de camisa y short', 1, 1, 'C', 1);

                foreach ($dataAtleta as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    $pdf->cell(100, 10, $pdf->encodeString($rowDatos['medida']), 1, 0, 'C');
                    $pdf->cell(86, 10, $pdf->encodeString($rowDatos['tallas']), 1, 1, 'C');
                }
                
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(50, 10, 'Direccion', 1, 0, 'C', 1);
                $pdf->cell(50, 10, 'DUI', 1, 0, 'C', 1);
                $pdf->cell(43, 10, 'Celular', 1, 0, 'C', 1);
                $pdf->cell(43, 10, 'Telefono fijo', 1, 1, 'C', 1);

                foreach ($dataAtleta as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    $pdf->cell(50, 10, $pdf->encodeString($rowDatos['direccion']), 1, 0, 'C');
                    $pdf->cell(50, 10, $pdf->encodeString($rowDatos['dui']), 1, 0, 'C');
                    $pdf->cell(43, 10, $pdf->encodeString($rowDatos['celular']), 1, 0, 'C');
                    $pdf->cell(43, 10, $pdf->encodeString($rowDatos['telefono_casa']), 1, 1, 'C');
                }
                
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(62, 10, 'Correo', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Responsable', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Entrenador', 1, 1, 'C', 1);

                foreach ($dataAtleta as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['correo']), 1, 0, 'C');
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['nombre_responsable']), 1, 0, 'C');
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['entrenadores']), 1, 1, 'C');
                }
                
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 11);
                $pdf->cell(186, 10, 'Federacion', 1, 1, 'C', 1);

                foreach ($dataAtleta as $rowDatos) {
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    $pdf->cell(186, 10, $pdf->encodeString($rowDatos['nombre_federacion']), 1, 1, 'C');
                }

            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay informacion para mostrar'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Ficha atleta.pdf');
        } else {
            print('Informacion inexistente');
        }
    } else {
        print('Informacion incorrecto');
    }
} else {
    print('Debe seleccionar un atleta');
}