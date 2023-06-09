<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/responsable_queries.php');
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
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre_madre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionMadre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->direccion_madre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefonoMadre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->telefono_madre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombrePadre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre_padre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionPadre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->direccion_padre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefonoPadre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
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

    public function getMarcaObtenida()
    {
        return $this->marca_obtenida;
    }

    public function getUnidadMedida()
    {
        return $this->unidad_medida;
    }

    public function getAtleta()
    {
        return $this->atleta;
    }

    public function getPrueba()
    {
        return $this->prueba;
    }

    public function getPosicion()
    {

        return $this->posicion;
    }
}
