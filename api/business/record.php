<?php
require_once('../entities/dto/records.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $record = new Record;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if ((isset($_SESSION['idadministrador'])) ){
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $record->readAll()) {
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
                } elseif ($result['dataset'] = $record->searchRows($_POST['search'])) {
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
                if (!$record->setMarcaObtenida($_POST['marca_obtenida'])) {
                    $result['exception'] = 'Marca incorrecta';
                }  elseif (!$record->setUnidadMedida($_POST['unidad_medida'])) {
                    $result['exception'] = 'Unidad de medida incorrecta';
                }  elseif (!$record->setAtleta($_POST['atleta'])) {
                    $result['exception'] = 'Atleta incorrecto';
                }   elseif (!$record->setPrueba($_POST['prueba'])) {
                    $result['exception'] = 'Prueba incorrecta';
                }  elseif (!$record->setPosicion($_POST['posicion'])) {
                    $result['exception'] = 'Posicion incorrecta';
                }  elseif ($record->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Record creado correctamente';
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$record->setId($_POST['id'])) {
                    $result['exception'] = 'Record incorrecto';
                } elseif ($result['dataset'] = $record->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Record inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$record->setId($_POST['id'])) {
                    $result['exception'] = 'Record incorrecto';
                } elseif (!$data = $record->readOne()) {
                    $result['exception'] = 'Record inexistente';
                } elseif (!$record->setMarcaObtenida($_POST['marca_obtenida'])) {
                    $result['exception'] = 'Marca incorrecta';
                }  elseif ($record->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Record modificado correctamente';
                }else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$record->setId($_POST['idrecord'])) {
                    $result['exception'] = 'Record incorrecto';
                } elseif (!$record->readOne()) {
                    $result['exception'] = 'Record inexistente';
                } elseif ($record->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Record eliminado correctamente';
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
