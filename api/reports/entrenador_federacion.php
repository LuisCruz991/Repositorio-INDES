<?php
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['identrenador'])) {
    require_once('../../entities/dto/entrenador.php');
    require_once('../../entities/dto/federacion.php');
    // Se instancian las entidades correspondientes.
    $entrenador = new Entrenador;
    $federacion = new Federacion;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($federacion->setId($_GET['idfederacion']) && $entrenador->setFedereacion($_GET['idfederacion'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowFederacion = $federacion->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Entrenadores de la federacion ' . $rowFederacion['nombre_federacion']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEntrenador = $entrenador->entrenadorFederacion()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(27, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(27, 10, 'Telefono', 1, 0, 'C', 1);
                $pdf->cell(28, 10, 'DUI', 1, 0, 'C', 1);
                $pdf->cell(50, 10, 'Correo', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataEntrenador as $rowEntrenador) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(27, 10, $pdf->encodeString($rowEntrenador['nombre']), 1, 0);
                    $pdf->cell(27, 10, $rowEntrenador['telefono'], 1, 0);
                    $pdf->cell(28, 10, $rowEntrenador['dui'], 1, 0);
                    $pdf->cell(50, 10, $rowEntrenador['correo'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay entrenadores para la federacion'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'entrenadores_de_federacion.pdf');
        } else {
            print('Federacion inexistente');
        }
    } else {
        print('Federacion incorrecta');
    }
} else {
    print('Debe seleccionar una Federacion');
}
