<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/entrenador_queries.php');


class Entrenador extends EntrenadorQueries  {

    protected $id = null;
    protected $nombre = null;
    protected $apellido = null ;
    protected $telefono = null ;
    protected $genero = null ;
    protected $direccion = null ;
    protected $dui = null ;
    protected $correo = null ;

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
        if (Validator::validateString($value, 1,50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

   

    public function setApellido($value) {
        if (Validator::validateString($value, 1,50)) {
        $this->apellido = $value;
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


    public function setGenero($value) {
        if (Validator::validateNaturalNumber($value)) {
            $this->genero = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setDireccion($value) {
        if (Validator::validateString($value, 1,200)) {
            $this->direccion = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setDUI($value) {
        if (Validator::validateDUI($value)) {
            $this->dui = $value;
            return true;
            } else {
                return false;
            }    
        }



    public function setCorreo($value) {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
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

    public function getApellido() {
        return $this->apellido;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getGenero() {
        return $this->genero;
    }


    public function getDireccion() {
        return $this->direccion;
    }

    public function getDUI() {
        return $this->dui;
    }

 public function getCorreo() {
        return $this->correo;
    }
   


}