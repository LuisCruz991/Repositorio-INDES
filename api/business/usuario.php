<?php
require_once('../entities/dto/usuario.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['nombre_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['nombre_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'TiempoInactividad':
                if (Validator::ValidarTiempo()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión activa';
                } else {
                    $result['exception'] = 'Su sesión ha expirado, ingrese nuevamente';
                }
                break;
                case 'readProfile':
                    if ($result['dataset'] = $usuario->readProfile()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                    }
                    break;
            case 'cambiarClave':
                $_POST = Validator::validateForm($_POST);
              if (!$usuario->checkPassword2($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['usuario'] == $_POST['confirmar']) {
                    $result['exception'] = 'Eliga una clave mas segura';
                }elseif ($_POST['correo'] == $_POST['confirmar']) {
                    $result['exception'] = 'Eliga una clave mas segura';
                } elseif (!preg_match('/[^a-zA-Z\d]/', $_POST['confirmar'])) {
                    $result['exception'] = 'La clave debe contener al menos un carácter especial';
                }elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$usuario->setClave($_POST['nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->cambiarClave()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
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
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
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
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
            // Metodo para ingresar el primer usuario 
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                $existingUsers = $usuario->readAll();
                if (count($existingUsers) > 0) {
                    $result['exception'] = 'No es posible ingresar un usuario nuevo por este medio';
                } else {
                    if (!$usuario->setCorreo($_POST['correo'])) {
                        $result['exception'] = 'Correo incorrecto';
                    } elseif (!$usuario->setAlias($_POST['usuario'])) {
                        $result['exception'] = 'Alias incorrecto';
                    } elseif ($_POST['codigo'] != $_POST['confirmar']) {
                        $result['exception'] = 'Claves diferentes';
                    }elseif ($_POST['usuario'] == $_POST['confirmar']) {
                        $result['exception'] = 'Eliga una clave mas segura';
                    }elseif ($_POST['correo'] == $_POST['confirmar']) {
                        $result['exception'] = 'Eliga una clave mas segura';
                    } elseif (!preg_match('/[^a-zA-Z\d]/', $_POST['confirmar'])) {
                        $result['exception'] = 'La clave debe contener al menos un carácter especial';
                    } elseif (!$usuario->setClave($_POST['codigo'])) {
                        $result['exception'] = Validator::getPasswordError();
                    } elseif ($usuario->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario registrado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                }
                break;
            // Codigo para el caso del login
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['nombres'])) {
                    $result['exception'] = 'Credenciales incorrectas';
                } elseif ($usuario->getAcceso() == 0) {
                    $result['exception'] = 'El usuario se encuentra bloqueado, comuniquese con un administrador.';
                } elseif ($usuario->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $_SESSION['idadministrador'] = $usuario->getId();
                    $_SESSION['nombre_usuario'] = $usuario->getNombre();
                    // Inicio de sesión correcto, los intentos registrados en la base se resetean a 0.
                    if ($usuario->resetearIntentos()) {
                        $result['exception'] = 'Autenticación correcta';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    if ($usuario->getIntentos() < 2) {
                        if ($usuario->actualizarIntentos()) {
                            $result['exception'] = 'Credenciales incorrectas.';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        if ($usuario->bloquearUsuario()) {
                            $result['exception'] = 'Excedio el número de intentos para iniciar sesión, el usuario ha sido bloqueado.';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    }
                    $result['exception'] = 'Credenciales incorrectas';
                }
                break;
            // Caso del cambio de contraseña por medio de la recuperación
            case 'recuPassword':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setAlias($_POST['nombre'])) {
                    $result['exception'] = 'Usuario no leido correctamente';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Las claves no coinciden';
                } elseif (!preg_match('/[^a-zA-Z\d]/', $_POST['confirmar'])) {
                    $result['exception'] = 'La clave debe contener al menos un carácter especial';
                } elseif (!$usuario->setClave($_POST['confirmar'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->recuPassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada de forma exitosa';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}