<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ActuacionesQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idactuacion,posicion, marca_obtenida, nombre_medida, nombre_atleta, nombre_prueba
        FROM actuaciones_destacadas INNER JOIN unidades_medidas USING (idunidad_medida)
        INNER JOIN atletas USING(idatleta)
        INNER JOIN pruebas USING(idprueba)
        WHERE marca_obtenida LIKE ? OR nombre_medida LIKE ? OR nombre_atleta LIKE ? OR posicion LIKE ?
        ORDER BY idrecord';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

 
    public function readAll()
    {
        $sql = ' SELECT idactuacion, posicion, marca_obtenida, nombre_medida, nombre_prueba, nombre_atleta
        FROM actuaciones_destacadas INNER JOIN unidades_medidas USING (idunidad_medida)
        INNER JOIN atletas USING(idatleta)
        INNER JOIN pruebas USING(idprueba)
        ORDER BY idactuacion';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idactuacion, posicion,marca_obtenida, idunidad_medida, idatleta, idprueba, nombre_atleta
                FROM actuaciones_destacadas 
                INNER JOIN atletas USING(idatleta)
                WHERE idactuacion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO actuaciones_destacadas( posicion,marca_obtenida, idunidad_medida, idatleta, idprueba)
                VALUES(?,?,?,?,?)';
        $params = array( $this->posicion,$this->marca_obtenida, $this->unidad, $this->atleta, $this->prueba);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE actuaciones_destacadas
                SET  posicion = ?, marca_obtenida = ?, idunidad_medida = ?, idatleta = ?, idprueba = ?
                WHERE idactuacion = ?';
        $params = array($this->posicion, $this->marca_obtenida, $this->unidad, $this->atleta, $this->prueba, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM actuaciones_destacadas
                WHERE idactuacion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readAtletasTitulos()
     {
         $sql = 'SELECT nombre_atleta, COUNT(idactuacion) as  cantidad
         FROM actuaciones_destacadas
         INNER JOIN atletas USING(idatleta)
        GROUP BY nombre_atleta
         ORDER BY cantidad DESC LIMIT 5';
         return Database::getRows($sql);
     }
}
