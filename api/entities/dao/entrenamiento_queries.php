<?php
require_once('../helpers/database.php');

class EntrenamientoQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT identrenamiento, fecha_entreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado, 
                 FROM entrenamientos INNER JOIN atletas USING(idatleta)
                 INNER JOIN entrenadores USING(identrenador)
                 INNER JOIN resumen_entrenamiento USING(idresumen)
                 WHERE lugar_estreno  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO entrenamientos (fecha_entreno, hora_inicio, hora_cierre, lugar_entreno, idatleta, identrenador, idresumen)
         VALUES (?,?,?,?,?,?,?)';
         $params = array($this->fecha, $this->horaInicio, $this->horaCierre, $this->lugar, $this->atleta, $this->entrenador, $this->resumen);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT entrenamientos.identrenamiento, fecha_entreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado
         FROM entrenamientos 
         INNER JOIN atletas ON entrenamientos.idatleta = atletas.idatleta
         INNER JOIN entrenadores ON entrenamientos.identrenador = entrenadores.identrenador
         INNER JOIN resumen_entrenamiento ON entrenamientos.idresumen = resumen_entrenamiento.idresumen;
         ';
         return Database::getRows($sql);
     }

    //  Consulta para leer los atletas de entrenamientos 
     public function readAtleta()
     {
         $sql = 'SELECT identrenamiento, fecha_entreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado
                 FROM entrenamientos INNER JOIN atletas USING(idatleta)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }

     //  Consulta para leer los entrenadores de entrenamientos 
      public function readEntrenador()
      {
          $sql = 'SELECT identrenamiento, fecha_entreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado
                  FROM entrenamientos INNER JOIN entrenadores USING(identrenador)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }

      //  Consulta para leer el resumen de entrenamientos 
      public function readResumen()
      {
          $sql = 'SELECT identrenamiento, fecha_entreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado
                  FROM entrenamientos INNER JOIN resumen USING(idresumen)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }

      //  Consulta para leer el usuario de entrenamientos 
      public function readUsuario()
      {
          $sql = 'SELECT ';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
                $sql = 'SELECT entrenamientos.identrenamiento, fecha_entreno, hora_inicio, hora_cierre, lugar_entreno, atletas.idatleta, entrenadores.identrenador
                FROM entrenamientos
                INNER JOIN atletas ON entrenamientos.idatleta = atletas.idatleta
                INNER JOIN entrenadores ON entrenamientos.identrenador = entrenadores.identrenador
                INNER JOIN resumen_entrenamiento ON entrenamientos.idresumen = resumen_entrenamiento.idresumen
                WHERE identrenamiento = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE entrenamientos  
                 SET  fecha_entreno = ?, hora_inicio = ?, hora_cierre = ?, lugar_entreno = ?, idatleta = ?, identrenador = ?, idresumen = ?
                 WHERE identrenamiento = ?';
         $params = array($this->fecha, $this->horaInicio, $this->horaCierre, $this->lugar, $this->atleta, $this->entrenador, $this->resumen);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM entrenamientos 
                 WHERE identrenamiento = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }

     
}