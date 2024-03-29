<?php
require_once('../entities/dto/tipo_event.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tipo = new TipoEvento;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if ((isset($_SESSION['idadministrador'])) ){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $tipo->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'La tabla cuenta con ' . count($result['dataset']) . ' registros';
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
                } elseif ($result['dataset'] = $tipo->searchRows($_POST['search'])) {
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
                if (!$tipo->setNombre($_POST['tipo_evento'])) {
                    $result['exception'] = 'Nombre de unidad no valido';
                }  elseif ($tipo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de Evento guardado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$tipo->setId($_POST['idtipo_evento'])) {
                    $result['exception'] = 'tipo invalida';
                } elseif ($result['dataset'] = $tipo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el tipo';
                }
                break;
                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$tipo->setId($_POST['id'])) {
                        $result['exception'] = 'tipo invalido';
                    } elseif (!$data = $tipo->readOne()) {
                        $result['exception'] = 'Ocurrió un problema al leer el tipo';
                    } elseif (!$tipo->setNombre($_POST['tipo_evento'])) {
                        $result['exception'] = 'Nombre del tipo no valido';
                    }  elseif ($tipo->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Tipo actualizado exitosamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                    case 'delete':
                        if (!$tipo->setId($_POST['idtipo_evento'])) {
                            $result['exception'] = 'tipo invalido';
                        } elseif (!$data = $tipo->readOne()) {
                            $result['exception'] = 'Ocurrió un problema al leer el tipo';
                        } elseif ($tipo->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Tipo descartada exitosamente';
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