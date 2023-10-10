<?php
require_once('../entities/dto/atleta.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $atleta = new Atleta;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $atleta->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'La tabla cuenta con ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readGenero':
                if ($result['dataset'] = $atleta->readGenero()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readEntrenador':
                if ($result['dataset'] = $atleta->readEntrenador()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Consulta la cantidad de atletas que pertenecen a un genero
            case 'cantidadAtletasGenero':
                if (
                    $result['dataset'] = $atleta->cantidadAtletasGenero
                    ()
                ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $atleta->searchRows($_POST['search'])) {
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
                if (!$atleta->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del atleta no valido';
                } elseif (!$atleta->setApellido($_POST['apellido'])) {
                    $result['exception'] = 'Apellido del atleta no valido';
                } elseif (!$atleta->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Nacimiento del atleta no valido';
                } elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione un genero';
                } elseif (!$atleta->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero no valida';
                } elseif (!$atleta->setEstatura($_POST['estatura'])) {
                    $result['exception'] = 'Estatura del atleta no valido';
                } elseif (!$atleta->setPeso($_POST['peso'])) {
                    $result['exception'] = 'Peso del atleta no valido';
                } elseif (!$atleta->setCamisa($_POST['camisa'])) {
                    $result['exception'] = 'Camisa del atleta no valido';
                } elseif (!$atleta->setShort($_POST['short'])) {
                    $result['exception'] = 'Short del atleta no valido';
                } elseif (!$atleta->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion del atleta no valido';
                } elseif (!$atleta->setDUI($_POST['dui'])) {
                    $result['exception'] = 'Dui del atleta no valido';
                }  elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$atleta->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$atleta->setCelular($_POST['celular'])) {
                    $result['exception'] = 'Celular del atleta no valido';
                } elseif (!$atleta->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono del atleta no valido';
                } elseif (!$atleta->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo del atleta no valido';
                }  elseif (!is_uploaded_file($_FILES['archivo2']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$atleta->setPasaporte($_FILES['archivo2'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!isset($_POST['responsable'])) {
                    $result['exception'] = 'Seleccione un responsable';
                } elseif (!$atleta->setResponsable($_POST['responsable'])) {
                    $result['exception'] = 'Responsable no valida';
                } elseif (!isset($_POST['federacion'])) {
                    $result['exception'] = 'Seleccione la federacion';
                } elseif (!$atleta->setFederacion($_POST['federacion'])) {
                    $result['exception'] = 'Federacion no valida';
                } elseif (!isset($_POST['entrenador'])) {
                    $result['exception'] = 'Seleccione el entrenador';
                } elseif (!$atleta->setEntrenador($_POST['entrenador'])) {
                    $result['exception'] = 'Entrenador no valida';
                } elseif (!$atleta->setClave($_POST['clave'])) {
                    $result['exception'] = 'Clave del atleta no valido';
                } elseif ($atleta->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $atleta->getRuta(), $atleta->getFoto()) && Validator::saveFile($_FILES['archivo2'], $atleta->getRuta(), $atleta->getPasaporte()) ) {
                        $result['message'] = 'Atleta creado correctamente';
                    } else {
                        $result['message'] = 'Atleta guardado, pero no se logró guardar la foto del dui';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif ($result['dataset'] = $atleta->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$atleta->setId($_POST['id'])) {
                    $result['exception'] = 'Atleta no valido';
                } elseif (!$data = $atleta->readOne()) {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                } elseif (!$atleta->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del atleta no valido';
                } elseif (!$atleta->setApellido($_POST['apellido'])) {
                    $result['exception'] = 'Apellido del atleta no valido';
                } elseif (!$atleta->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Nacimiento del atleta no valido';
                } elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione un genero';
                } elseif (!$atleta->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero no valida';
                } elseif (!$atleta->setEstatura($_POST['estatura'])) {
                    $result['exception'] = 'Estatura del atleta no valido';
                } elseif (!$atleta->setPeso($_POST['peso'])) {
                    $result['exception'] = 'Peso del atleta no valido';
                } elseif (!$atleta->setCamisa($_POST['camisa'])) {
                    $result['exception'] = 'Camisa del atleta no valido';
                } elseif (!$atleta->setShort($_POST['short'])) {
                    $result['exception'] = 'Short del atleta no valido';
                } elseif (!$atleta->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion del atleta no valido';
                } elseif (!$atleta->setDUI($_POST['dui'])) {
                    $result['exception'] = 'Dui del atleta no valido';
                }elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($atleta->updateRow($data['foto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Atleta actualizado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$atleta->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                }elseif (!is_uploaded_file($_FILES['archivo2']['tmp_name'])) {
                    if ($atleta->updateRow($data['pasaporte'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Atleta actualizado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$atleta->setPasaporte($_FILES['archivo2'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$atleta->setCelular($_POST['celular'])) {
                    $result['exception'] = 'Celular del atleta no valido';
                } elseif (!$atleta->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono del atleta no valido';
                } elseif (!$atleta->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo del atleta no valido';
                } elseif (!isset($_POST['responsable'])) {
                    $result['exception'] = 'Seleccione un responsable';
                } elseif (!$atleta->setResponsable($_POST['responsable'])) {
                    $result['exception'] = 'Responsable no valida';
                } elseif (!isset($_POST['federacion'])) {
                    $result['exception'] = 'Seleccione la federaccion';
                } elseif (!$atleta->setFederacion($_POST['federacion'])) {
                    $result['exception'] = 'Federacion no valida';
                } elseif (!isset($_POST['entrenador'])) {
                    $result['exception'] = 'Seleccione el entrenador';
                } elseif (!$atleta->setEntrenador($_POST['entrenador'])) {
                    $result['exception'] = 'Entrenador no valida';
                } elseif ($atleta->updateRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $atleta->getRuta(), $atleta->getFoto()) && Validator::saveFile($_FILES['archivo2'], $atleta->getRuta(), $atleta->getPasaporte()) ) {
                        $result['message'] = 'Atleta actualizado correctamente';
                    } else {
                        $result['message'] = 'Atleta guardado, pero no se logró guardar la foto del dui o la del pasaporte';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif (!$data = $atleta->readOne()) {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                } elseif ($atleta->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Atleta descartado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            // Evento para ejecutar la consulta de las horas cumplidas de un Atleta
            case 'horaAtleta':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif ($result['dataset'] = $atleta->horasAtleta()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                }
                break;
            case 'horaAtleta2':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif ($result['dataset'] = $atleta->horasAtleta2()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                }
                break;
            // Evento para ejecutar la consulta sobre los resultados de un atleta
            case 'resultadoAtleta':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif ($result['dataset'] = $atleta->resultadoAtleta()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                }
                break;
            // Evento para ejecutar la consulta para saber el presupuesto de un atleta
            case 'presupuestoAtleta':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif ($result['dataset'] = $atleta->presupuestoAtleta()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                }
                break;
            // Evento para ejecutar la consulta y obtener los datos de las marcas de un atleta
            case 'marcaAtleta':
                if (!$atleta->setId($_POST['idatleta'])) {
                    $result['exception'] = 'Atleta invalido';
                } elseif ($result['dataset'] = $atleta->atletaMarcas()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el atleta';
                }
            case 'numAtletas':
                if ($result['dataset'] = $atleta->atletasNum()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'atleta1':
                if ($result['dataset'] = $atleta->atletaN1()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'atleta2':
                if ($result['dataset'] = $atleta->atletaN2()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'atleta3':
                if ($result['dataset'] = $atleta->atletaN3()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
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