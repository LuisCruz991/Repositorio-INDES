<?php
require_once('../helpers/database.php');

class ParentescoQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idparentesco, nombre_parentesco
                 FROM parentescos
                 WHERE nombre_parentesco  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO parentescos(nombre_parentesco)
                 VALUES(?)';
         $params = array($this->parentesco);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idparentesco,nombre_parentesco
                 FROM parentescos';
         return Database::getRows($sql);
     }
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idparentesco,nombre_parentesco
                 FROM parentescos
                 WHERE idparentesco = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE parentescos  
                 SET  nombre_parentesco = ? 
                 WHERE idparentesco = ?';
         $params = array($this->parentesco,$this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM parentescos 
                 WHERE idparentesco = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}