<?php
require_once('../entities/dto/entrenador.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $entrenador = new Entrenador;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readGenero':
                if ($result['dataset'] = $entrenador->readGenero()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                case 'readFederacion':
                    if ($result['dataset'] = $entrenador->readFederacion()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
            case 'readAll':
                if ($result['dataset'] = $entrenador->readAll()) {
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
                } elseif ($result['dataset'] = $entrenador->searchRows($_POST['search'])) {
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
                if (!$entrenador->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del entrenador no valido';
                }  elseif (!$entrenador->setApellido($_POST['apellido'])) {
                    $result['exception'] = 'Apellido del entrenador no valido';
                }  elseif (!$entrenador->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono del entrenador no valido';
                }elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione un genero';
                } elseif (!$entrenador->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero no valida';
                }  elseif (!$entrenador->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion del entrenador no valido';
                } elseif (!$entrenador->setDUI($_POST['dui'])) {
                    $result['exception'] = 'Dui del entrenador no valido';
                }  elseif (!$entrenador->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo del entrenador no valido';
                }elseif (!isset($_POST['f'])) {
                    $result['exception'] = 'Seleccione una federacion';
                } elseif (!$entrenador->setFederacion($_POST['f'])) {
                    $result['exception'] = 'Federacion no valida';
                } elseif ($entrenador->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Entrenador guardado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$entrenador->setId($_POST['identrenador'])) {
                    $result['exception'] = 'entrenador invalido';
                } elseif ($result['dataset'] = $entrenador->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el entrenador';
                }
                break;
                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$entrenador->setId($_POST['id'])) {
                        $result['exception'] = 'Deporte invalido';
                    } elseif (!$data = $entrenador->readOne()) {
                        $result['exception'] = 'Ocurrió un problema al leer el deporte';
                    } elseif (!$entrenador->setNombre($_POST['nombre'])) {
                        $result['exception'] = 'Nombre del entrenador no valido';
                    }  elseif (!$entrenador->setApellido($_POST['apellido'])) {
                        $result['exception'] = 'Apellido del entrenador no valido';
                    }  elseif (!$entrenador->setTelefono($_POST['telefono'])) {
                        $result['exception'] = 'telefono del entrenador no valido';
                    }elseif (!isset($_POST['genero'])) {
                        $result['exception'] = 'Seleccione un genero';
                    } elseif (!$entrenador->setGenero($_POST['genero'])) {
                        $result['exception'] = 'Genero no valida';
                    }  elseif (!$entrenador->setDireccion($_POST['direccion'])) {
                        $result['exception'] = 'Direccion del entrenador no valido';
                    } elseif (!$entrenador->setDUI($_POST['dui'])) {
                        $result['exception'] = 'Dui del entrenador no valido';
                    }  elseif (!$entrenador->setCorreo($_POST['correo'])) {
                        $result['exception'] = 'Correo del entrenador no valido';
                    }  elseif (!$entrenador->setFederacion($_POST['f'])) {
                        $result['exception'] = 'Federacion no valida';
                    } elseif ($entrenador->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Entrenador actualizado exitosamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                    case 'delete':
                        if (!$entrenador->setId($_POST['identrenador'])) {
                            $result['exception'] = 'entrenador invalido';
                        } elseif (!$data = $entrenador->readOne()) {
                            $result['exception'] = 'Ocurrió un problema al leer el entrenador';
                        } elseif ($entrenador->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'entrenador descartado exitosamente';
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