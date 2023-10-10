<?php
require_once('../helpers/database.php');

class SportsQueries
{

    // Consulta para realizar la operacion "Search"
    public function searchRows($value)
    {
        $sql = 'SELECT iddeporte,nombre_deporte, nombre_clasificacion, 
                 FROM deportes INNER JOIN clasificacion_deporte USING(idclasificacion_deporte)
                 WHERE nombre_deporte  LIKE ? or nombre_clasificacion  LIKE ?';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    // Consulta para realizar la operacion "Create"
    public function createRow()
    {
        $sql = 'INSERT INTO deportes(nombre_deporte , idclasificacion_deporte)
                 VALUES(?,?)';
        $params = array($this->nombre, $this->clasificacion);
        return Database::executeRow($sql, $params);
    }

    // Consulta para realizar la operacion "Read"
    public function readAll()
    {
        $sql = 'SELECT iddeporte,nombre_deporte, nombre_clasificacion 
                 FROM deportes
                 INNER JOIN clasificacion_deporte USING(idclasificacion_deporte)';
        return Database::getRows($sql);
    }



    public function readClasificacion()
    {
        $sql = 'SELECT iddeporte,nombre_deporte, nombre_clasificacion
                 FROM deportes INNER JOIN clasificacion_deportes USING(idclasificacion_deporte)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }


    // Consulta para cargar los datos de un solo registro
    public function readOne()
    {
        $sql = 'SELECT iddeporte,nombre_deporte, idclasificacion_deporte 
                FROM deportes
                INNER JOIN clasificacion_deporte USING(idclasificacion_deporte)
                 WHERE iddeporte = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // Consulta para realizar la operacion "Update"
    public function updateRow()
    {
        $sql = 'UPDATE deportes  
                 SET  nombre_deporte =? , idclasificacion_deporte = ?
                 WHERE iddeporte = ?';
        $params = array($this->nombre, $this->clasificacion, $this->id);
        return Database::executeRow($sql, $params);
    }

    // Consulta para realizar la operacion "Delete"
    public function deleteRow()
    {
        $sql = 'DELETE FROM deportes 
                 WHERE iddeporte = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}