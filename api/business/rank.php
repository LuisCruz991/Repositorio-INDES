<?php
require_once('../entities/dao/ranking_queries.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $rank = new rankqueries;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso para leer las modalidades deportivas en base al deporte
            case 'readModalidad':
                if ($result['dataset'] = $rank->readModaliad($_POST['filtro'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer las modalidadas deportivas';
                }
                break;
            // Accion para obtener el atleta numero uno del ranking
            case 'readN1':
                if ($result['dataset'] = $rank->firstPlace($_POST['deporte'], $_POST['modalidad'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = '';
                }
                break;
            // Accion para obtener el segundo mejor atleta del ranking
            case 'readN2':
                if ($result['dataset'] = $rank->secondfPlace($_POST['deporte'], $_POST['modalidad'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = '';
                }
                break;
            // Accion para obtener el tercer mejor atleta del ranking
            case 'readN3':
                if ($result['dataset'] = $rank->thirdPlace($_POST['deporte'], $_POST['modalidad'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = '';
                }
                break;
            // Metodo para obtner a todos los atletas que no pertenecen al podio 
            case 'readRest':
                if ($result['dataset'] = $rank->rest($_POST['deporte'], $_POST['modalidad'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = '';
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