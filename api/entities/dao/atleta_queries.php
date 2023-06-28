<?php
require_once('../helpers/database.php');

class atletaqueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT iddeporte,nombre_deporte, nombre_clasificacion, nombre_modalidad
                 FROM deportes INNER JOIN clasificacion_deportes USING(idclasificacion_deporte)
                               INNER JOIN modalidades_deportivas USING(idmodalidad_deporte)
                 WHERE nombre_deporte  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO atletas(nombre_atleta, apellido_atleta, nacimiento, idgenero, estatura, peso, talla_camisa, talla_short, direccion, dui, celular, telefono_casa, correo, idresponsable, iddeporte, identrenador, clave)
                 VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
         $params = array($this->nombre, $this->apellido, $this->nacimiento,$this->genero, $this->estatura, $this->peso,$this->camisa, $this->short, $this->direccion,$this->dui, $this->celular, $this->telefono,$this->correo, $this->nombre_madre, $this->deporte,$this->entrenador, $this->clave);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idatleta,nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_madre, nombre_deporte, nombre, atletas.clave
         FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN deportes USING(iddeporte)
         INNER JOIN entrenadores USING(identrenador)';
         return Database::getRows($sql);
     }

     public function readGenero()
     {
         $sql = 'SELECT idgenero, nombre_genero
                 FROM generos';
         return Database::getRows($sql);
     }

     public function readEntrenador()
     {
         $sql = 'SELECT identrenador, nombre
                 FROM entrenadores';
         return Database::getRows($sql);
     }

     public function readClasificacion()
     {
         $sql = 'SELECT iddeporte,nombre_deporte, nombre_clasificacion, nombre_modalidad
                 FROM deportes INNER JOIN clasificacion_deportes USING(idclasificacion_deporte)
                               INNER JOIN modalidades_deportivas USING(idmodalidad_deporte)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }
     public function readModalidad()
     {
         $sql = 'SELECT iddeporte,nombre_deporte, nombre_clasificacion, nombre_modalidad
                 FROM deportes INNER JOIN clasificacion_deportes USING(idclasificacion_deporte)
                               INNER JOIN modalidades_deportivas USING(idmodalidad_deporte)';
        $params = array($this->id);
        return Database::getRows($sql, $params);
     }
 
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idatleta,nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_madre, nombre_deporte, nombre, atletas.clave
         FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN deportes USING(iddeporte)
         INNER JOIN entrenadores USING(identrenador)
         WHERE idatleta = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE atletas
         SET nombre_atleta = ?, apellido_atleta = ?, nacimiento = ?, idgenero = ?, estatura = ?, peso = ?, talla_camisa = ?, talla_short = ?, direccion = ?, dui = ?, celular = ?, telefono_casa = ?, correo = ?, facebook = ?, instagram = ?, twitter = ?, idresponsable = ?, iddeporte = ?, identrenador = ?, clave = ?
         WHERE idatleta = ?';
         $params = array($this->nombre, $this->apellido, $this->nacimiento,$this->genero, $this->estatura, $this->peso,$this->camisa, $this->short, $this->direccion,$this->dui, $this->celular, $this->telefono,$this->correo, $this->facebook, $this->insta,$this->twitter, $this->nombre_madre
         , $this->deporte,$this->entrenador, $this->clave,  $this->id);
         return Database::executeRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Delete"
     public function deleteRow()
     {
         $sql = 'DELETE FROM atletas
         WHERE idatleta = ?';
         $params = array($this->id);
         return Database::executeRow($sql, $params);
     }
}