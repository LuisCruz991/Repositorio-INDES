<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad ClasificacionDeportes.
*/
class ClasifDeporteQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idclasificacion_deporte, nombre_clasificacion
                FROM clasificacion_deporte
                WHERE nombre_clasificacion ILIKE ?
                ORDER BY nombre_clasificacion';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    
    public function createRow()
    {
        $sql = 'INSERT INTO clasificacion_deporte(nombre_clasificacion)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idclasificacion_deporte, nombre_clasificacion
                FROM clasificacion_deporte
                ORDER BY idclasificacion_deporte';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idclasificacion_deporte, nombre_clasificacion
                FROM clasificacion_deporte
                WHERE idclasificacion_deporte = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE clasificacion_deporte
                SET nombre_clasificacion = ?
                WHERE idclasificacion_deporte = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM clasificacion_deporte
                WHERE idclasificacion_deporte = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
