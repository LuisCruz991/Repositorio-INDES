<?php
require_once('../entities/dto/federacion.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $federacion = new Federacion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso para leer todos los registros de la tabla
            case 'readAll':
                if ($result['dataset'] = $federacion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'La tabla cuenta con ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            // Caso para usar el buscador 
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $federacion->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            // Caso para realizar la insercion de datos
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$federacion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$federacion->setSiglas($_POST['siglas'])) {
                    $result['exception'] = 'Siglas no validas';
                } elseif (!$federacion->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion no valida';
                } elseif (!$federacion->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono no valido';
                } elseif (!$federacion->setDeporte($_POST['deporte'])) {
                    $result['exception'] = 'Deporte no valido';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$federacion->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($federacion->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $federacion->getRuta(), $federacion->getImagen())) {
                        $result['message'] = 'Federacion creada correctamente';
                    } else {
                        $result['message'] = 'Federacion guardada, pero no se logró guardar el logo';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            // Caso para leer los datos de un unico registro
            case 'readOne':
                if (!$federacion->setId($_POST['idfederacion'])) {
                    $result['exception'] = 'Federacion no valida';
                } elseif ($result['dataset'] = $federacion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Federacion inexistente';
                }
                break;
            // Caso para realizar la operacion de actualizar un registro 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$federacion->setId($_POST['id'])) {
                    $result['exception'] = 'Evento no valido';
                } elseif (!$data = $federacion->readOne()) {
                    $result['exception'] = 'Federacion no leída correctamente';
                } elseif (!$federacion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$federacion->setSiglas($_POST['siglas'])) {
                    $result['exception'] = 'Siglas no validas';
                } elseif (!$federacion->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion no valida';
                } elseif (!$federacion->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono no valido';
                } elseif (!$federacion->setDeporte($_POST['deporte'])) {
                    $result['exception'] = 'Deporte no valido';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($federacion->updateRow($data['logo'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Federacion actualizada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$federacion->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($federacion->updateRow($data['logo'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $federacion->getRuta(), $federacion->getImagen())) {
                        $result['message'] = 'Federacion actualizada correctamente';
                    } else {
                        $result['message'] = 'No fue posible actualizar la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            // Caso pra eliminar un registro 
            case 'delete':
                if (!$federacion->setId($_POST['id'])) {
                    $result['exception'] = 'Federacion no valida';
                } elseif (!$data = $federacion->readOne()) {
                    $result['exception'] = 'Hubó un error al tratar de leer la federacion';
                } elseif ($federacion->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($federacion->getRuta(), $data['imagen_sede'])) {
                        $result['message'] = 'Federacion descartada de forma satisfactoría';
                    } else {
                        $result['message'] = 'Ocurrió un problema al tratar de descartar la federacion';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Evento para obtener todos los atletas que pertenecen a cada federacion 
            case 'cantidadAtletasFederaciones':
                if (
                    $result['dataset'] = $federacion->cantidadAtletasFederaciones
                    ()
                ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}