<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/presupuesto_queries.php');


class Presupuesto extends PresupuestoQueries  {

    protected $id = null;
    protected $categoria = null;
    protected $estimulos = null ;
    protected $preparacionFog = null ;
    protected $ayuda = null ;
    protected $equipamiento = null ;
    protected $otros = null ;
    protected $patrocinadores = null ;
    protected $observaciones = null;
    protected $atleta = null;




    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCategoria($categoria) {
        if (Validator::validateNaturalNumber($value)) {
            $this->categoria = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setEstimulos($estimulos) {
        if (Validator::validateNaturalNumber($value)) {
            $this->estimulos = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setPreparacionFogues($preparacionFog) {
        if (Validator::validateNaturalNumber($value)) {
            $this->preparacionFog = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setAyudaExtranjera($ayuda) {
        if (Validator::validateNaturalNumber($value)) {
            $this->ayuda = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setEquipamiento($equipamiento) {
        if (Validator::validateNaturalNumber($value)) {
            $this->equipamiento = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setOtros($otros) {
        if (Validator::validateNaturalNumber($value)) {
            $this->otros = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setPatrocinadores($estimulos) {
        if (Validator::validateNaturalNumber($value)) {
            $this->patrocinadores = $value;
            return true;
        } else {
            return false;
        }   
     }

    public function setObservaciones($value)
    {
        if (Validator::validateString($value,1,500)) {
            $this->observaciones = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAtleta($atleta) {
        if (Validator::validateNaturalNumber($value)) {
            $this->atleta = $value;
            return true;
        } else {
            return false;
        }    
    }

   

    public function getId()
    {
        return $this->id;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getEstimulos()
    {
        return $this->estimulos;
    }

    public function getPreparacionFogues()
    {
        return $this->preparacionFog;
    }

    public function getAyudaExtranjera()
    {
        return $this->ayuda;
    }

    public function getEquipamiento()
    {
        return $this->equipamiento;
    }

    public function getOtros()
    {
        return $this->otros;
    }

    public function getPatrocinadores() 
    {
        return $this->patrocinadores;
    }

    public function getObservaciones() {
        return $this->observciones ;
    }

    public function getAtleta() {
        return $this-> atleta;
    }

}