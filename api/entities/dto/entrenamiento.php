<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/entrenamiento_queries.php');


class Entrenamiento extends EntrenamientoQueries  {

    protected $id = null;
    protected $fecha = null ;
    protected $horaInicio = null ;
    protected $horaCierre = null ;
    protected $lugar = null ;
    protected $atleta = null ;
    protected $entrenador = null ;
    protected $resumen = null ;
    protected $usuario = null ;
 

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
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

    public function setHoraInicio($value)
    {
        if (Validator::validateAlphanumeric($value,1,20)) {
            $this->horaInicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setHoraCierre($value)
    {
        if (Validator::validateAlphanumeric($value,1,20)) {
            $this->horaCierre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setLugar($value)
    {
        if (Validator::validateAlphanumeric($value,1,500)) {
            $this->lugar = $value;
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

    public function setEntrenador($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->entrenador = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setResumen($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->resumen = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    
    

    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    public function getHoraCierre()
    {
        return $this->horaCierre;
    }

    public function getLugar()
    {
        return $this->lugar;
    }

    public function getAtleta() 
    {
        return $this->atleta;
    }

    public function getEntrenador() 
    {
        return $this->entrenador;
    }

    public function getResumen() 
    {
        return $this->resumen;
    }

    public function getUsuario() 
    {
        return $this->usuario;
    }



}