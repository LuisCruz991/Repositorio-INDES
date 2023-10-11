<?php
require_once('../helpers/database.php');

class rankqueries
{ 

// Consulta para obtener el atleta mas destacado
public function firstPlace()
{
    $sql = "SELECT nombre_atleta,CONCAT(nombre_atleta,' ', apellido_atleta)nombre,nombre_deporte,nombre_modalidad,COUNT(actuaciones_destacadas.posicion)num_actuaciones
            FROM actuaciones_destacadas 
            INNER JOIN atletas USING (idatleta)
            INNER JOIN pruebas USING (idprueba)
            INNER JOIN modalidades_deportivas USING (idmodalidad_deporte)
            INNER JOIN deportes USING (iddeporte)
            WHERE posicion <=3 AND nombre_deporte like '%B%' AND  nombre_modalidad like '%3%' GROUP BY idatleta, nombre_atleta 
            ORDER BY num_actuaciones DESC, posicion ASC LIMIT 1; ";
    return Database::getRows($sql);
}

// Consulta para obtener el segundo atleta mas destacado
public function secondfPlace()
{
    $sql = "SELECT nombre_atleta,CONCAT(nombre_atleta,' ', apellido_atleta)nombre,COUNT(actuaciones_destacadas.posicion) AS num_actuaciones 
       FROM actuaciones_destacadas INNER JOIN atletas USING (idatleta) 
       WHERE posicion <=3 GROUP BY idatleta, nombre_atleta 
       ORDER BY num_actuaciones DESC, posicion ASC LIMIT 1 OFFSET 1;";
    return Database::getRows($sql);
}

// Consulta para obtener el tercer atleta mas destacado
public function thirdPlace()
{
    $sql = "SELECT nombre_atleta,CONCAT(nombre_atleta,' ', apellido_atleta)nombre,COUNT(actuaciones_destacadas.posicion) AS num_actuaciones 
           FROM actuaciones_destacadas INNER JOIN atletas USING (idatleta) 
           WHERE posicion <=3 GROUP BY idatleta, nombre_atleta 
           ORDER BY num_actuaciones DESC, posicion ASC LIMIT 1 OFFSET 2;";
    return Database::getRows($sql);
}

}