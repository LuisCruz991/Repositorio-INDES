<?php
require_once('../helpers/database.php');

class PresupuestoQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones
                 FROM presupuesto INNER JOIN categoria_inversion USING(idcatag_inversion)
                                  INNER JOIN atleta USING(idatleta)
                 WHERE estimulos  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO presupuesto(idcatag_inversion, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones, idatleta)
                 VALUES(?,?,?,?,?,?,?,?,?,)';
         $params = array($this->categoria, $this->estimulos, $this->preparacionFog,$this->ayuda, $this->equipamiento, $this->otros, $this->patrocinadores,$this->observaciones, $this->atleta);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones
                 FROM presupuesto INNER JOIN categoria_inversion USING(idcateg_inversion)
                                  INNER JOIN atleta USING(idatleta)';
         return Database::getRows($sql);
     }

    //  Consulta para leer las categorias de presupuesto  
     public function readCategoria()
     {
         $sql = 'SELECT idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones
                 FROM presupuesto INNER JOIN categoria_presupuesto USING(idcateg_inversion)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }

      //  Consulta para leer los atletas de presupuesto  
      public function readAtletas()
      {
          $sql = 'SELECT idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones
                  FROM presupuesto INNER JOIN atletas USING(idatleta)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT  idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones
                 FROM presupuesto INNER JOIN categoria_presupuesto USING(idcateg_presupuesto)
                                  INNER JOIN atletas USING(idatleta)
                 WHERE idpresupuesto = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
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