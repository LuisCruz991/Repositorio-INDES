<?php
require_once('../helpers/database.php');

class rankqueries
{

    // Consulta para obtener el atleta mas destacado
    public function firstPlace($value1, $value2)
    {
        $sql = "SELECT nombre_atleta,CONCAT(nombre_atleta,' ', apellido_atleta)nombre,nombre_deporte,nombre_modalidad,COUNT(actuaciones_destacadas.posicion)num_actuaciones
            FROM actuaciones_destacadas 
            INNER JOIN atletas USING (idatleta)
            INNER JOIN pruebas USING (idprueba)
            INNER JOIN modalidades_deportivas USING (idmodalidad_deporte)
            INNER JOIN deportes USING (iddeporte)
            WHERE posicion <=3 AND nombre_deporte like ? AND  nombre_modalidad like ? GROUP BY idatleta, nombre_atleta 
            ORDER BY num_actuaciones DESC, posicion ASC LIMIT 1; ";
        $params = array("%$value1%", "%$value2%");
        return Database::getRows($sql, $params);
    }

    // Consulta para obtener el segundo atleta mas destacado
    public function secondfPlace($value1, $value2)
    {
        $sql = "SELECT nombre_atleta,CONCAT(nombre_atleta,' ', apellido_atleta)nombre,nombre_deporte,nombre_modalidad,COUNT(actuaciones_destacadas.posicion)num_actuaciones
            FROM actuaciones_destacadas 
            INNER JOIN atletas USING (idatleta)
            INNER JOIN pruebas USING (idprueba)
            INNER JOIN modalidades_deportivas USING (idmodalidad_deporte)
            INNER JOIN deportes USING (iddeporte)
            WHERE posicion <=3 AND nombre_deporte like ? AND  nombre_modalidad like ? GROUP BY idatleta, nombre_atleta 
            ORDER BY num_actuaciones DESC, posicion ASC LIMIT 1 OFFSET 1;";
        $params = array("%$value1%", "%$value2%");
        return Database::getRows($sql, $params);
    }

    // Consulta para obtener el tercer atleta mas destacado
    public function thirdPlace($value1, $value2)
    {
        $sql = "SELECT nombre_atleta,CONCAT(nombre_atleta,' ', apellido_atleta)nombre,nombre_deporte,nombre_modalidad,COUNT(actuaciones_destacadas.posicion)num_actuaciones
            FROM actuaciones_destacadas 
            INNER JOIN atletas USING (idatleta)
            INNER JOIN pruebas USING (idprueba)
            INNER JOIN modalidades_deportivas USING (idmodalidad_deporte)
            INNER JOIN deportes USING (iddeporte)
            WHERE posicion <=3 AND nombre_deporte like ? AND  nombre_modalidad like ? GROUP BY idatleta, nombre_atleta 
            ORDER BY num_actuaciones DESC, posicion ASC LIMIT 1 OFFSET 2;";
        $params = array("%$value1%", "%$value2%");
        return Database::getRows($sql, $params);
    }

    // Consulta para obtener los atletas no pertenecientes al podio
    public function rest($value1, $value2)
    {
        $sql = "SELECT nombre_atleta,ROW_NUMBER()OVER(ORDER BY num_actuaciones DESC, posicion ASC) AS num,CONCAT(nombre_atleta,' ', apellido_atleta)nombre,nombre_deporte,nombre_modalidad,COUNT(actuaciones_destacadas.posicion)num_actuaciones
            FROM actuaciones_destacadas 
            INNER JOIN atletas USING (idatleta)
            INNER JOIN pruebas USING (idprueba)
            INNER JOIN modalidades_deportivas USING (idmodalidad_deporte)
            INNER JOIN deportes USING (iddeporte)
            WHERE posicion <=3 AND nombre_deporte like ? AND  nombre_modalidad like ? GROUP BY idatleta, nombre_atleta 
            LIMIT 7 OFFSET 3;";
        $params = array("%$value1%", "%$value2%");
        return Database::getRows($sql, $params);
    }
    // Consulta para leer las modalidades deportivas teniendo como parametro el nombre del deporte
    public function readModaliad($value)
    {
        $sql = "SELECT * FROM modalidades_deportivas WHERE nombre_modalidad like ?";
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

}