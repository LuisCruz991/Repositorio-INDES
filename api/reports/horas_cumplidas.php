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
            $pdf->startReport('Horas cumplidas de ' . $rowAtleta['nombre_atleta']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataAtleta = $atleta->horasAtleta()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(107,114,142);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(90, 10, 'Atleta', 1, 0, 'C', 1);
                $pdf->cell(90, 10, 'Horas cumplidas', 1, 1, 'C', 1);



                
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataAtleta as $rowDatos) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(90, 10, $pdf->encodeString($rowDatos['nombre_atleta']), 1, 0);
                    $pdf->cell(90, 10, $rowDatos['horas'], 1, 0);
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