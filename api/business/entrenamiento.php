<?php
require_once('../entities/dto/entrenamiento.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $entrenamiento = new Entrenamiento;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso pra leer todos los registros de la tabla
            case 'readAll':
                if ($result['dataset'] = $entrenamiento->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'La tabla cuenta con ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // Caso para usar el buscador 
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $entrenamiento->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                // Caso para realizar la insercion de datos
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$entrenamiento->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha no valida';
                } elseif (!$entrenamiento->setHoraInicio($_POST['horaI'])) {
                    $result['exception'] = 'Hora no valida';
                } elseif (!$entrenamiento->setHoraCierre($_POST['horaC'])) {
                    $result['exception'] = 'Hora no valida';
                } elseif (!$entrenamiento->setLugar($_POST['lugar'])) {
                    $result['exception'] = 'Lugar del entrenamiento no valido';
                } elseif (!isset($_POST['atleta'])) {
                    $result['exception'] = 'Seleccione un atleta';
                } elseif (!$entrenamiento->setAtleta($_POST['atleta'])) {
                    $result['exception'] = 'Atleta no valido';
                }elseif (!isset($_POST['entrenador'])) {
                    $result['exception'] = 'Seleccione un entrenador';
                } elseif (!$entrenamiento->setEntrenador($_POST['entrenador'])) {
                    $result['exception'] = 'Entrenador no valido';
                } elseif (!isset($_POST['entrenador'])) {
                    $result['exception'] = 'Seleccione un resumen';
                } elseif (!$entrenamiento->setResumen($_POST['resumen'])) {
                    $result['exception'] = 'Resumen no valido';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para leer los datos de un unico registro
            case 'readOne':
                if (!$entrenamiento->setId($_POST['id'])) {
                    $result['exception'] = 'Entrenamiento no valido';
                } elseif ($result['dataset'] = $entrenamiento->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Entrenamiento inexistente';
                }
                break;
                // Caso para realizar la operacion de actualizar un registro 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$entrenamiento->setId($_POST['id'])) {
                    $result['exception'] = 'Entrenamiento no valido';
                } elseif (!$data = $entrenamiento->readOne()) {
                    $result['exception'] = 'Entrenamiento no leído correctamente';
                } elseif (!$entrenamiento->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha no valida';
                } elseif (!$entrenamiento->setHoraInicio($_POST['horaI'])) {
                    $result['exception'] = 'Hora no valida';
                } elseif (!$entrenamiento->setHoraCierre($_POST['horaC'])) {
                    $result['exception'] = 'Hora no valida';
                } elseif (!$entrenamiento->setLugar($_POST['lugar'])) {
                    $result['exception'] = 'Lugar del entrenamiento no valido';
                } elseif (!isset($_POST['atleta'])) {
                    $result['exception'] = 'Seleccione un atleta';
                } elseif (!$entrenamiento->setAtleta($_POST['atleta'])) {
                    $result['exception'] = 'Atleta no valido';
                } elseif (!isset($_POST['entrenador'])) {
                    $result['exception'] = 'Seleccione un entrenador';
                } elseif (!$entrenamiento->setEntrenador($_POST['entrenador'])) {
                    $result['exception'] = 'Entrenador no valido';
                } elseif (!isset($_POST['resumen'])) {
                    $result['exception'] = 'Seleccione un resumen';
                } elseif (!$entrenamiento->setResumen($_POST['resumen'])) {
                    $result['exception'] = 'Resumen no valido';
                }  else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso pra eliminar un registro 
                case 'delete':
                    if (!$entrenamiento->setId($_POST['identrenamiento'])) {
                        $result['exception'] = 'Entrenamiento invalido';
                    } elseif (!$data = $entrenamiento->readOne()) {
                        $result['exception'] = 'Ocurrió un problema al leer el entrenamiento';
                    } elseif ($entrenamiento->deleteRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Entrenamiento descartado exitosamente';
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