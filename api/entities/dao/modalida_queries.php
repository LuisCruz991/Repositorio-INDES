<?php
require_once('../helpers/database.php');

class ModalidadQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idmodalidad_deporte,nombre_modalidad
                 FROM modalidades_deportivas
                 WHERE nombre_modalidad  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO modalidades_deportivas(nombre_modalidad)
                 VALUES(?)';
         $params = array($this->modalidad);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idmodalidad_deporte,nombre_modalidad
                 FROM modalidades_deportivas
                 ORDER BY idmodalidad_deporte';
         return Database::getRows($sql);
     }
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idmodalidad_deporte,nombre_modalidad
                 FROM modalidades_deportivas
                 WHERE idmodalidad_deporte = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE modalidades_deportivas  
                 SET  nombre_modalidad = ? 
                 WHERE idmodalidad_deporte = ?';
         $params = array($this->modalidad,$this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM modalidades_deportivas 
                 WHERE idmodalidad_deporte = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}