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
        $sql = ' SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario
        WHERE nombre_usuario LIKE ? ';   
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    // Consulta para realizar la operacion "Read"
    public function readAll()
    {
        $sql = ' SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario
        FROM administradores
        ORDER BY idadministrador';
        return Database::getRows($sql);
    }

     // Consulta para cargar los datos de un solo registro
    public function readOne()
    {
        $sql = 'SELECT idadministrador, nombre_usuario, clave_usuario, correo_usuario, idgenero
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
 
 
    //  Consulta para leer los generos de administradores
    public function readGenero()
     {
         $sql = 'SELECT idgenero, nombre_genero
                 FROM generos';
         return Database::getRows($sql);
     }

     // Consulta para realizar la operacion "Create"
    public function createRow()
    {
        $sql = 'INSERT INTO administradores(nombre_usuario, clave_usuario, correo_usuario, idgenero)
                VALUES(?,?,?,?)';
        $params = array($this->nombre, $this->clave, $this->correo, $this->genero);
        return Database::executeRow($sql, $params);
    }

    // Consulta para realizar la operacion "Update"
    public function updateRow()
    {
       
        $sql = 'UPDATE administradores
                SET nombre_usuario =  ?, clave_usuario = ?, idgenero = ?, correo_usuario = ?
                WHERE idadministrador = ?';
        $params = array($this->nombre, $this->clave, $this->genero, $this->correo, $this->id);
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
