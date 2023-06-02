<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($alias)
    {
        $sql = 'SELECT idusuario FROM usuarios WHERE alias_usuario = ?';
        $params = array($alias);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['idusuario'];
            $this->alias = $alias;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuarios WHERE idusuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave_usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE idusuario = ?';
        $params = array($this->clave, $_SESSION['idusuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT idusuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE idusuario = ?';
        $params = array($_SESSION['idusuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?, alias_usuario = ?
                WHERE idusuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $_SESSION['idusuario']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idusuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE apellido_usuario ILIKE ? OR nombre_usuario ILIKE ?
                ORDER BY nombre_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $this->clave);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idusuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                ORDER BY apellido_usuario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idusuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE idusuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios 
                SET nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?
                WHERE idusuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE idusuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
