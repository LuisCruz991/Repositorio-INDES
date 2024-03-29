<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/pruebas_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRUEBAS.
*/
class Prueba extends PruebasQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $horaInicio = null;
    protected $estimado = null;
    protected $deporte = null;
    protected $evento = null;
    protected $modalidad = null;

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

    public function setHoraInicio($value)
    {
        if (Validator::validateAlphanumeric($value,1,20)) {
            $this->horaInicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstimado($value)
    {
        if (Validator::validateAlphanumeric($value,1,20)) {
            $this->estimado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDeporte($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->deporte = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setEvento($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->evento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setModalidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->modalidad = $value;
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

    public function getHorainicio()
    {
        return $this->horaInicio;
    }

    public function getEstimado()
    {
        return $this->estimado;
    }

    public function getDeporte()
    {
        return $this->deporte;
    }

    public function getEvento()
    {
        return $this->evento;
    }

    public function getModalidad()
    {
        return $this->modalidad;
    }
}
