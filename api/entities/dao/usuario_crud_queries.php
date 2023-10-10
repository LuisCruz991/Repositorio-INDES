<?php
require_once('../helpers/database.php');

class Usuarioqueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idusuario, nombre_usuario, correo_usuario, imagen_usuario, tipo_usuario, intentos_fallidos, acceso
                 FROM usuarios INNER JOIN tipo_usuario USING(idtipo_usuario)
                 WHERE nombre_usuario  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO usuarios(nombre_usuario, clave_usuario, correo_usuario, imagen_usuario, idtipo_usuario, intentos_fallidos)
                 VALUES(?,?,?,?,?,?,?)';
         $params = array($this->nombre, $this->clave, $this->correo, $this->imagen, $this->tipo, $this->intentos, $this->acceso);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idusuario, nombre_usuario, correo_usuario, imagen_usuario, tipo_usuario, intentos_fallidos, acceso
                 FROM usuarios INNER JOIN tipo_usuario USING(idtipo_usuario)';
         return Database::getRows($sql);
     }


     //  Consulta para leer los paises del eventos 
      public function readTipo()
      {
          $sql = 'SELECT idusuario, nombre_usuario, correo_usuario, imagen_usuario, tipo_usuario, intentos_fallidos, acceso
                  FROM usuarios INNER JOIN tipo_usuario USING(idtipo_usuario)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idusuario, nombre_usuario, clave_usuario, correo_usuario, imagen_usuario, idtipo_usuario, intentos_fallidos
                 FROM usuarios INNER JOIN tipo_usuario USING(idtipo_usuario)
                 WHERE idusuario = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow($imagen)
     {
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $imagen) : $this->imagen = $imagen;

         $sql = 'UPDATE usuarios  
                 SET  nombre_usuario = ?, clave_usuario = ?, correo_usuario = ?, imagen_usuario = ?, idtipo_usuario, = ? intentos_fallidos = ?
                 WHERE idusuario = ?';
         $params = array($this->nombre, $this->clave, $this->correo, $this->imagen, $this->tipo, $this->intentos, $this->acceso, $this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM usuarios
                 WHERE idusuario = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}