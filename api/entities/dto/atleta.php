<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/atleta_queries.php');


class Atleta extends AtletaQueries  {

    protected $id = null;
    protected $nombre = null;
    protected $apellido = null ;
    protected $nacimiento = null ;
    protected $genero = null;
    protected $estatura = null;
    protected $peso = null ;
    protected $camisa = null ;
    protected $short = null;
    protected $direccion = null;
    protected $dui = null ;
    protected $celular = null ;
    protected $telefono = null;
    protected $correo = null;
    protected $responsable = null;
    protected $entrenador = null ;
    protected $federacion = null ;
    protected $clave = null ;





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

    public function setNacimiento($value) {
        if (Validator::validateDate($value)) {
            $this->nacimiento = $value;
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

    public function setEstatura($value) {
        if (Validator::validateMoney($value)) {
            $this->estatura = $value;
            return true;
        } else {
            return false;
        }   
     }

    public function setPeso($value) {
        if (Validator::validateMoney($value)) {
            $this->peso = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setCamisa($value) {
        if (Validator::validateString($value, 1,5)) {
            $this->camisa = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setShort($value) {
        if (Validator::validateString($value, 1,5)) {
            $this->short = $value;
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

    public function setCelular($value) {
        if (Validator::validatePhone($value)) {
            $this->celular = $value;
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

    public function setCorreo($value) {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
            } else {
                return false;
            }    
        }


    public function setResponsable($value) {
        if (Validator::validateNaturalNumber($value)) {
            $this->responsable = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setEntrenador($value) {
        if (Validator::validateNaturalNumber($value)) {
            $this->entrenador = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setFederacion($value) {
        if (Validator::validateNaturalNumber($value)) {
            $this->federacion = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setClave($value) {
        if (Validator::validateString($value, 1,50)) {
            $this->clave = $value;
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

    public function getNacimiento() {
        return $this->nacimiento;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getEstatura() {
        return $this->estatura;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function getCamisa() {
        return $this->camisa;
    }

    public function getShort() {
        return $this->short;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getDUI() {
        return $this->dui;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getNombreMadre() {
        return $this->responsable;
    }

    public function getEntrenador() {
        return $this->entrenador;
    }

    public function getFederacion() {
        return $this->federacion;
    }

    public function getClave() {
        return $this->clave;
    }
    

}