<?php
require_once('../entities/dto/usuario_crud.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Caso pra leer todos los registros de la tabla
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'La tabla cuenta con ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                case 'readTipo':
                    if ($result['dataset'] = $usuario->readTipo()) {
                        $result['status'] = 1;
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
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
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
                if (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del Usuario incorrecto';
                } elseif (!$usuario->setClave($_POST['Clave'])) {
                    $result['exception'] = 'Clave no valida';
                } elseif (!$usuario->setCorreo($_POST['correp'])) {
                    $result['exception'] = 'Correo no valida';
                } elseif (!$usuario->setTipo($_POST['tipo'])) {
                    $result['exception'] = 'Tipo de usuario no valido';
                } elseif (!$usuario->setIntentos($_POST['intentos'])) {
                    $result['exception'] = 'Intentos no validos';
                } elseif (!$usuario->setAcceso($_POST['acceso'])) {
                    $result['exception'] = 'Acceso no valida';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$usuario->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $usuario->getRuta(), $usuario->getImagen())) {
                        $result['message'] = 'Usuario creado correctamente';
                    } else {
                        $result['message'] = 'Usuario guardado, pero no se logró guardar la foto';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso para leer los datos de un unico registro
            case 'readOne':
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario no validO';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                // Caso para realizar la operacion de actualizar un registro 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario  no validU';
                } elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'Usuario no leído correctamente';
                } elseif (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del usuario incorrecto';
                }  elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecta';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo del usuario incorrecto';
                } elseif (!$usuario->setIntentos($_POST['intentos'])) {
                    $result['exception'] = 'Intentos no valido';
                } elseif (!$usuario->setAcceso($_POST['acceso'])) {
                    $result['exception'] = 'Acceso incorrecto';
                } elseif (!isset($_POST['tipo'])) {
                    $result['exception'] = 'Seleccione un tipo de usuario';
                } elseif (!$usuario->setTipo($_POST['tipo'])) {
                    $result['exception'] = 'Tipo de usuario no valido';
                } 
                elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($usuario->updateRow($data['imagen'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario actualizado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$usuario->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($usuario->updateRow($data['imagen'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $usuario->getRuta(), $usuario->getImagen())) {
                        $result['message'] = 'Usuario actualizado correctamente';
                    } else {
                        $result['message'] = 'No fue posible actualizar la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Caso pra eliminar un registro 
            case 'delete':
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario no valido';
                }elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'Hubó un error al tratar de leer el usuario';
                }  elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($usuario->getRuta(), $data['imagen'])) {
                        $result['message'] = 'Usuario descartado de forma satisfactoría';
                    } else {
                        $result['message'] = 'Ocurrió un problema al tratar de descartar el usuario';
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