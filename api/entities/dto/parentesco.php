<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/parentesco_queries.php');


class parentesco extends ParentescoQueries  {

    protected $id = null;
    protected $parentesco = null ;




    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setParentesco($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->parentesco = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParentesco()
    {
        return $this->parentesco;
    }

}