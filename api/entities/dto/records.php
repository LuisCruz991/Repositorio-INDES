<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/records_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad RECORDS.
*/
class Record extends RecordQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $marca_obtenida = null;
    protected $unidad = null;
    protected $atleta = null;
    protected $prueba = null;
    protected $posicion = null;

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

    public function setMarcaObtenida($value)
    {
        if (Validator::validateMoney($value)) {
            $this->marca_obtenida = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUnidadMedida($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->unidad = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setAtleta($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->atleta = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrueba($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->prueba = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPosicion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->posicion = $value;
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
        return $this->unidad;
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
