<?php
require_once('../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad ADMIN.
*/
class AdminQueries
{
     // Consulta para realizar la operacion "Search"
    public function searchRows($value)
    {
        $sql = 'SELECT nombre_usuario, correo_usuario, intentos_fallidos,acceso
        FROM administradores 
        WHERE nombre_usuario LIKE ? or correo_usuario LIKE ?
        ORDER BY nombre_usuario';   
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    // Consulta para realizar la operacion "Read"
    public function readAll()
    {
        $sql = ' SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario ,intentos_fallidos,acceso
        FROM administradores
        ORDER BY idadministrador';
        return Database::getRows($sql);
    }

     // Consulta para cargar los datos de un solo registro
    public function readOne()
    {
        $sql = 'SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario, acceso
                FROM administradores
                WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE administradores
                SET nombre_usuario = ?, correo_usuario = ?
                WHERE idadministrador = ?';
        $params = array($this->nombre, $this->correo, $_SESSION['idadministrador']);
        return Database::executeRow($sql, $params);
    }

     // Consulta para realizar la operacion "Create"
    public function createRow()
    {
        $sql = 'INSERT INTO administradores(nombre_usuario, clave_usuario, correo_usuario)
                VALUES(?,?,?)';
        $params = array($this->nombre, $this->clave, $this->correo);
        return Database::executeRow($sql, $params);
    }

    // Consulta para realizar la operacion "Update"
    public function updateRow()
    {
       
        $sql = 'UPDATE administradores
                SET nombre_usuario =  ?,  correo_usuario = ?, acceso = ?
                WHERE idadministrador = ?';
        $params = array($this->nombre, $this->correo, $this->acceso, $this->id);
        return Database::executeRow($sql, $params);
    }

    // Consulta para realizar la operacion "Delete"
    public function deleteRow()
    {
        $sql = 'DELETE FROM administradores
                WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    
}
