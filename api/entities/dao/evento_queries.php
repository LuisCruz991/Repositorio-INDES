<?php
require_once('../helpers/database.php');

class EventQueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idevento, nombre_evento, descripcion, fecha_evento, nombre_pais, direccion_sede, imagen_sede, hora_inicio, hora_cierre, nombre, bandera
                 FROM eventos INNER JOIN tipo_evento USING(idtipo_evento)
                 INNER JOIN paises USING(idpais)
                 WHERE nombre_evento  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO eventos(nombre_evento , descripcion, fecha_evento, imagen_sede, idpais, direccion_sede, hora_inicio, hora_cierre, idtipo_evento)
                 VALUES(?,?,?,?,?,?,?,?,?)';
         $params = array($this->nombre, $this->descripcion, $this->fechaEvento, $this->imagenSede, $this->pais, $this->direccion, $this->horaInicio, $this->horaCierre, $this->tipoEvento);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idevento, nombre_evento , descripcion, fecha_evento, nombre_pais, direccion_sede, imagen_sede, hora_inicio, hora_cierre, nombre, bandera
                 FROM eventos INNER JOIN tipo_evento USING(idtipo_evento)
                 INNER JOIN paises USING(idpais)';
         return Database::getRows($sql);
     }

    //  Consulta para leer los tipos de eventos 
     public function readTipo()
     {
         $sql = 'SELECT idevento,nombre_evento, descripcion, fecha_evento, nombre_pais, direccion_sede, imagen_sede, hora_inicio, hora_cierre, nombre
                 FROM eventos INNER JOIN tipo_eventos USING(idtipo_evento)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }

      public function readPais()
     {
         $sql = 'SELECT idpais, nombre_pais
                 FROM paises';
         return Database::getRows($sql);
     }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idevento, nombre_evento, descripcion, nombre, fecha_evento,  idpais, direccion_sede, imagen_sede, hora_inicio, hora_cierre, idtipo_evento
                 FROM eventos INNER JOIN tipo_evento USING(idtipo_evento)
                 INNER JOIN paises USING(idpais)
                 WHERE idevento = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow($imagen)
     {
        ($this->imagenSede) ? Validator::deleteFile($this->getRuta(), $imagen) : $this->imagenSede = $imagen;

         $sql = 'UPDATE eventos  
                 SET  nombre_evento = ?, descripcion = ?, fecha_evento = ?, imagen_sede = ?, idpais = ?, direccion_sede = ?, hora_inicio = ?, hora_cierre = ?, idtipo_evento = ?
                 WHERE idevento = ?';
         $params = array($this->nombre, $this->descripcion, $this->fechaEvento,$this->imagenSede,$this->pais, $this->direccion,$this->horaInicio,$this->horaCierre,$this->tipoEvento, $this->id);
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

     //Creamos la consulta para obtener la cantidad de eventos que pertenecen a un tipo 
    public function cantidadEventosTipo()
    {
        $sql = 'SELECT nombre, COUNT(idevento) cantidad
                FROM eventos INNER JOIN tipo_evento USING(idtipo_evento)
                GROUP BY nombre ORDER BY cantidad DESC';
        return Database::getRows($sql);   
    }

    //Consulta para reporte no parametrizado que muestra los eventos por paises
    public function readEventoPais()
    {
        $sql = 'SELECT nombre_evento , descripcion, fecha_evento, nombre_pais, direccion_sede, imagen_sede, hora_inicio, hora_cierre, nombre
        FROM eventos INNER JOIN tipo_evento USING(idtipo_evento)
        INNER JOIN paises USING(idpais)
        ORDER BY nombre_evento';
        return Database::getRows($sql);
    }
}