<?php
require_once('../helpers/database.php');

class entrenadorqueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT identrenador,nombre, apellido, telefono, nombre_genero, direccion, dui, correo
         FROM entrenadores
         INNER JOIN generos USING(idgenero)
                 WHERE nombre  LIKE ? or apellido  LIKE ? ';
         $params = array("%$value%", "%$value%" );
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO entrenadores (identrenador, nombre, apellido, telefono, nombre_genero, direccion, dui, correo)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
         $params = array($this->nombre, $this->apellido, $this->telefono,$this->genero, $this->direccion, $this->dui,$this->correo);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT identrenador,nombre, apellido, telefono, nombre_genero, direccion, dui, correo
         FROM entrenadores
         INNER JOIN generos USING(idgenero)';
         return Database::getRows($sql);
     }

     public function readGenero()
     {
         $sql = 'SELECT idgenero, nombre_genero
                 FROM generos';
         return Database::getRows($sql);
     }

   
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT identrenador,nombre, apellido, telefono, nombre_genero, direccion, dui, correo
         FROM entrenadores
         INNER JOIN generos USING(idgenero)
         WHERE identrenador = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE entrenadores
         SET nombre = ?, apellido = ?, telefono = ?, nombre_genero = ?, direccion = ?, dui = ?, correo = ?
         WHERE identrenador = ?';
         $params = array($this->nombre, $this->apellido, $this->telefono,$this->genero, $this->direccion, $this->dui,$this->correo,$this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM entrenadores
         WHERE identrenador = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}