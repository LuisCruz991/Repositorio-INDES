<?php
require_once('../helpers/database.php');

class PresupuestoQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
{
    $sql = 'SELECT idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones, categoria_inversion, atleta
            FROM presupuesto INNER JOIN categoria_inversion USING(idcatag_inversion)
                             INNER JOIN atleta USING(idatleta)
            WHERE estimulos LIKE ? ';
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
         $sql = 'SELECT idcategoria, anual_mensual
                 FROM categoria_inversion';
        return Database::getRows($sql);
     }

      //  Consulta para leer los atletas de presupuesto  
      public function readAtleta()
      {
          $sql = 'SELECT idatleta,nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_madre, nombre_deporte, nombre, atletas.clave
          FROM atletas
          INNER JOIN generos USING(idgenero)
          INNER JOIN responsables USING(idresponsable)
          INNER JOIN deportes USING(iddeporte)
          INNER JOIN entrenadores USING(identrenador)';
          return Database::getRows($sql);
      }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT  idpresupuesto, estimulos, preparacion_fogues, ayuda_extranjera, equipamiento, otros, patrocinadores, observaciones
                 FROM presupuesto
                 WHERE idpresupuesto = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }

     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
        
         $sql = 'UPDATE presupuesto
                 SET idpresupuesto = ?, estimulos = ?, preparacion_fogues = ?, ayuda_extranjera = ?, equipamiento = ?, otros = ?, patrocinadores = ?, observaciones = ?                
                 WHERE idpresupuesto = ?';
         $params = array($this->categoria, $this->estimulos, $this->preparacionFog,$this->ayuda, $this->equipamiento, $this->otros, $this->patrocinadores,$this->observaciones, $this->atleta, $this->id);
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