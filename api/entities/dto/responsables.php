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
    protected $nombre_madre = null;
    protected $direccion_madre = null;
    protected $telefono_madre = null;
    protected $nombre_padre = null;
    protected $direccion_padre = null;
    protected $telefono_padre = null;

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

    public function setNombreMadre($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->nombre_madre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionMadre($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->direccion_madre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefonoMadre($value)
    {
        if (Validator::validatePhone($value, 1, 50)) {
            $this->telefono_madre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombrePadre($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->nombre_padre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionPadre($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->direccion_padre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefonoPadre($value)
    {
        if (Validator::validatePhone($value, 1, 50)) {
            $this->telefono_padre = $value;
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

    public function getNombreMadre()
    {
        return $this->nombre_madre;
    }

    public function getDireccionMadre()
    {
        return $this->direccion_madre;
    }

    public function getTelefonoMadre()
    {
        return $this->telefono_madre;
    }

    public function getNombrePadre()
    {
        return $this->nombre_padre;
    }

    public function getDireccionPadre()
    {
        return $this->direccion_padre;
    }

    public function getTelefonoPadre()
    {
        return $this->telefono_padre;
    }
}
