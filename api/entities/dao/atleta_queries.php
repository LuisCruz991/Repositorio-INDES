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

    //  Consulta para obtener todos los atletas y ordenarlos por federacion
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

    //  Consulta para obtener los resultados obtenidos por un atleta 
     public function resultadoAtleta()
     {
         $sql = 'SELECT nombre_prueba, posicion
         FROM records
         INNER JOIN pruebas USING(idprueba)
         WHERE idatleta = ?
         ORDER BY posicion ASC';
         $params = array($this->id);
         return Database::getRows($sql, $params);
     }

  
 
     // Consulta para cargar los datos de un solo registro
     public function readOne()
     {
         $sql = "SELECT idatleta,nombre_atleta, apellido_atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_federacion, entrenadores.nombre, atletas.clave, atletas.idgenero, idresponsable, identrenador,atletas.idfederacion,CONCAT(nombre_atleta, ' ', apellido_atleta) as nombre_completo
         FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN federaciones USING(idfederacion)
         INNER JOIN entrenadores USING(identrenador)
         WHERE idatleta = ?";
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

    //Creamos la consulta para obtener la cantidad de atletas que pertenecen a una federacion
    public function cantidadAtletasFederaciones()
    {
        $sql = 'SELECT nombre_atleta, COUNT(idfederacion) cantidad 
                FROM atletas INNER JOIN federaciones USING(idfederacion)
                GROUP BY nombre_federacion ORDER BY cantidad DESC';
        return Database::getRows($sql);   
    }

    // Consulta para obtener la ficha de atleta
    public function readFicha()
    {
        $sql = "SELECT CONCAT(nombre_atleta, ' ', apellido_atleta) atleta, nacimiento, nombre_genero, estatura, peso, talla_camisa, talla_short, atletas.direccion, atletas.dui, celular, telefono_casa, atletas.correo, nombre_responsable ,CONCAT(entrenadores.nombre, '  ', entrenadores.apellido) entrenadores, nombre_federacion
        FROM atletas
         INNER JOIN generos USING(idgenero)
         INNER JOIN responsables USING(idresponsable)
         INNER JOIN federaciones USING(idfederacion)
         INNER JOIN entrenadores USING(identrenador)
        WHERE idatleta = ?";
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    // Consulta para obtener las horas de entrenamiento cumplidas por atleta
    public function horasAtleta()
    {
        $sql = 'SELECT  hora_inicio, hora_cierre,(hora_cierre - hora_inicio) as horas, lugar_entreno, fecha_entreno 
                FROM entrenamientos 
                WHERE idatleta =  ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);   
    }

    public function horasAtleta2()
    {
         $sql = 'SELECT (hora_cierre - hora_inicio) as horas, fecha_entreno
                FROM entrenamientos
                WHERE idatleta = ? ';
            $params = array($this->id);
        return Database::getRows($sql, $params);   
    }

    // Consulta para obtener el presupuesto de un atleta
    public function presupuestoAtleta()
    {
        $sql = "SELECT estimulos, preparacion_fogues,ayuda_extranjera,equipamiento,patrocinadores, otros, CONCAT(nombre_atleta, ' ', apellido_atleta) atleta
                FROM presupuesto INNER JOIN atletas USING(idatleta) 
                WHERE idatleta = ?";
        $params = array($this->id);
        return Database::getRow($sql, $params);   
    }

    // Consulta para obtener las marcas de un atleta 
    public function atletaMarcas () 
    {
       $sql = "SELECT  marca_obtenida, nombre_prueba 
                FROM records 
                INNER JOIN pruebas USING (idprueba) 
                WHERE idatleta = ?";
       $params = array($this->id);
       return Database::getRows($sql, $params);   
    }

    
}
