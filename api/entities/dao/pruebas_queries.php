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
        $sql = ' SELECT idprueba, nombre_prueba, hora_inicial, duracion_estimada, nombre_deporte, nombre_evento, nombre_modalidad
        FROM pruebas INNER JOIN deportes USING (iddeporte)
        INNER JOIN eventos USING(idevento)
        INNER JOIN modalidades_deportivas USING(idmodalidad_deporte)
        WHERE nombre_prueba LIKE ?
        ORDER BY idprueba';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

 
    public function readAll()
    {
        $sql = ' SELECT idprueba, nombre_prueba, hora_inicial, duracion_estimada, nombre_deporte, nombre_evento, nombre_modalidad
        FROM pruebas INNER JOIN deportes USING (iddeporte)
        INNER JOIN eventos USING(idevento)
        INNER JOIN modalidades_deportivas USING(idmodalidad_deporte)
        ORDER BY idprueba';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idprueba, nombre_prueba, hora_inicial, duracion_estimada, iddeporte, idevento, idmodalidad_deporte
                FROM pruebas
                WHERE idprueba = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO pruebas(nombre_prueba, hora_inicial, duracion_estimada, iddeporte, idevento, idmodalidad_deporte)
                VALUES(?,?,?,?,?,?)';
        $params = array($this->nombre, $this->horaInicio, $this->estimado, $this->deporte, $this->evento, $this->modalidad);
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
        $sql = 'SELECT iddeporte, nombre_deporte
                 FROM deportes';
         return Database::getRows($sql);
     }
    
    public function readEvento()
    {
        $sql = 'SELECT idevento, nombre_evento
                FROM eventos';
        return Database::getRows($sql);
    }
    
    public function readModalidad()
    {
        $sql = 'SELECT idmodalidad_deporte, nombre_modalidad
                FROM modalidades_deportivas';
        return Database::getRows($sql);
    }

    
    //Consulta para reporte no parametrizado que muestra las pruebas por deportes
    public function readPruebaDeportes()
    {
        $sql = 'SELECT nombre_prueba, nombre_evento, nombre_modalidad
        FROM pruebas INNER JOIN deportes USING(iddeporte)
        INNER JOIN eventos USING(idevento)
        INNER JOIN modalidades_deportivas USING(idmodalidad_deporte)
        ORDER BY nombre_deporte';
        return Database::getRows($sql);
    }
}
