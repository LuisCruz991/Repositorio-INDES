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
            $pdf->startReport('Ficha de' . $rowEntrenador['nombre']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEntrenador = $entrenador->readFicha()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(50, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(50, 10, 'Apellido', 1, 0, 'C', 1);
                $pdf->cell(21, 10, 'Telefono', 1, 0, 'C', 1);
                $pdf->cell(20, 10, 'Genero', 1, 0, 'C', 1);
                $pdf->cell(45, 10, 'Federacion', 1, 1 , 'C', 1);


                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataEntrenador as $rowDatos) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(50, 10, $pdf->encodeString($rowDatos['nombre']), 1, 0);
                    $pdf->cell(50, 10, $pdf->encodeString($rowDatos['apellido']), 1, 0);
                    $pdf->cell(21, 10, $pdf->encodeString($rowDatos['telefono']), 1, 0);
                    $pdf->cell(20, 10, $pdf->encodeString($rowDatos['nombre_genero']), 1, 0);
                    $pdf->cell(45, 10, $pdf->encodeString($rowDatos['nombre_federacion']), 1, 1);
                }

                $pdf->cell(62, 10, 'Direccion', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Dui', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Correo', 1, 1, 'C', 1);

                foreach ($dataEntrenador as $rowDatos) {
                $pdf->cell(62, 10, $pdf->encodeString($rowDatos['direccion']), 1, 0);
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['dui']), 1, 0);
                    $pdf->cell(62, 10, $pdf->encodeString($rowDatos['correo']), 1, 1);
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