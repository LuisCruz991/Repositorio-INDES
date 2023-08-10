<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ResponsableQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idresponsable, nombre, direccion, telefono, nombre_parentesco
        FROM responsables INNER JOIN parentescos USING (idparentesco)
        WHERE nombre LIKE ? OR direccion LIKE ? OR telefono LIKE ?
        ORDER BY idresponsable';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

 
    public function readAll()
    {
        $sql = ' SELECT idresponsable, nombre, direccion, telefono, nombre_parentesco
        FROM responsables INNER JOIN parentescos USING (idparentesco)
        ORDER BY idresponsable';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idresponsable, nombre, direccion, telefono, idparentesco
                FROM responsables
                WHERE idresponsable = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO responsables(nombre, direccion, telefono, idparentesco)
                VALUES(?,?,?,?)';
        $params = array($this->nombre, $this->direccion, $this->telefono, $this->parentesco);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
       
        $sql = 'UPDATE responsables
                SET nombre = ?, direccion = ?, telefono = ?
                WHERE idresponsable = ?';
        $params = array($this->nombre, $this->direccion, $this->telefono, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM responsables
                WHERE idresponsable = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
