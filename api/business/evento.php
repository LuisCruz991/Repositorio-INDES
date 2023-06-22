<?php
require_once('../entities/dto/evento.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $evento = new Event;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $evento->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $evento->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$evento->setEvento($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del evento incorrecto';
                } elseif (!$evento->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripcion no valida';
                } elseif (!$evento->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion del evento no valido';
                } elseif (!isset($_POST['tipo'])) {
                    $result['exception'] = 'Seleccione una categoria para el evento';
                } elseif (!$evento->setTipoEvento($_POST['evento'])) {
                    $result['exception'] = 'Categoria no valida';
                } elseif (!$evento->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha no valida';
                } elseif (!$evento->setHoraCierre($_POST['horaC'])) {
                    $result['exception'] = 'Hora no valida';
                } elseif (!$evento->setHoraInicio($_POST['horaI'])) {
                    $result['exception'] = 'Hora no valida';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$evento->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($evento->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $evento->getRuta(), $evento->getImagen())) {
                        $result['message'] = 'Evento creado correctamente';
                    } else {
                        $result['message'] = 'Evento guardado, pero no se logró guardar la foto de la sede';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$evento->setId($_POST['id'])) {
                    $result['exception'] = 'Evento no valido';
                } elseif ($result['dataset'] = $evento->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Evento inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$evento->setId($_POST['id'])) {
                    $result['exception'] = 'Evento no valido';
                } elseif (!$data = $evento->readOne()) {
                    $result['exception'] = 'Evento no leído correctamente';
                } elseif (!$evento->setEvento($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del evento incorrecto';
                } elseif (!$evento->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripcion no valida';
                } elseif (!$evento->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion del evento no valido';
                } elseif (!isset($_POST['tipo'])) {
                    $result['exception'] = 'Seleccione una categoria para el evento';
                } elseif (!$evento->setTipoEvento($_POST['evento'])) {
                    $result['exception'] = 'Categoria no valida';
                } elseif (!$evento->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha no valida';
                } elseif (!$evento->setHoraCierre($_POST['horaC'])) {
                    $result['exception'] = 'Hora no valida';
                } elseif (!$evento->setHoraInicio($_POST['horaI'])) {
                    $result['exception'] = 'Hora no valida';
                }
                elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($evento->updateRow($data['imagen_sede'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Imagen modificada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$evento->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($evento->updateRow($data['imagen_sede'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $evento->getRuta(), $producto->getImagen())) {
                        $result['message'] = 'Evento actualizado correctamente';
                    } else {
                        $result['message'] = 'No fue posible actualizar la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$evento->setId($_POST['id'])) {
                    $result['exception'] = 'Evento no valido';
                }elseif (!$data = $evento->readOne()) {
                    $result['exception'] = 'Hubó un error al tratar de leer el evento';
                }  elseif ($evento->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($evento->getRuta(), $data['imagen'])) {
                        $result['message'] = 'Evento descartado de forma satisfactoría';
                    } else {
                        $result['message'] = 'Ocurrió un problema al tratar de descartar el evento';
                    }
                } else {
                    $result['exception'] = Database::getException();
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