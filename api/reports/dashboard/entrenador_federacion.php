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
    if ($federacion->setId($_GET['identrenador']) && $federacion->setCategoria($_GET['identrenador'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowFederacion = $federacion->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Entrenadores de la federacion ' . $entrenador['nombre_categoria']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
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
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'categoria.pdf');
        } else {
            print('Categoría inexistente');
        }
    } else {
        print('Categoría incorrecta');
    }
} else {
    print('Debe seleccionar una categoría');
}
