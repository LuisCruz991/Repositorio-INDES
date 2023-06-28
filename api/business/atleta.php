<?php
require_once('../entities/dto/atleta.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $atleta = new Atleta;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $atleta->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                case 'readGenero':
                    if ($result['dataset'] = $atleta->readGenero()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
                    case 'readEntrenador':
                        if ($result['dataset'] = $atleta->readEntrenador()) {
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
                } elseif ($result['dataset'] = $atleta->searchRows($_POST['search'])) {
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
                if (!$atleta->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del atleta no valido';
                }  elseif (!$atleta->setApellido($_POST['apellido'])) {
                    $result['exception'] = 'Apellido del atleta no valido';
                } elseif (!$atleta->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Nacimiento del atleta no valido';
                }elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione un genero';
                } elseif (!$atleta->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero no valida';
                }  elseif (!$atleta->setEstatura($_POST['estatura'])) {
                    $result['exception'] = 'Estatura del atleta no valido';
                } elseif (!$atleta->setPeso($_POST['peso'])) {
                    $result['exception'] = 'Peso del atleta no valido';
                } elseif (!$atleta->setCamisa($_POST['camisa'])) {
                    $result['exception'] = 'Camisa del atleta no valido';
                } elseif (!$atleta->setShort($_POST['short'])) {
                    $result['exception'] = 'Short del atleta no valido';
                } elseif (!$atleta->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion del atleta no valido';
                } elseif (!$atleta->setDUI($_POST['dui'])) {
                    $result['exception'] = 'Dui del atleta no valido';
                } elseif (!$atleta->setCelular($_POST['celular'])) {
                    $result['exception'] = 'Celular del atleta no valido';
                } elseif (!$atleta->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono del atleta no valido';
                } elseif (!$atleta->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo del atleta no valido';
                }elseif (!isset($_POST['nombre_madre'])) {
                    $result['exception'] = 'Seleccione un responsable';
                } elseif (!$atleta->setNombreMadre($_POST['nombre_madre'])) {
                    $result['exception'] = 'Responsable no valida';
                }  elseif (!isset($_POST['deporte'])) {
                    $result['exception'] = 'Seleccione el deporte';
                } elseif (!$atleta->setDeporte($_POST['deporte'])) {
                    $result['exception'] = 'Deporte no valida';
                } elseif (!isset($_POST['entrenador'])) {
                    $result['exception'] = 'Seleccione el entrenador';
                } elseif (!$atleta->setEntrenador($_POST['entrenador'])) {
                    $result['exception'] = 'Entrenador no valida';
                } elseif (!$atleta->setClave($_POST['clave'])) {
                    $result['exception'] = 'Clave del atleta no valido';
                }  elseif ($atleta->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Deporte guardado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif ($result['dataset'] = $atleta->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                }
                break;
                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$deporte->setId($_POST['id'])) {
                        $result['exception'] = 'Deporte invalido';
                    } elseif (!$data = $deporte->readOne()) {
                        $result['exception'] = 'Ocurrió un problema al leer el deporte';
                    } elseif (!$deporte->setDeporte($_POST['deporte'])) {
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
                    case 'delete':
                        if (!$atleta->setId($_POST['idatleta'])) {
                            $result['exception'] = 'Atleta invalido';
                        } elseif (!$data = $atleta->readOne()) {
                            $result['exception'] = 'Ocurrió un problema al leer el atleta';
                        } elseif ($atleta->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Atleta descartado exitosamente';
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