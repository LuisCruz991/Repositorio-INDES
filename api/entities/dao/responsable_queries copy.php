<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ResponsableQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = ' SELECT idresponsable, nombre_madre, direccion_madre, telefono_madre, nombre_padre, direccion_padre, telefono_padre
        FROM responsables
        WHERE nombre_madre LIKE ? OR direccion_madre LIKE ? OR telefono_madre LIKE ? OR nombre_padre LIKE ? OR direccion_padre LIKE ? OR telefono_padre LIKE ?
        ORDER BY idresponsable';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

 
    public function readAll()
    {
        $sql = ' SELECT idresponsable, nombre_madre, direccion_madre, telefono_madre, nombre_padre, direccion_padre, telefono_padre
        FROM responsables
        WHERE marca_obtenida ILIKE ? OR nombre_medida ILIKE ? OR posicion ILIKE ?
        ORDER BY idrecord';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT idresponsable, nombre_madre, direccion_madre, telefono_madre, nombre_padre, direccion_padre, telefono_padre
                FROM responsables
                WHERE idresponsable = ?';
        $params = array($this->id, $this->marca_obtenida, $this->unidad_medida, $this->atleta, $this->prueba, $this->posicion);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO responsables(nombre_madre, direccion_madre, telefono_madre, nombre_padre, direccion_padre, telefono_padre)
                VALUES(?,?,?,?,?,?)';
        $params = array($this->marca_obtenida, $this->unidad_medida, $this->atleta, $this->prueba, $this->posicion);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
       
        $sql = 'UPDATE responsables
                SET marca_obtenida = ? 
                WHERE idrecord = ?';
        $params = array($this->marca_obtenida, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM responsables
                WHERE idresponsable = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
