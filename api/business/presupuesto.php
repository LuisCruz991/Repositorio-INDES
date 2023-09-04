<?php
require_once('../entities/dto/presupuesto.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $presupuesto = new Presupuesto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idadministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $presupuesto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'La tabla cuenta con ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                case 'readCategoria':
                    if ($result['dataset'] = $presupuesto->readCategoria()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;

                 case 'readAtleta':
                    if ($result['dataset'] = $presupuesto->readAtleta()) {
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
                } elseif ($result['dataset'] = $presupuesto->searchRows($_POST['search'])) {
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
                if (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoria';
                } elseif (!$presupuesto->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoria no valida';
                }elseif  (!$presupuesto->setEstimulos($_POST['estimulo'])) {
                    $result['exception'] = 'Estimulo no valido';
                }  elseif (!$presupuesto->setPreparacionFogues($_POST['preparacion'])) {
                    $result['exception'] = 'Preparacion Fogues no valido';
                } elseif (!$presupuesto->setAyudaExtranjera($_POST['ayuda'])) {
                    $result['exception'] = 'Ayuda Extranjera no valida';
                } elseif (!$presupuesto->setEquipamiento($_POST['equipamiento'])) {
                    $result['exception'] = 'Equipamiento no valido';
                } elseif (!$presupuesto->setOtros($_POST['otro'])) {
                    $result['exception'] = 'Otros no es valido';
                } elseif (!$presupuesto->setPatrocinadores($_POST['patrocinador'])) {
                    $result['exception'] = 'Patrocinador no valido';
                } elseif (!$presupuesto->setObservaciones($_POST['observacion'])) {
                    $result['exception'] = 'Observacion no valida';
                }elseif (!isset($_POST['atleta'])) {
                    $result['exception'] = 'Seleccione un atleta';
                } elseif (!$presupuesto->setAtleta($_POST['atleta'])) {
                    $result['exception'] = 'atleta no valido';
                }elseif ($presupuesto->createRow()) {
                $result['status'] = 1;
                $result['message'] = 'Presupuesto guardado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
                break;

            case 'readOne':
                if (!$presupuesto->setId($_POST['idpresupuesto'])) {
                    $result['exception'] = 'Presupuesto invalido';
                } elseif ($result['dataset'] = $presupuesto->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ocurrió un problema al leer el presupuesto';
                }
                break;

                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$presupuesto->setId($_POST['id'])) {
                        $result['exception'] = 'Presupuesto invalido';
                    } elseif (!$data = $presupuesto->readOne()) {
                        $result['exception'] = 'Ocurrió un problema al leer el presupuesto';
                    } elseif (!$presupuesto->setEstimulos($_POST['estimulo'])) {
                        $result['exception'] = 'Estimulos no valido';
                    }  elseif (!$presupuesto->setPreparacionFogues($_POST['preparacion'])) {
                        $result['exception'] = 'Preparacion Fogues no valida';
                    } elseif (!isset($_POST['categoria'])) {
                        $result['exception'] = 'Seleccione una categoria';
                    } elseif (!$presupuesto->setCategoria($_POST['categoria'])) {
                        $result['exception'] = 'Categoria no valida';
                    } elseif (!$presupuesto->setAyudaExtranjera($_POST['ayuda'])) {
                        $result['exception'] = 'Ayuda Extranjera no valida';
                    }  elseif (!$presupuesto->setEquipamiento($_POST['equipamiento'])) {
                        $result['exception'] = 'Equipamiento no valido';
                    } elseif (!$presupuesto->setOtros($_POST['otro'])) {
                        $result['exception'] = 'Otros no es valido';
                    } elseif (!$presupuesto->setPatrocinadores($_POST['patrocinador'])) {
                        $result['exception'] = 'Patrocinador no valido';
                    } elseif (!$presupuesto->setObservaciones($_POST['observacion'])) {
                        $result['exception'] = 'Observacion no valida';
                    }elseif (!isset($_POST['atleta'])) {
                        $result['exception'] = 'Seleccione un atleta';
                    } elseif (!$presupuesto->setAtleta($_POST['atleta'])) {
                        $result['exception'] = 'Atleta no valido';
                    }elseif ($presupuesto->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Presupuesto actualizado exitosamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;

                    case 'delete':
                        if (!$presupuesto->setId($_POST['idpresupuesto'])) {
                            $result['exception'] = 'Presupuesto invalido';
                        } elseif (!$data = $presupuesto->readOne()) {
                            $result['exception'] = 'Ocurrió un problema al leer el presupùesto';
                        } elseif ($presupuesto->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Presupuesto descartada exitosamente';
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