<?php
require_once('../entities/dto/pais.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pais = new Pais;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso pra leer todos los registros de la tabla
            case 'readAll':
                if ($result['dataset'] = $pais->readAll()) {
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
                } elseif ($result['dataset'] = $pais->searchRows($_POST['search'])) {
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
                if (!$pais->setPais($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del Pais incorrecto';
                } elseif (!$pais->setContinente($_POST['continente'])) {
                    $result['exception'] = 'Descripcion no valida';
                }  elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$pais->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($pais->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $pais->getRuta(), $pais->getBandera())) {
                        $result['message'] = 'Pais creado correctamente';
                    } else {
                        $result['message'] = 'Pais guardado, pero no se logró guardar la foto de la sede';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para leer los datos de un unico registro
            case 'readOne':
                if (!$pais->setId($_POST['id'])) {
                    $result['exception'] = 'Pais no valido';
                } elseif ($result['dataset'] = $pais->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Pais inexistente';
                }
                break;
                // Caso para realizar la operacion de actualizar un registro 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$pais->setId($_POST['id'])) {
                    $result['exception'] = 'Pais no valido';
                } elseif (!$data = $pais->readOne()) {
                    $result['exception'] = 'Pais no leído correctamente';
                } elseif (!$pais->setPais($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del pais incorrecto';
                }  elseif (!isset($_POST['continente'])) {
                    $result['exception'] = 'Seleccione un continente para el pais';
                } elseif (!$pais->setContinente($_POST['continente'])) {
                    $result['exception'] = 'Continente no valida';
                } 
                elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($pais->updateRow($data['bandera'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Pais actualizado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$pais->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($pais->updateRow($data['bandera'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $pais->getRuta(), $pais->getBandera())) {
                        $result['message'] = 'Pais actualizado correctamente';
                    } else {
                        $result['message'] = 'No fue posible actualizar la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso pra eliminar un registro 
            case 'delete':
                if (!$pais->setId($_POST['id'])) {
                    $result['exception'] = 'Pais no valido';
                }elseif (!$data = $pais->readOne()) {
                    $result['exception'] = 'Hubó un error al tratar de leer el pais';
                }  elseif ($pais->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($pais->getRuta(), $data['bandera'])) {
                        $result['message'] = 'Pais descartado de forma satisfactoría';
                    } else {
                        $result['message'] = 'Ocurrió un problema al tratar de descartar el pais';
                    }
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