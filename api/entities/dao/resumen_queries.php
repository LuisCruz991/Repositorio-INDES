<?php
require_once('../helpers/database.php');

class Resumenqueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idresumen, horas_planificadas, horas_entrenadas, finalizado, fecha_finalizacion
                 FROM resumen_entrenamiento
                 WHERE fecha_finalizacion  LIKE ? ';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operación "Create"
        public function createRow()
        {
        $sql = 'INSERT INTO resumen_entrenamiento(horas_planificadas, horas_entrenadas, fecha_finalizacion)
                VALUES(?,?,?)';
        $params = array($this->horasP, $this->horasE, $this->fecha);
        return Database::executeRow($sql, $params);
        }

     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idresumen, horas_planificadas, horas_entrenadas, finalizado, fecha_finalizacion
                 FROM resumen_entrenamiento';
         return Database::getRows($sql);
     }

 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idresumen, horas_planificadas, horas_entrenadas, finalizado, fecha_finalizacion
                 FROM resumen_entrenamiento
                 WHERE idresumen = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE resumen_entrenamiento  
                 SET  horas_planificadas = ?, horas_entrenadas = ?, finalizado = ?, fecha_finalizacion = ?
                 WHERE idresumen = ?';
         $params = array($this->horasP, $this->horasE, $this->finalizado, $this->fecha, $this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM resumen_entrenamiento
                 WHERE idresumen = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}