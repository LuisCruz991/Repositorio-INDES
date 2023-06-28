<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/usuario_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuario extends UsuarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $correo = null;
    protected $nombres = null;
    protected $alias = null;
    protected $clave = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
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

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias = $value;
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

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

  
    public function getCorreo()
    {
        return $this->correo;
    }

    public function getNombre()
    {
        return $this->nombres;
    }

    public function getClave()
    {
        return $this->clave;
    }
    
    public function getAlias()
    {
        return $this->clave;
    }
}
