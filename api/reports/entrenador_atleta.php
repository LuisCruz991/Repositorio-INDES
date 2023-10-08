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
            $pdf->startReport('Atletas a cargo de ' . $rowEntrenador['nombre']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEntrenador = $entrenador->atletaEntrenador()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(107,114,142);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(62, 10, 'Nombre del atleta', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Apellido del atleta', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Celular del atleta', 1, 1, 'C', 1);


                
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataEntrenador as $rowDatos) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['nombre_atleta']), 1, 0, 'C');
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['apellido_atleta']), 1, 0, 'C');
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['celular']), 1, 1, 'C');
                }

            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay informacion para mostrar'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Entrenador_atleta.pdf');
        } else {
            print('Informacion inexistente');
        }
    } else {
        print('Informacion incorrecto');
    }
} else {
    print('Debe seleccionar un entrenador');
}