<?php
require_once('../entities/dto/admin.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $admin = new Admin;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $admin->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                case 'readGenero':
                    if ($result['dataset'] = $admin->readGenero()) {
                        $result['status'] = 1;
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
                } elseif ($result['dataset'] = $admin->searchRows($_POST['search'])) {
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
                if (!$admin->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del administrador no valido';
                }  elseif (!$admin->setClave($_POST['clave'])) {
                    $result['exception'] = 'Clave no valida';
                } elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione un genero';
                } elseif (!$admin->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero no valido';
                } 
                break;

            case 'readOne':
                if (!$admin->setId($_POST['idadministrador'])) {
                    $result['exception'] = 'Administrador invalido';
                } elseif ($result['dataset'] = $admin->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el administrador';
                }
                break;

                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$admin->setId($_POST['id'])) {
                        $result['exception'] = 'Administrador invalido';
                    } elseif (!$data = $admin->readOne()) {
                        $result['exception'] = 'Ocurrió un problema al leer el administrador';
                    } elseif (!$admin->setNombre($_POST['nombre'])) {
                        $result['exception'] = 'Nombre del administrador no valido';
                    }  elseif (!$admin->setClave($_POST['clave'])) {
                        $result['exception'] = 'Clave no valida';
                    } elseif (!isset($_POST['genero'])) {
                        $result['exception'] = 'Seleccione un genero';
                    } elseif (!$admin->setGenero($_POST['genero'])) {
                        $result['exception'] = 'Genero no valido';
                    }  
                    break;

                    case 'delete':
                        if (!$admin->setId($_POST['idadministrador'])) {
                            $result['exception'] = 'Administrador invalido';
                        } elseif (!$data = $admin->readOne()) {
                            $result['exception'] = 'Ocurrió un problema al leer el administrador';
                        } elseif ($admin->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Administrador descartado exitosamente';
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