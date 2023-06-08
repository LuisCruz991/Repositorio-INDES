<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad ADMIN.
*/
class RecordQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idadministrador, nombre_usuario, clave_usuario, nombre_genero
        FROM administradores INNER JOIN generos USING (idgeneros)
        WHERE nombre_usuario
        
        
         LIKE ? OR nombre_medida LIKE ? OR posicion 
         LIKE ?
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
        $params = array($this->numero);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
       
        $sql = 'UPDATE records
                SET marca_obtenida = ? 
                WHERE idrecord = ?';
        $params = array($this->estado, $this->id);
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
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}
