<?php
require_once('../helpers/database.php');

class Paisqueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idpais, nombre_pais, bandera, nombre_continente
                 FROM paises INNER JOIN continentes USING(idcontinente)
                 WHERE nombre_pais  LIKE ? or nombre_continente  LIKE ?';
         $params = array("%$value%", "%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO paises(nombre_pais,bandera,idcontinente)
                 VALUES(?,?,?)';
         $params = array($this->nombre, $this->bandera, $this->continente);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idpais, nombre_pais, bandera, nombre_continente
                 FROM paises INNER JOIN continentes USING(idcontinente)';
         return Database::getRows($sql);
     }


     //  Consulta para leer los paises del eventos 
      public function readContinente()
      {
          $sql = 'SELECT idpais, nombre_pais, bandera, nombre_continente
                  FROM paises INNER JOIN continentes USING(idcontinente)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idpais, nombre_pais, bandera, nombre_continente, idcontinente
                 FROM paises INNER JOIN continentes USING(idcontinente)
                 WHERE idpais = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow($imagen)
     {
        ($this->bandera) ? Validator::deleteFile($this->getRuta(), $imagen) : $this->bandera = $imagen;

         $sql = 'UPDATE paises  
                 SET  nombre_pais = ?, bandera = ?, idcontinente = ?
                 WHERE idpais = ?';
         $params = array($this->nombre, $this->bandera, $this->continente, $this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM paises
                 WHERE idpais = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}