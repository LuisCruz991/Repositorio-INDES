<?php
require_once('../entities/dto/parentesco.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $parentesco = new parentesco;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso para cargar los datos de la base en la tabla
            case 'readAll':
                if ($result['dataset'] = $parentesco->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // Caso para buscar por medio del parentesco 
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $parentesco->searchRows($_POST['search'])) {
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
                if (!$parentesco->setParentesco($_POST['nombre'])) {
                    $result['exception'] = 'Parentesco no valida';
                } elseif ($parentesco->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Parentesco guardada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para leer un registro 
            case 'readOne':
                if (!$parentesco->setId($_POST['id'])) {
                    $result['exception'] = 'Parentesco no invalido';
                } elseif ($result['dataset'] = $parentesco->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el parentesco';
                }
                break;
                // Caso para actualizar los datos de un registro 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$parentesco->setId($_POST['id'])) {
                    $result['exception'] = 'Parentesco invalida';
                } elseif (!$data = $parentesco->readOne()) {
                    $result['exception'] = 'Ocurrió un problema al leer el parentesco';
                }elseif (!$parentesco->setParentesco($_POST['nombre'])) {
                    $result['exception'] = 'nombre del parentesco invalida';
                } elseif ($parentesco->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Parentesco actualizada exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para eliminer registros 
            case 'delete':
                if (!$parentesco->setId($_POST['id'])) {
                    $result['exception'] = 'Parentesco invalida';
                } elseif (!$data = $parentesco->readOne()) {
                    $result['exception'] = 'Ocurrió un problema al leer el parentesco';
                } elseif ($parentesco->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Parentesco descartada exitosamente';
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