<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/responsable_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad RESPONSABLES.
*/
class Responsable extends ResponsableQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $direccion = null;
    protected $telefono = null;
    protected $parentesco = null;

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

    public function setDireccion($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validatePhone($value, 1, 50)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setParentesco($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->parentesco = $value;
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

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getParentesco()
    {
        return $this->parentesco;
    }
}
