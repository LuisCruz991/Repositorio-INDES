<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/admin_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad RECORDS.
*/
class Admin extends AdminQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $clave = null;
    protected $correo = null;
    protected $intentos = null;
    protected $acceso = null;
    protected $fecha = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

  
    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value) {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setFecha($value) {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
            } else {
                return false;
            }    
        }

        

    public function setAcceso($value) {
        if (Validator::validateBoolean($value)) {
            $this->acceso = $value;
            return true;
            } else {
                return false;
            }    
        }

    


    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getAcceso() {
        return $this->acceso;
    }

    
}
