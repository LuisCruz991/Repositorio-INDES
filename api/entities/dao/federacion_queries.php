<?php
require_once('../helpers/database.php');

class FederacionQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idfederacion, nombre_federacion, direccion, telefono, logo, nombre_deporte
                 FROM federaciones INNER JOIN deportes USING(iddeporte)
                 WHERE nombre_federacion LIKE ? or siglas LIKE ? or direccion LIKE ?';
         $params = array("%$value%", "%$value%", "%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO federaciones(nombre_federacion , siglas, direccion, telefono, logo, iddeporte)
                 VALUES(?,?,?,?,?,?,?,?,?)';
         $params = array($this->nombre, $this->siglas, $this->direccion, $this->telefono, $this->logo, $this->deporte);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idfederacion, nombre_federacion ,  direccion, telefono, logo, nombre_deporte
                 FROM federaciones INNER JOIN deportes USING(iddeporte)';
         return Database::getRows($sql);
     }

    //  Consulta para leer los deportes de las federaciones 
     public function readDeporte()
     {
         $sql = 'SELECT idfederacion, nombre_federacion , siglas, direccion, telefono, logo, nombre_deporte
                 FROM federaciones INNER JOIN deportes USING(iddeporte)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idfederacion, nombre_federacion , siglas, direccion, telefono, logo, iddeporte
                 FROM federaciones INNER JOIN deportes USING(iddeporte)
                 WHERE idfederacion = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow($imagen)
     {
        ($this->logo) ? Validator::deleteFile($this->getRuta(), $imagen) : $this->logo = $imagen;

         $sql = 'UPDATE federaciones  
                 SET  nombre_federacion = ?, siglas = ?, direccion = ?, telefono = ?, logo = ?, iddeporte = ?
                 WHERE idevento = ?';
         $params = array($this->nombre, $this->siglas, $this->direccion, $this->telefono, $this->logo, $this->deporte, $this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM federaciones 
                 WHERE idfederacion = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }

//      consulta para generar grafico de cantidad de atletas por Federacion
     public function cantidadAtletasFederaciones()
     {
         $sql = 'SELECT nombre_federacion, COUNT(idatleta) cantidad
                 FROM atletas INNER JOIN federaciones USING(idfederacion)
                 GROUP BY nombre_federacion ORDER BY cantidad DESC';
         return Database::getRows($sql);   
     }
}