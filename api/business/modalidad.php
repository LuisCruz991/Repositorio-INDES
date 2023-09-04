<?php
require_once('../entities/dto/modalidad.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $modalidad = new modalidad;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso para cargar los datos de la base en la tabla
            case 'readAll':
                if ($result['dataset'] = $modalidad->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // Caso para buscar por medio de la modalidad deportiva
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $modalidad->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                // Caso pra ingresar datos
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$modalidad->setModalidad($_POST['nombre'])) {
                    $result['exception'] = 'Modalidad deportiva no valida';
                } elseif ($modalidad->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modalidad deportiva guardada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para leer un registro 
            case 'readOne':
                if (!$modalidad->setId($_POST['id'])) {
                    $result['exception'] = 'Modalidad no invalida';
                } elseif ($result['dataset'] = $modalidad->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer la modalidad';
                }
                break;
                // Caso para actualizar los datos de un registro 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$modalidad->setId($_POST['id'])) {
                    $result['exception'] = 'Modalidad invalida';
                } elseif (!$data = $modalidad->readOne()) {
                    $result['exception'] = 'Ocurrió un problema al leer la modalidad';
                }elseif (!$modalidad->setModalidad($_POST['nombre'])) {
                    $result['exception'] = 'nombre de la modalidad invalida';
                } elseif ($modalidad->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modalidad actualizada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para eliminer registros 
            case 'delete':
                if (!$modalidad->setId($_POST['id'])) {
                    $result['exception'] = 'Modalidad invalida';
                } elseif (!$data = $modalidad->readOne()) {
                    $result['exception'] = 'Ocurrió un problema al leer la modalidad';
                } elseif ($modalidad->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modalidad descartada exitosamente';
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