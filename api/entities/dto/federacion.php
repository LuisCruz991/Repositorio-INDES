<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/federacion_queries.php');


class Federacion extends FederacionQueries  {

    protected $id = null;
    protected $nombre = null;
    protected $siglas = null ;
    protected $direccion = null ;
    protected $telefono = null;
    protected $logo = null;
    protected $deporte = null ;
    protected $ruta = '../imagenes/federaciones/';


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
        if (Validator::validateString($value, 1,60)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

   

    public function setSiglas($value) {
        if (Validator::validateString($value, 1,10)) {
        $this->siglas = $value;
        return true;
        } else {
            return false;
        }
    }


    public function setDireccion($value) {
        if (Validator::validateString($value, 1,250)) {
            $this->direccion = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setTelefono($value) {
        if (Validator::validatePhone($value)) {
            $this->telefono = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setImagen($file) {
        if (Validator::validateImageFile($file, 2000, 2000)) {
            $this->logo = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }


    public function setDeporte($value) {
        if (Validator::validateNaturalNumber($value)) {
            $this->deporte = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getSiglas() {
        return $this->siglas;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getLogo() {
        return $this->logo;
    }

    public function getDeporte() {
        return $this->deporte;
    }

    public function getruta() {
        return $this->ruta ;
    }
    

}