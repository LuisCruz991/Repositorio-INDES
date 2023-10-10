<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/usuario_crud_queries.php');


class Usuario extends Usuarioqueries  {

    protected $id = null;
    protected $nombre = null;
    protected $clave = null;
    protected $correo = null ;
    protected $imagen = null;
    protected $tipo = null;
    protected $intentos = null;
    protected $acceso = null;
    protected $ruta = '../imagenes/imagen_usuario/';

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 2000, 2000)) {
            $this->imagen = Validator::getFileName();
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

    public function setNombre($value)
    {
        if (Validator::validateString($value, 1,60)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIntentos($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->intentos = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAcceso($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->acceso = $value;
            return true;
        } else {
            return false;
        }
    }

    

    
    public function getImagen() {
        return $this-> imagen;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getClave() 
    {
        return $this->clave;
    }

    public function getCorreo() 
    {
        return $this->correo;
    }

    public function getTipo() 
    {
        return $this->tipo;
    }

    public function getIntentos() 
    {
        return $this->intentos;
    }

    public function getAcceso() 
    {
        return $this->acceso;
    }


    public function getruta() {
        return $this->ruta ;
    }

   


}