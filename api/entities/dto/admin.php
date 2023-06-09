<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/admin_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad RECORDS.
*/
class Admin extends AdminQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $clave = null;
    protected $genero = null;

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
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->clave = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setGenero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->genero = $value;
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

    public function getGenero()
    {
        return $this->genero;
    }

    
}
