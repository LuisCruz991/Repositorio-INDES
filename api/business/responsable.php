<?php
require_once('../entities/dto/responsables.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $responsable = new Responsable;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $responsable->readAll()) {
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
                } elseif ($result['dataset'] = $responsable->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$responsable->setNombreMadre($_POST['nombre_madre'])) {
                    $result['exception'] = 'Nombre de la madre incorrecto';
                }  elseif (!$responsable->setDireccionMadre($_POST['direccion_madre'])) {
                    $result['exception'] = 'Direccion incorrecta';
                }  elseif (!$responsable->setTelefonoMadre($_POST['telefono_madre'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }  elseif (!$responsable->setNombrePadre($_POST['nombre_padre'])) {
                    $result['exception'] = 'Nombre del padre incorrecto';
                }  elseif (!$responsable->setDireccionPadre($_POST['direccion_padre'])) {
                    $result['exception'] = 'Direccion incorrecta';
                }  elseif (!$responsable->setTelefonoPadre($_POST['telefono_padre'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }  elseif ($responsable->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Responsable agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$responsable->setId($_POST['id'])) {
                    $result['exception'] = 'Responsable incorrecto';
                } elseif ($result['dataset'] = $responsable->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Responsable inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$responsable->setId($_POST['id'])) {
                    $result['exception'] = 'Prueba incorrecta';
                } elseif (!$data = $responsable->readOne()) {
                    $result['exception'] = 'Prueba inexistente';
                } elseif (!$responsable->setNombreMadre($_POST['nombre_madre'])) {
                    $result['exception'] = 'Nombre de la madre incorrecto';
                } elseif (!$responsable->setDireccionMadre($_POST['direccion_madre'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif (!$responsable->setTelefonoMadre($_POST['telefono_madre'])) {
                    $result['exception'] = 'Telefono incorrecito';
                } elseif (!$responsable->setNombrePadre($_POST['nombre_padre'])) {
                    $result['exception'] = 'Nombre del padre incorrecto';
                } elseif (!$responsable->setDireccionPadre($_POST['direccion_padre'])) {
                    $result['exception'] = 'Nombre de la madre incorrecto';
                } elseif (!$responsable->setTelefonoPadre($_POST['telefono_padre'])) {
                    $result['exception'] = 'Telefono incorrecto';
                } elseif ($responsable->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Responsables modificados correctamente';
                }else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$responsable->setId($_POST['idresponsable'])) {
                    $result['exception'] = 'Responsable incorrecto';
                } elseif (!$responsable->readOne()) {
                    $result['exception'] = 'Responsable inexistente';
                } elseif ($responsable->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Responsables eliminados correctamente';
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
