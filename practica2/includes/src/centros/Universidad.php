<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Universidad
{
    use MagicProperties;

    public static function crea($nombre)
    {
        $universidad = new Universidad($nombre);
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

    //es posible que no este bien
    public static function buscaPorNombre($nombre)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM universidades WHERE nombre='%i'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Universidad($fila['nombre'], $fila['id']);
            }
            $rs->free();
        } else {
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
                $universidad = new Universidad($fila['nombre'], $fila['id']);
                array_push($result, $universidad);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //revisar tambien
    private static function actualiza($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE universidades SET nombre='%s' WHERE id='%d'", $conn->real_escape_string($universidad->nombre), $conn->real_escape_string($universidad->id));
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    //revisar
    private static function inserta($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO universidades (id, nombre) VALUES('%i', '%s')", $conn->real_escape_string($universidad->id), $conn->real_escape_string($universidad->nombre));
        if ($conn->query($query)) {
            $universidad->id = $conn->insert_id;
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    //revisar
    private static function borra($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM universidades WHERE id='%i'", $conn->real_escape_string($universidad->id));
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    private $id;

    private $nombre;

    private function __construct($nombre, $id=null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
}