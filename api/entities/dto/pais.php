<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/pais_queries.php');


class Pais extends Paisqueries  {

    protected $id = null;
    protected $nombre = null;
    protected $continente = null ;
    protected $bandera = null;
    protected $ruta = '../imagenes/banderas/';

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 2000, 2000)) {
            $this->bandera = Validator::getFileName();
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

    public function setPais($value)
    {
        if (Validator::validateString($value, 1,60)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setContinente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->continente = $value;
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

   

    public function getContinente() 
    {
        return $this->continente;
    }

    public function getruta() {
        return $this->ruta ;
    }

    public function getBandera() {
        return $this-> bandera;
    }


}