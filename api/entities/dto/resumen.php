<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/resumen_queries.php');


class Resumen extends Resumenqueries  {

    protected $id = null;
    protected $horasP = null;
    protected $horasE = null ;
    protected $finalizado = null;
    protected $fecha = null;
 


    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setHorasP($value)
    {
        if (Validator::validateAlphanumeric($value,1,20)) {
            $this->horasP = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setHorasE($value)
    {
        if (Validator::validateAlphanumeric($value,1,20)) {
            $this->horasE = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFinalizado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->finalizado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }

    

    public function getId()
    {
        return $this->id;
    }

    public function getHorasP()
    {
        return $this->horasP;
    }

    public function getHorasE() 
    {
        return $this->horasE;
    }

    public function getFinalizado() {
        return $this->finalizado ;
    }

    public function getFecha() {
        return $this-> fecha;
    }


}