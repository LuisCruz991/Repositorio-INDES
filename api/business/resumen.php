<?php
require_once('../entities/dto/resumen.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $resumen = new Resumen;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if ((isset($_SESSION['idadministrador']))) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $resumen->readAll()) {
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
                } elseif ($result['dataset'] = $resumen->searchRows($_POST['search'])) {
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
                if (!$resumen->setHorasP($_POST['horasP'])) {
                    $result['exception'] = 'Horas Planificada no valida';
                } elseif (!$resumen->setHorasE($_POST['horasE'])) {
                    $result['exception'] = 'Horas Entrenadas no válida';
                }  elseif (!$resumen->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha no válida';
                } elseif ($resumen->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Resumen de Entrenamiento creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                    ;
                }
                break;
            case 'readOne':
                if (!$resumen->setId($_POST['id'])) {
                    $result['exception'] = 'Resumen no validO';
                } elseif ($result['dataset'] = $resumen->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el Resumen';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$resumen->setId($_POST['id'])) {
                    $result['exception'] = 'Continente incorrecto';
                } elseif (!$data = $resumen->readOne()) {
                    $result['exception'] = 'Continente inexistente';
                } elseif (!$resumen->setHorasP($_POST['horasP'])) {
                    $result['exception'] = 'Horas Planificadas invalidas';
                } elseif (!$resumen->setHorasE($_POST['horasE'])) {
                    $result['exception'] = 'Horas Entrenadas invalidas';
                } elseif (!$resumen->setFinalizado($_POST['finalizado'])) {
                    $result['exception'] = 'Finalizado incorrecto';
                } elseif (!$resumen->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha no valida';
                } elseif ($resumen->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Resumen modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$resumen->setId($_POST['id'])) {
                    $result['exception'] = 'Resumen incorrecto';
                } elseif (!$resumen->readOne()) {
                    $result['exception'] = 'Resumen inexistente';
                } elseif ($resumen->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Resumen eliminado correctamente';
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