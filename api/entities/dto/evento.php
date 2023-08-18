<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/evento_queries.php');


class Event extends EventQueries  {

    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null ;
    protected $fechaEvento = null ;
    protected $pais = null ;
    protected $direccion = null ;
    protected $horaInicio = null ;
    protected $horaCierre = null ;
    protected $tipoEvento = null ;
    protected $imagenSede = null;
    protected $ruta = '../imagenes/eventos/';
    protected $sede = null;

    public function setSede($value)
    {
        if (Validator::validateAlphabetic($value ,1, 50)) {
            $this->sede = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 2000, 2000)) {
            $this->imagenSede = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEvento($value)
    {
        if (Validator::validateString($value, 1,60)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value,1,500)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaEvento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPais($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->pais = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateAlphanumeric($value,1,500)) {
            $this->direccion = $value;
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

    public function setTipoEvento($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipoEvento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getFecha()
    {
        return $this->fechaEvento;
    }

    public function getPais() 
    {
        return $this->pais;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    public function getHoraCierre()
    {
        return $this->horaCierre;
    }

    public function getTipoEvento() 
    {
        return $this->tipoEvento;
    }

    public function getruta() {
        return $this->ruta ;
    }

    public function getImagen() {
        return $this-> imagenSede;
    }

    public function getSede() {
        return $this-> sede;
    }

}