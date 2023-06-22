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
    protected $deporte = null;
    protected $evento = null;

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

    public function getDeporte()
    {
        return $this->deporte;
    }

    public function getEvento()
    {
        return $this->evento;
    }
}
