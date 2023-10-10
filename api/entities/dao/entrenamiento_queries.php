<?php
require_once('../helpers/database.php');

class EntrenamientoQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT identrenamiento, fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado, nombre_usuario
                 FROM entrenamientos INNER JOIN nombre_atleta USING(idatleta)
                 INNER JOIN nombre USING(identrenador)
                 INNER JOIN finalizado USING(idresumen)
                 INNER JOIN nombre_usuario USING(idusuario)
                 WHERE lugar_estreno  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO entrenamientos(fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, idatleta, identrenador, idresumen, idusuario)
                 VALUES(?,?,?,?,?,?,?,?)';
         $params = array($this->fecha, $this->horaInicio, $this->horaCierre, $this->lugar, $this->atleta, $this->entrenador, $this->resumen, $this->usuario);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT identrenamiento, fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado, nombre_usuario
                 FROM entrenamientos INNER JOIN nombre_atleta USING(idatleta)
                 INNER JOIN nombre USING(identrenador)
                 INNER JOIN finalizado USING(idresumen)
                 INNER JOIN nombre_usuario USING(idusuario)';
         return Database::getRows($sql);
     }

    //  Consulta para leer los atletas de entrenamientos 
     public function readAtleta()
     {
         $sql = 'SELECT identrenamiento, fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado, nombre_usuario
                 FROM entrenamientos INNER JOIN nombre_atleta USING(idatleta)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }

     //  Consulta para leer los entrenadores de entrenamientos 
      public function readEntrenador()
      {
          $sql = 'SELECT identrenamiento, fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado, nombre_usuario
                  FROM entrenamientos INNER JOIN nombre USING(identrenador)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }

      //  Consulta para leer el resumen de entrenamientos 
      public function readResumen()
      {
          $sql = 'SELECT identrenamiento, fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado, nombre_usuario
                  FROM entrenamientos INNER JOIN finalizado USING(idresumen)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }

      //  Consulta para leer el usuario de entrenamientos 
      public function readUsuario()
      {
          $sql = 'SELECT identrenamiento, fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, nombre_atleta, nombre, finalizado, nombre_usuario
                  FROM entrenamientos INNER JOIN nombre_usuario USING(idusuario)';
         $params = array($this->id);
         return Database::getRows($sql, $params);
      }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT identrenamiento, fecha_estreno, hora_inicio, hora_cierre, lugar_entreno, idatleta, identrenador, idresumen, idusuario
                 FROM entrenamientos INNER JOIN nombre_atleta USING(idatleta)
                 INNER JOIN nombre USING(identrenador)
                 INNER JOIN finalizado USING(idresumen)
                 INNER JOIN nombre_usuario USING(idusuario)
                 WHERE identrenamiento = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE entrenamientos  
                 SET  fecha_estreno = ?, hora_inicio = ?, hora_cierre = ?, lugar_entreno = ?, idatleta = ?, identrenador = ?, idresumen = ?, idusuario = ? 
                 WHERE identrenamiento = ?';
         $params = array($this->fecha, $this->horaInicio, $this->horaCierre, $this->lugar, $this->atleta, $this->entrenador, $this->resumen, $this->usuario);
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