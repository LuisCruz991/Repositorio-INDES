<?php
require_once('../helpers/database.php');

class entrenadorqueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT identrenador, nombre, apellido, entrenadores.telefono, nombre_genero, entrenadores.direccion, dui, correo, nombre_federacion
         FROM entrenadores INNER JOIN generos USING(idgenero)
         INNER JOIN federaciones USING(idfederacion)
         WHERE nombre  LIKE ? or apellido  LIKE ? or dui  LIKE ?';
         $params = array("%$value%", "%$value%", "%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO entrenadores (nombre, apellido, entrenadores.telefono, idgenero, entrenadores.direccion, dui, correo, idfederacion)
         VALUES (?, ?, ?, ?, ?, ?, ?,?)';
         $params = array($this->nombre, $this->apellido, $this->telefono,$this->genero, $this->direccion, $this->dui, $this->correo, $this->federacion);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT identrenador,nombre, apellido, entrenadores.telefono, nombre_genero, entrenadores.direccion, dui, correo, nombre_federacion
         FROM entrenadores
         INNER JOIN generos USING(idgenero)
         INNER JOIN federaciones USING(idfederacion)';
         return Database::getRows($sql);
     }

     public function readGenero()
     {
         $sql = 'SELECT idgenero, nombre_genero
                 FROM generos';
         return Database::getRows($sql);
     }

     public function readFederacion()
     {
         $sql = 'SELECT idfederacion, nombre_federacion
                 FROM federaciones';
         return Database::getRows($sql);
     }

   
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT identrenador,nombre, apellido, entrenadores.telefono, nombre_genero, entrenadores.direccion, dui, correo, nombre_federacion, idfederacion, idgenero
         FROM entrenadores
         INNER JOIN generos USING(idgenero)
         INNER JOIN federaciones USING(idfederacion)
         WHERE identrenador = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }

     public function readFicha()
     {
         $sql = "SELECT CONCAT(nombre, ' ', apellido) entrenador, entrenadores.telefono, nombre_genero, entrenadores.direccion, dui, correo, nombre_federacion, idfederacion, idgenero
         FROM entrenadores
         INNER JOIN generos USING(idgenero)
         INNER JOIN federaciones USING(idfederacion)
         WHERE identrenador = ?";
         $params = array($this->id);
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE entrenadores
         SET nombre = ?, apellido = ?, telefono = ?, idgenero = ?, direccion = ?, dui = ?, correo = ?, idfederacion = ?
         WHERE identrenador = ?';
         $params = array($this->nombre, $this->apellido, $this->telefono, $this->genero, $this->direccion, $this->dui, $this->correo, $this->federacion, $this->id);
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

     //Consulta para reporte no parametrizado que muestra los entrenadores por federacion
     public function readEntrenadorFederacion()
     {
         $sql = "SELECT CONCAT(nombre, ' ', apellido) entrenador, entrenadores.telefono, nombre_genero, entrenadores.direccion, dui, correo, nombre_federacion
         FROM entrenadores INNER JOIN generos USING(idgenero)
         INNER JOIN federaciones USING(idfederacion)
         ORDER BY nombre_federacion";
         return Database::getRows($sql);
     }

     public function atletaEntrenador () 
     {
        $sql = 'SELECT  nombre_atleta, apellido_atleta, atletas.celular
                FROM atletas INNER JOIN entrenadores USING (identrenador)
                WHERE identrenador = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);   
     }

}