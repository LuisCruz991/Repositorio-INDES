<?php
require_once('../helpers/validator.php');
require_once('../entities/dao/clas_deportes_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad ClasificacionDeporte.
*/
class Clasificacion extends ClasifDeporteQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;

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

    public function setNombre($value)
    {
        if (Validator::validateString($value, 1, 50)) {
            $this->nombre = $value;
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

    public function getNombre()
    {
        return $this->nombre;
    }
}
