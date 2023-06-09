<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRUEBAS.
*/
class PruebasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idprueba, nombre_prueba, iddeporte, idevento
        FROM pruebas
        WHERE nombre_prueba LIKE ?
        ORDER BY idprueba';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

 
    public function readAll()
    {
        $sql = ' SELECT idprueba, nombre_prueba, iddeporte, idevento
        FROM pruebas
        WHERE marca_obtenida ILIKE ? OR nombre_medida ILIKE ? OR posicion ILIKE ?
        ORDER BY idprueba';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idprueba, nombre_prueba, iddeporte, idevento
                FROM pruebas
                WHERE idprueba = ?';
        $params = array($this->id, $this->nombre_madre, $this->direccion_madre, $this->telefono_madre, $this->nombre_padre, $this->direccion_padre, $this->telefono_padre);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO pruebas(nombre_prueba, iddeporte, idevento)
                VALUES(?,?,?,?,?,?)';
        $params = array($this->nombre_madre, $this->direccion_madre, $this->telefono_madre, $this->nombre_padre, $this->direccion_padre, $this->telefono_padre);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
       
        $sql = 'UPDATE pruebas
                SET nombre_madre = ?, direccion_madre = ?, telefono_madre = ?, nombre_padre = ?, direccion_padre = ?, telefono_padre = ?
                WHERE idprueba = ?';
        $params = array($this->nombre_madre, $this->direccion_madre, $this->telefono_madre, $this->nombre_padre, $this->direccion_padre, $this->telefono_padre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM pruebas
                WHERE idprueba = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
