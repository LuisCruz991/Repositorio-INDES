<?php
require_once('../helpers/database.php');
/*
 *	Clase para manejar el acceso a datos de la entidad USUARIO.
 */
class UsuarioQueries
{
    /*
     *   Métodos para gestionar la cuenta del usuario.
     */
    public function checkUser($nombres)
    {
        $sql = 'SELECT idadministrador, acceso FROM administradores WHERE nombre_usuario = ?';
        $params = array($nombres);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['idadministrador'];
            $this->acceso = $data['acceso'];
            $this->nombres = $nombres;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario, intentos_fallidos FROM administradores WHERE idadministrador = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        $this->intentos = $data['intentos_fallidos'];
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave_usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword2($password)
    {
        $sql = 'SELECT clave_usuario FROM administradores WHERE idadministrador = ?';
        $params = array($_SESSION['idadministrador']);
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
        $sql = 'UPDATE administradores SET clave_usuario = ? WHERE idadministrador = ?';
        $params = array($this->clave, $_SESSION['idadministrador']);
        return Database::executeRow($sql, $params);
    }

    public function recuPassword()
    {
        $sql = 'UPDATE administradores 
                SET clave_usuario = ? 
                WHERE nombre_usuario = ?';
        $params = array($this->clave, $this-> alias);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT idadministrador,nombre_usuario,correo_usuario, clave_usuario
                FROM administradores
                WHERE idadministrador = ?';
        $params = array($_SESSION['idadministrador']);
        return Database::getRow($sql, $params);
    }
    

    public function cambiarClave()
    {
       
        $sql = 'UPDATE administradores
                SET clave_usuario = ?
                WHERE idadministrador = ?';
        $params = array($this->clave, $_SESSION['idadministrador']);
        return Database::executeRow($sql, $params);
    }

   

    /*
     *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
     */
    public function searchRows($value)
    {
        $sql = 'SELECT idusuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM administradores
                WHERE apellido_usuario LIKE ? OR nombre_usuario LIKE ?
                ORDER BY nombre_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO administradores(nombre_usuario, clave_usuario, correo_usuario)
                VALUES(?, ?, ?)';
        $params = array($this->alias, $this->clave, $this->correo);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idadministrador, nombre_usuario, correo_usuario
                FROM administradores
                ORDER BY nombre_usuario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idadministrador, nombre_usuario, correo_usuario
                FROM administradores
                WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE administradores 
                SET nombre_usuario = ?, correo_usuario = ?
                WHERE idadministrador = ?';
        $params = array($this->alias, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM administradores
                WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readByname()
    {
        $sql = "SELECT correo_usuario
        FROM administradores
        WHERE nombre_usuario = ?";
        $params = array($this->alias);
        return Database::getRow($sql, $params);
    }

    // Método para resetear los intentos de inicio de sesión.
    public function bloquearUsuario()
    {
        $sql = 'UPDATE administradores SET acceso = 0  WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    } 

    // Método para actualizar los intentos de inicio de sesión.
    public function actualizarIntentos()
    {
        $sql = 'UPDATE administradores SET intentos_fallidos = intentos_fallidos + 1 WHERE idadministrador = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

     // Método para resetear los intentos de inicio de sesión.
     public function resetearIntentos()
     {
         $sql = 'UPDATE administradores SET intentos_fallidos = 0 WHERE idadministrador = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}