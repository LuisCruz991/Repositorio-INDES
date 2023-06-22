<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/deportes_queries.php');


class Deporte extends SportsQueries  {

    protected $id = null;
    protected $nombre = null;
    protected $clasificacion = null ;
    protected $modalidad = null ;




    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDeporte($value)
    {
        if (Validator::validateString($value, 1,50)) {
            $this->nombre = $value;
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

    public function setClasificacion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->clasificacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDeporte()
    {
        return $this->nombre;
    }

    public function getModalidad()
    {
        return $this->modalidad;
    }

    public function getClasificacion()
    {
        return $this->clasificacion;
    }

}