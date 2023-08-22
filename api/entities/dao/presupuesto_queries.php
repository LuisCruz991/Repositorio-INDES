<?php
require_once('../helpers/database.php');

class PresupuestoQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
{
    $sql = 'SELECT idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, obsevaciones, anual_mensual, nombre_atleta
    FROM presupuesto INNER JOIN categoria_inversion USING(idcateg_inversion)
                     INNER JOIN atletas USING(idatleta)
            WHERE nombre_atleta LIKE ? ';
    $params = array("%$value%");
    return Database::getRows($sql, $params);
}

 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO presupuesto(idcateg_inversion, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, obsevaciones, idatleta)
                 VALUES(?,?,?,?,?,?,?,?,?)';
         $params = array($this->categoria, $this->estimulo, $this->preparacion,$this->ayuda, $this->equipamiento, $this->otro, $this->patrocinador,$this->observacion, $this->atleta);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, obsevaciones, anual_mensual, nombre_atleta
                 FROM presupuesto INNER JOIN categoria_inversion USING(idcateg_inversion)
                                  INNER JOIN atletas USING(idatleta)';
         return Database::getRows($sql);
     }

    //  Consulta para leer las categorias de presupuesto  
     public function readCategoria()
     {
         $sql = 'SELECT idcateg_inversion, anual_mensual
                 FROM categoria_inversion';
        return Database::getRows($sql);
     }

      //  Consulta para leer los atletas de presupuesto  
      public function readAtleta()
      {
          $sql = 'SELECT idatleta, concat (nombre_atleta, " " ,apellido_atleta)
                 FROM atletas';
          return Database::getRows($sql);
      }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT  idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, obsevaciones, idatleta, idcateg_inversion
                 FROM presupuesto
                 WHERE idpresupuesto = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }

     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
        
         $sql = 'UPDATE presupuesto
                 SET idcateg_inversion = ?, estimulos = ?, preparacion_fogues = ?, ayuda_extranjera = ?, equipamiento = ?, otros = ?, patrocinadores = ?, obsevaciones = ?, idatleta = ?                
                 WHERE idpresupuesto = ?';
         $params = array($this->categoria, $this->estimulo, $this->preparacion,$this->ayuda, $this->equipamiento, $this->otro, $this->patrocinador,$this->observacion, $this->atleta, $this->id);
         return Database::executeRow($sql, $params);
     }
 
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM presupuesto 
                 WHERE idpresupuesto = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}