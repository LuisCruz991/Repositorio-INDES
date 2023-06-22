<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRUEBAS.
*/
class PruebasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idprueba, nombre_prueba, nombre_deporte, nombre_evento
        FROM pruebas INNER JOIN deportes USING (iddeporte)
        INNER JOIN eventos USING(idevento)
        WHERE nombre_prueba LIKE ?
        ORDER BY idprueba';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

 
    public function readAll()
    {
        $sql = ' SELECT idprueba, nombre_prueba, nombre_deporte, nombre_evento
        FROM pruebas INNER JOIN deportes USING (iddeporte)
        INNER JOIN eventos USING(idevento)
        WHERE nombre_prueba LIKE ?
        ORDER BY idprueba';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idprueba, nombre_prueba, iddeporte, idevento
                FROM pruebas
                WHERE idprueba = ?';
        $params = array($this->id, $this->nombre, $this->deporte, $this->evento);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO pruebas(nombre_prueba, iddeporte, idevento)
                VALUES(?,?,?)';
        $params = array($this->nombre, $this->deporte, $this->evento);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
       
        $sql = 'UPDATE pruebas
                SET nombre_prueba = ?
                WHERE idprueba = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM pruebas
                WHERE idprueba = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readDeportes()
    {
        $sql = 'SELECT idprueba, nombre_prueba
                FROM pruebas INNER JOIN deportes USING (iddeporte)
                WHERE idprueba = ? 
                ORDER BY nombre_prueba';
        $params = array($this->id, $this->nombre);
        return Database::getRows($sql, $params);
    }
    
    public function readEvento()
    {
        $sql = 'SELECT idprueba, nombre_prueba
                FROM pruebas INNER JOIN eventos USING (idevento)
                WHERE idprueba = ? 
                ORDER BY nombre_prueba';
        $params = array($this->id, $this->nombre);
        return Database::getRows($sql, $params);
    }
}
