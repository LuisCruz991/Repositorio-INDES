<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad ClasificacionDeportes.
*/
class UnidadesQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idunidad_medida, nombre_medida
                FROM unidades_medidas
                WHERE nombre_medida LIKE ?
                ORDER BY nombre_medida';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    
    public function createRow()
    {
        $sql = 'INSERT INTO unidades_medidas(nombre_medida)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idunidad_medida, nombre_medida
                FROM unidades_medidas
                ORDER BY idunidad_medida';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idunidad_medida, nombre_medida
                FROM unidades_medidas
                WHERE idunidad_medida = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE unidades_medidas
                SET nombre_medida = ?
                WHERE idunidad_medida = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM unidades_medidas
                WHERE idunidad_medida = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
