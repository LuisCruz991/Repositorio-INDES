<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/modalida_queries.php');


class modalidad extends ModalidadQueries  {

    protected $id = null;
    protected $modalidad = null ;




    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setModalidad($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->modalidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getModalidad()
    {
        return $this->modalidad;
    }

}