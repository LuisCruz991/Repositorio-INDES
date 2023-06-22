<?php
require_once('../helpers/database.php');

class EventQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idevento,nombre_evento , descripcion,nombre, fecha_evento, sede_evento,direccion_sede, imagen_sede, hora_inicio, hora_cierre
                 FROM eventos INNER JOIN tipo_eventos USING(idtipo_evento)
                 WHERE nombre_evento  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO eventos(nombre_evento , descripcion, fecha_evento, imagen_sede, sede_evento,direccion_sede, hora_inicio, hora_cierre,idtipo_evento)
                 VALUES(?,?,?,?,?,?,?,?,?)';
         $params = array($this->nombre, $this->descripcion, $this->fechaEvento,$this->imagenSede,$this->sede, $this->direccion,$this->horaInicio,$this->horaCierre,$this->tipoEvento);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idevento,nombre_evento , descripcion,nombre, fecha_evento, sede_evento,direccion_sede, imagen_sede, hora_inicio, hora_cierre
                 FROM eventos INNER JOIN tipo_eventos USING(idtipo_evento)';
         return Database::getRows($sql);
     }

    //  Consulta para leer los tipos de eventos 
     public function readTipo()
     {
         $sql = 'SELECT idevento,nombre_evento , descripcion,nombre, fecha_evento, sede_evento,direccion_sede, imagen_sede, hora_inicio, hora_cierre
                 FROM eventos INNER JOIN tipo_eventos USING(idtipo_evento)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idevento,nombre_evento , descripcion,nombre, fecha_evento, sede_evento,direccion_sede, imagen_sede, hora_inicio, hora_cierre
                 FROM eventos INNER JOIN tipo_eventos USING(idtipo_evento)
                 WHERE idevento = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow($imagen)
     {
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $imagen) : $this->imagen = $imagen;

         $sql = 'UPDATE eventos  
                 SET  nombre_evento = ?, descripcion = ?, fecha_evento = ?, imagen_sede = ?, sede_evento = ?, direccion_sede = ?, hora_inicio = ?, hora_cierre = ?, idtipo_evento = ?
                 WHERE idevento = ?';
         $params = array($this->nombre, $this->descripcion, $this->fechaEvento,$this->imagenSede,$this->sede, $this->direccion,$this->horaInicio,$this->horaCierre,$this->tipoEvento, $this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM eventos 
                 WHERE idevento = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}