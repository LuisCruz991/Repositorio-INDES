<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class RecordQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idrecord, marca_obtenida, nombre_medida, nombre_atleta, nombre_prueba, posicion
        FROM records INNER JOIN unidades_medidas USING (idunidad_medida)
        INNER JOIN atletas USING(idatleta)
        INNER JOIN pruebas USING(idprueba)
        WHERE marca_obtenida LIKE ? OR nombre_medida LIKE ? OR posicion LIKE ?
        ORDER BY idrecord';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

 
    public function readAll()
    {
        $sql = ' SELECT idrecord, marca_obtenida, nombre_medida, nombre_atleta, nombre_prueba, posicion
        FROM records INNER JOIN unidades_medidas USING (idunidad_medida)
        INNER JOIN atletas USING(idatleta)
        INNER JOIN pruebas USING(idprueba)
        WHERE marca_obtenida ILIKE ? OR nombre_medida ILIKE ? OR posicion ILIKE ?
        ORDER BY idrecord';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idrecord, marca_obtenida, idunidad_medida, idatleta, idprueba, posicion
                FROM records 
                WHERE idrecord = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO records(marca_obtenida, idunidad_medida, idatleta, idprueba, posicion)
                VALUES(?)';
        $params = array($this->marca_obtenida, $this->unidad_medida, $this->atleta, $this->prueba, $this->posicion);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
       
        $sql = 'UPDATE records
                SET marca_obtenida = ? 
                WHERE idrecord = ?';
        $params = array($this->marca_obtenida, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM records
                WHERE idrecord = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readUnidadMedida()
    {
        $sql = 'SELECT idrecord, marca_obtenida, posicion
                FROM records INNER JOIN unidades_medidas USING (idunidad_medida)
                WHERE idunidad_medida = ? 
                ORDER BY nombre_medida';
        $params = array($this->id, $this->marca_obtenida, $this->posicion);
        return Database::getRows($sql, $params);
    }

    public function readAtletas()
    {
        $sql = 'SELECT idrecord, marca_obtenida, posicion
                FROM records INNER JOIN nombre_atleta USING (idatleta)
                WHERE idatleta = ? 
                ORDER BY nombre_atleta';
        $params = array($this->id, $this->marca_obtenida, $this->posicion);
        return Database::getRows($sql, $params);
    }

    public function readPruebas()
    {
        $sql = 'SELECT idrecord, marca_obtenida, posicion
                FROM records INNER JOIN nombre_prueba USING (idprueba)
                WHERE idprueba = ? 
                ORDER BY nombre_prueba';
        $params = array($this->id, $this->marca_obtenida, $this->posicion);
        return Database::getRows($sql, $params);
    }
}
