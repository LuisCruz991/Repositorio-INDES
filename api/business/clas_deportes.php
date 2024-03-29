<?php
require_once('../entities/dto/clas_deportes.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $clasificacion = new Clasificacion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if ((isset($_SESSION['idadministrador'])) ){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $clasificacion->readAll()) {
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
                } elseif ($result['dataset'] = $clasificacion->searchRows($_POST['search'])) {
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
                if (!$clasificacion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                }  elseif ($clasificacion->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Clasificacion creada correctamente';
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$clasificacion->setId($_POST['idclasificacion_deporte'])) {
                    $result['exception'] = 'Clasificacion incorrecta';
                } elseif ($result['dataset'] = $clasificacion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Clasificacion inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$clasificacion->setId($_POST['id'])) {
                    $result['exception'] = 'Clasificacion incorrecta';
                } elseif (!$data = $clasificacion->readOne()) {
                    $result['exception'] = 'Clasificacion inexistente';
                } elseif (!$clasificacion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Clasificacion incorrecta';
                }  elseif ($clasificacion->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Clasificacion modificada correctamente';
                }else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$clasificacion->setId($_POST['idclasificacion_deporte'])) {
                    $result['exception'] = 'Clasificacion incorrecta';
                } elseif (!$clasificacion->readOne()) {
                    $result['exception'] = 'Clasificacion inexistente';
                } elseif ($clasificacion->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Clasificacion eliminada correctamente';
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
