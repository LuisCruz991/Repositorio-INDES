<?php
require_once('../entities/dto/unidades_medida.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $unidades = new Unidades;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idusuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $unidades->readAll()) {
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
                } elseif ($result['dataset'] = $unidades->searchRows($_POST['search'])) {
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
                if (!$unidades->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                }  elseif ($unidades->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Unidad de medida creada correctamente';
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$unidades->setId($_POST['idunidad_medida'])) {
                    $result['exception'] = 'Unidad incorrecta';
                } elseif ($result['dataset'] = $unidades->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Unidad inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$unidades->setId($_POST['id'])) {
                    $result['exception'] = 'Unidad incorrecta';
                } elseif (!$data = $unidades->readOne()) {
                    $result['exception'] = 'Unidad inexistente';
                } elseif (!$unidades->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Unidad incorrecta';
                }  elseif ($unidades->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Unidad de medida modificada correctamente';
                }else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$unidades->setId($_POST['idunidad_medida'])) {
                    $result['exception'] = 'Unidad incorrecta';
                } elseif (!$unidades->readOne()) {
                    $result['exception'] = 'Unidad inexistente';
                } elseif ($unidades->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Unidad de medida eliminada correctamente';
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
