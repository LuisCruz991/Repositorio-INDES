<?php
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idtipo_evento'])) {
    require_once('../../entities/dto/categoria.php');
    require_once('../../entities/dto/producto.php');
    // Se instancian las entidades correspondientes.
    $tipo = new TipoEvento;
    $evento = new Event;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($tipo->setId($_GET['idtipo_evento']) && $evento->setTipoEvento($_GET['idtipo_evento'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowTipo = $tipo->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Eventos de un tipo ' . $rowTipo['nombre']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEvento = $evento->productosCategoria()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataEvento as $rowEvento) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowEvento['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowEvento['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'tipos_eventos.pdf');
        } else {
            print('Tipo de evento inexistente');
        }
    } else {
        print('Tipo de evento incorrecto');
    }
} else {
    print('Debe seleccionar una categoría');
}
