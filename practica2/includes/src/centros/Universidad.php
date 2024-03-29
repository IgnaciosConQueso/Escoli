<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Universidad
{
    use MagicProperties;

    public static function crea($nombre, $idImagen = null, $id = null)
    {
        $universidad = new Universidad($nombre, $id, $idImagen);
        return $universidad->guarda();
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Universidades WHERE id='%d'", filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Universidad($fila['nombre'], $fila['id'], $fila['idImagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorNombre($nombre)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Universidades WHERE nombre='%s'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Universidad($fila['nombre'], $fila['id'], $fila['idImagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorNombreSimilar($nombre){
        $busqueda = "%".$nombre."%";

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Universidades
            WHERE nombre LIKE '%s'",
            $conn->real_escape_string($busqueda));
        $rs = $conn->query($query);
        $result = false;
        if($rs){
            $result = array();
            while($fila = $rs->fetch_assoc()){
                $universidad = new Universidad($fila['nombre'], $fila['id'], $fila['idImagen']);
                array_push($result, $universidad);
            }
            $rs->free();
        }
        else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaUniversidades()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Universidades U ORDER BY U.nombre");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $universidad = new Universidad($fila['nombre'], $fila['id'], $fila['idImagen']);
                array_push($result, $universidad);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    
    private static function borra($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Universidades WHERE id='%d'", filter_var($universidad->id, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    private static function actualiza($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Universidades SET nombre='%s', idImagen='%d' WHERE id='%d'",
        $conn->real_escape_string($universidad->nombre),
        $conn->real_escape_string($universidad->idImagen), 
        filter_var($universidad->id, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    private static function inserta($universidad)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        if (!isset($universidad->idImagen)) {
            $query = sprintf("INSERT INTO Universidades (nombre) VALUES('%s')",
                $conn->real_escape_string($universidad->nombre));
        }
        else{
            $query = sprintf("INSERT INTO Universidades (nombre, idImagen) VALUES('%s', '%d')",
                $conn->real_escape_string($universidad->nombre),
                filter_var($universidad->idImagen, FILTER_SANITIZE_NUMBER_INT));
        }
        if ($conn->query($query)) {
            $universidad->id = $conn->insert_id;
            $result = $universidad;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    

    private $id;

    private $nombre;

    private $idImagen;

    private function __construct($nombre, $id = null, $idImagen = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->idImagen = $idImagen;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getIdImagen()
    {
        return $this->idImagen;
    }
}

?>