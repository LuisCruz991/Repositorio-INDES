<?php
require_once('../entities/dto/deporte.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $deporte = new Deporte;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso para leer todos los campos de la tabla
            case 'readAll':
                if ($result['dataset'] = $deporte->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // Caso para buscar registros especificos
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $deporte->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                // Campo para realizar una insercion de datos
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$deporte->setDeporte($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del deporte no valido';
                } elseif (!isset($_POST['clasificacion'])) {
                    $result['exception'] = 'Seleccione la clasificación del deporte';
                } elseif (!$deporte->setClasificacion($_POST['clasificacion'])) {
                    $result['exception'] = 'Clasificacion no valida';
                }  elseif (!isset($_POST['modalidad'])) {
                    $result['exception'] = 'Seleccione la modalidad del deporte';
                } elseif (!$deporte->setModalidad($_POST['modalidad'])) {
                    $result['exception'] = 'Modalidad no valida';
                } elseif ($deporte->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Deporte guardado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para leer un campo especifico 
            case 'readOne':
                if (!$deporte->setId($_POST['id'])) {
                    $result['exception'] = 'Deporte invalido';
                } elseif ($result['dataset'] = $deporte->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el deporte';
                }
                break;
                // Caso para actualizar un registro 
                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$deporte->setId($_POST['id'])) {
                        $result['exception'] = 'Deporte invalido';
                    } elseif (!$data = $deporte->readOne()) {
                        $result['exception'] = 'Ocurrió un problema al leer el deporte';
                    } elseif (!$deporte->setDeporte($_POST['nombre'])) {
                        $result['exception'] = 'Nombre del deporte no valido';
                    } elseif (!$deporte->setClasificacion($_POST['clasificacion'])) {
                        $result['exception'] = 'Clasificacion no valida';
                    } elseif (!$deporte->setModalidad($_POST['modalidad'])) {
                        $result['exception'] = 'Modalidad deportiva no valida';
                    } elseif ($deporte->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Deporte actualizado exitosamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                    // Caso para llevar acabo una eliminación de datos
                    case 'delete':
                        if (!$deporte->setId($_POST['id'])) {
                            $result['exception'] = 'Deporte invalido';
                        } elseif (!$data = $deporte->readOne()) {
                            $result['exception'] = 'Ocurrió un problema al leer el deporte';
                        } elseif ($deporte->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Deporte descartado exitosamente';
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