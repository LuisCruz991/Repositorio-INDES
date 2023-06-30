<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/presupuesto_queries.php');


class Presupuesto extends PresupuestoQueries  {

    protected $id = null;
    protected $categoria = null;
    protected $estimulo = null ;
    protected $preparacion = null ;
    protected $ayuda = null ;
    protected $equipamiento = null ;
    protected $otro = null ;
    protected $patrocinador = null ;
    protected $observacion = null;
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

    public function setEstimulos($estimulo) {
        if (Validator::validateMoney($value)) {
            $this->estimulo = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setPreparacionFogues($preparacion) {
        if (Validator::validateMoney($value)) {
            $this->preparacion = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setAyudaExtranjera($ayuda) {
        if (Validator::validateMoney($value)) {
            $this->ayuda = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setEquipamiento($equipamiento) {
        if (Validator::validateMoney($value)) {
            $this->equipamiento = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setOtros($otro) {
        if (Validator::validateMoney($value)) {
            $this->otro = $value;
            return true;
        } else {
            return false;
        }   
     }

     public function setPatrocinadores($patrocinador) {
        if (Validator::validateMoney($value)) {
            $this->patrocinador = $value;
            return true;
        } else {
            return false;
        }   
     }

    public function setObservaciones($observacion)
    {
        if (Validator::validateString($value,1,500)) {
            $this->observacion = $value;
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
        return $this->estimulo;
    }

    public function getPreparacionFogues()
    {
        return $this->preparacion;
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
        return $this->otro;
    }

    public function getPatrocinadores() 
    {
        return $this->patrocinador;
    }

    public function getObservaciones() {
        return $this->observcion ;
    }

    public function getAtleta() {
        return $this-> atleta;
    }

}