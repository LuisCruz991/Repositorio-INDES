<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad ClasificacionDeportes.
*/
class ContinenteQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idcontinente, nombre_continente
                FROM continentes
                WHERE nombre_continente LIKE ?
                ORDER BY nombre_continente';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    
    public function createRow()
    {
        $sql = 'INSERT INTO continentes(nombre_continente)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idcontinente, nombre_continente
                FROM continentes
                ORDER BY nombre_continente';
        return Database::getRows($sql);
    }


    public function readOne()
    {
        $sql = 'SELECT idcontinente, nombre_continente
                FROM continentes
                WHERE idcontinente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function updateRow()
    {
        $sql = 'UPDATE continentes
                SET nombre_continente = ?
                WHERE idcontinente = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM continentes
                WHERE idcontinente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
