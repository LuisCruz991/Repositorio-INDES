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
            $pdf->startReport('Asistencia de ' . $rowAtleta['nombre_atleta']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataAtleta = $atleta->horasAtleta()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(107,114,142);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(37, 10, 'Lugar de entreno', 1, 0, 'C', 1);
                $pdf->cell(37, 10, 'Fecha', 1, 0, 'C', 1);
                $pdf->cell(37, 10, 'Hora de inicio', 1, 0, 'C', 1);
                $pdf->cell(37, 10, 'Hora de cierre', 1, 0, 'C', 1);
                $pdf->cell(37, 10, 'Horas entrenadas', 1, 1, 'C', 1);






                
                // Se establece la fuente para los datos del reporte.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataAtleta as $rowDatos) {
                    // Se imprimen las celdas con los datos de la consulta.
                    $pdf->cell(37, 10, $pdf->encodeString($rowDatos['lugar_entreno']), 1, 0);
                    $pdf->cell(37, 10, $rowDatos['fecha_entreno'], 1,0,'C', 0);
                    $pdf->cell(37, 10, $pdf->encodeString($rowDatos['hora_inicio']), 1,0,'C', 0);
                    $pdf->cell(37, 10, $pdf->encodeString($rowDatos['hora_cierre']), 1,0,'C', 0);
                    $pdf->cell(37, 10, $pdf->encodeString($rowDatos['horas']), 1,1,'C',0);
                }

                // Se recorren los registros fila por fila.
                if ($dataAtleta = $atleta ->horasAtleta()) {
                // se crea la variable "rowHoras" para capturar los datos de la cosulta "horasAtletas"
                $rowHoras = $atleta->horasAtleta();
                // se crea un arreglo "array" para almacenar solamente los datos de la columna "horas"
                $array= array_column($rowHoras,'horas');
                // se saca un promedio de los datos obtenidos de la consulta
                $total = array_sum($array)/count($array);
                 // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas de la columna con el promedio de las horas entrenadas.
                    $pdf->cell(37, 10, 'Promedio:', 1, 0, 'C', 1);
                    $pdf->cell(37, 10, '', 1, 0, 'C', 0);
                    $pdf->cell(37, 10, '', 1, 0, 'C', 0);
                    $pdf->cell(37, 10, '', 1, 0, 'C', 0);
                    // se imprime la celda que almacena el valor del promedio de las horas entrenadas
                    $pdf->cell(37, 10, $total, 1, 1, 'C', 0);
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