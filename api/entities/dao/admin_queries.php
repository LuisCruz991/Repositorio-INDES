<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad ADMIN.
*/
class AdminQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario, nombre_genero
        FROM administradores INNER JOIN generos USING (idgenero)
        WHERE nombre_usuario LIKE ? ';   
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = ' SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario, nombre_genero
        FROM administradores INNER JOIN generos USING (idgenero)
        ORDER BY idadministrador';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario, idgenero
                FROM administradores
                WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readGenero()
     {
         $sql = 'SELECT idgenero, nombre_genero
                 FROM generos';
         return Database::getRows($sql);
     }

    public function createRow()
    {
        $sql = 'INSERT INTO administradores(nombre_usuario, clave_usuario, correo_usuario, idgenero)
                VALUES(?,?,?,?)';
        $params = array($this->nombre, $this->clave, $this->correo, $this->genero);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
       
        $sql = 'UPDATE administradores
                SET nombre_usuario =  ?, clave_usuario = ?, idgenero = ?, correo_usuario = ?
                WHERE idadministrador = ?';
        $params = array($this->nombre, $this->clave, $this->genero, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM administradores
                WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    
}
