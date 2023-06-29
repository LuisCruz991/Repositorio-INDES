<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad TipoEventos.
*/
class TipoEventoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idtipo_evento, nombre
                FROM tipo_evento
                WHERE nombre LIKE ?
                ORDER BY nombre';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    
    public function createRow()
    {
        $sql = 'INSERT INTO tipo_evento(nombre)
                VALUES(?)';
        $params = array($this->tipo);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idtipo_evento, nombre
                FROM tipo_evento
                ORDER BY idtipo_evento';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idtipo_evento, nombre
                FROM tipo_evento
                WHERE idtipo_evento = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tipo_evento
                SET nombre = ?
                WHERE idtipo_evento = ?';
        $params = array($this->tipo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tipo_evento
                WHERE idtipo_evento = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
