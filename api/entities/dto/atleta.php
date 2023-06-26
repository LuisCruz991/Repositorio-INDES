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
    protected $facebook = null ;
    protected $insta = null ;
    protected $twitter = null;
    protected $responsable = null;
    protected $deporte = null ;
    protected $entrenador = null ;
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

   

    public function setApellido($apellido) {
        if (Validator::validateString($value, 1,50)) {
        $this->apellido = $value;
        return true;
        } else {
            return false;
        }
    }

    public function setNacimiento($nacimiento) {
        if (Validator::validateDate($value)) {
            $this->nacimiento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGenero($genero) {
        if (Validator::validateNaturalNumber($value)) {
            $this->genero = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setEstatura($estatura) {
        if (Validator::validateNaturalNumber($value)) {
            $this->estatura = $value;
            return true;
        } else {
            return false;
        }   
     }

    public function setPeso($peso) {
        if (Validator::validateNaturalNumber($value)) {
            $this->peso = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setCamisa($camisa) {
        if (Validator::validateString($value, 1,5)) {
            $this->camisa = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setShort($short) {
        if (Validator::validateString($value, 1,5)) {
            $this->short = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setDireccion($direccion) {
        if (Validator::validateString($value, 1,200)) {
            $this->direccion = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setDui($dui) {
        if (Validator::validateString($value, 1,10)) {
            $this->dui = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setCelular($celular) {
        if (Validator::validateString($value, 1,9)) {
            $this->celular = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setTelefono($telefono) {
        if (Validator::validateString($value, 1,9)) {
            $this->telefono = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setCorreo($correo) {
        if (Validator::validateString($value, 1,50)) {
            $this->correo = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setFacebook($facebook) {
        if (Validator::validateString($value, 1,50)) {
            $this->facebook = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setInsta($insta) {
        if (Validator::validateString($value, 1,50)) {
            $this->insta = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setTwitter($twitter) {
        if (Validator::validateString($value, 1,50)) {
            $this->twitter = $value;
            return true;
            } else {
                return false;
            }    
        }

    public function setResponsable($responsable) {
        if (Validator::validateNaturalNumber($value)) {
            $this->responsable = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setDeporte($deporte) {
        if (Validator::validateNaturalNumber($value)) {
            $this->deporte = $value;
            return true;
        } else {
            return false;
        }    
    }

    public function setEntrenador($entrenador) {
        if (Validator::validateNaturalNumber($value)) {
            $this->entrenador = $value;
            return true;
        } else {
            return false;
        }    
    }
    public function setClave($clave) {
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

    public function getDui() {
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

    public function getFacebook() {
        return $this->facebook;
    }

    public function getInstagram() {
        return $this->instagram;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function getResponsable() {
        return $this->responsable;
    }

    public function getDeporte() {
        return $this->deporte;
    }

    public function getEntrenador() {
        return $this->entrenador;
    }

    public function getClave() {
        return $this->clave;
    }
    

}