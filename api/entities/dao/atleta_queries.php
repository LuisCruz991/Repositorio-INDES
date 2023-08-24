<?php
require_once('../helpers/database.php');

class atletaqueries {

     // Consulta para realizar la operacion "Search"
     public function searchRows($value)
     {
         $sql = 'SELECT idatleta,nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_federacion, nombre, atletas.clave
         FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN federaciones USING(idfederacion)
         INNER JOIN entrenadores USING(identrenador)
                 WHERE nombre_atleta  LIKE ?';
         $params = array("%$value%");
         return Database::getRows($sql, $params);
     }
 
     // Consulta para realizar la operacion "Create"
     public function createRow()
     {
         $sql = 'INSERT INTO atletas(nombre_atleta, apellido_atleta, nacimiento, idgenero, estatura, peso, talla_camisa, talla_short, direccion, dui, celular, telefono_casa, correo, idresponsable, idfederacion, identrenador, clave)
                 VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
         $params = array($this->nombre, $this->apellido, $this->nacimiento,$this->genero, $this->estatura, $this->peso,$this->camisa, $this->short, $this->direccion,$this->dui, $this->celular, $this->telefono,$this->correo,$this->responsable, $this->federacion,$this->entrenador, $this->clave);
         return Database::executeRow($sql, $params);
     }
     
     // Consulta para realizar la operacion "Read"
     public function readAll()
     {
         $sql = 'SELECT idatleta,nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_federacion,nombre_responsable,entrenadores.nombre, atletas.clave
         FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN federaciones USING(idfederacion)
         INNER JOIN entrenadores USING(identrenador)';
         return Database::getRows($sql);
     }

     public function readFederaciones()
     {
         $sql = 'SELECT idfederacion,nombre_federacion
         FROM federaciones';
         return Database::getRows($sql);
     }


     public function readAtletasFederacion()
     {
         $sql = 'SELECT nombre_atleta, apellido_atleta, nacimiento, nombre_genero, atletas.dui, celular, atletas.correo, nombre_federacion,entrenadores.nombre
         FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN federaciones USING(idfederacion)
         INNER JOIN entrenadores USING(identrenador)
         ORDER BY nombre_federacion';
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

  
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = 'SELECT idatleta,nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_federacion, entrenadores.nombre, atletas.clave, atletas.idgenero, idresponsable, identrenador,atletas.idfederacion
         FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN federaciones USING(idfederacion)
         INNER JOIN entrenadores USING(identrenador)
         WHERE idatleta = ?';
         $params = array($this->id);
         return Database::getRow($sql, $params);
     }
 
     // Consulta para realizar la operacion "Update"
     public function updateRow()
     {
         $sql = 'UPDATE atletas
         SET nombre_atleta = ?, apellido_atleta = ?, nacimiento = ?, idgenero = ?, estatura = ?, peso = ?, talla_camisa = ?, talla_short = ?, direccion = ?, dui = ?, celular = ?, telefono_casa = ?, correo = ?, idresponsable = ?, idfederacion = ?, identrenador = ?
         WHERE idatleta = ?';
         $params = array($this->nombre, $this->apellido, $this->nacimiento,$this->genero, $this->estatura, $this->peso,$this->camisa, $this->short, $this->direccion,$this->dui, $this->celular, $this->telefono,$this->correo, $this->responsable
         , $this->federacion,$this->entrenador,  $this->id);
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

     //Creamos la consulta para obtener la cantidad de atletas que pertenecen a un genero 
    public function cantidadAtletasGenero()
    {
        $sql = 'SELECT nombre_genero, COUNT(idatleta) cantidad
                FROM atletas INNER JOIN generos USING(idgenero)
                GROUP BY nombre_genero ORDER BY cantidad DESC';
        return Database::getRows($sql);   
    }

    public function readFicha()
    {
        $sql = 'SELECT nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_responsable ,entrenadores.nombre, nombre_federacion
        FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN federaciones USING(idfederacion)
         INNER JOIN entrenadores USING(identrenador)
        WHERE idatleta = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function horasAtleta()
    {
        $sql = 'SELECT  SUM(hora_cierre - hora_inicio) as horas, nombre_atleta, idatleta 
                FROM entrenamientos INNER JOIN atletas USING (idatleta)
                WHERE idatleta = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);   
    }
}