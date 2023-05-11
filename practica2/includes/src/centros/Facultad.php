<?php

namespace escoli\centros;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Facultad
{
    use MagicProperties;

    public static function crea($nombre, $idUniversidad, $idImagen = null, $id = null)
    {
        $facultad = new Facultad($nombre, $idUniversidad, $id, $idImagen);
        return $facultad->guarda();
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

    public static function buscaFacultades($idUniversidad)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Facultades F WHERE F.idUniversidad='%d'", filter_var($idUniversidad, FILTER_SANITIZE_NUMBER_INT));

        $rs = $conn->query($query);

        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $facultad = new Facultad($fila['nombre'], $fila['idUniversidad'], $fila['id'], $fila['idImagen']);
                array_push($result, $facultad);
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
        $query = sprintf("SELECT * FROM Facultades
            WHERE nombre LIKE '%s'",
            $conn->real_escape_string($busqueda));
        $rs = $conn->query($query);
        $result = false;
        if($rs){
            $result = array();
            while($fila = $rs->fetch_assoc()){
                $facultad = new Facultad($fila['nombre'], $fila['idUniversidad'], $fila['id'], $fila['idImagen']);
                array_push($result, $facultad);
            }
            $rs->free();
        }
        else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorNombreYUniversidad($nombre, $idUniversidad){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Facultades
            WHERE nombre='%s' AND idUniversidad='%d'",
            $conn->real_escape_string($nombre),
            $conn->real_escape_string($idUniversidad));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Facultad($fila['nombre'], $fila['idUniversidad'], $fila['id'], $fila['idImagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Facultades WHERE id='%d'", filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Facultad($fila['nombre'], $fila['idUniversidad'], $fila['id'], $fila['idImagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function actualiza($facultad)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Facultades F
                SET F.nombre='%s', F.idUniversidad='%d', F.idImagen='%d' WHERE F.id='%i'"
            , $conn->real_escape_string($facultad->nombre)
            , $conn->real_escape_string($facultad->idUniversidad)
            , $conn->real_escape_string($facultad->id)
            , $conn->real_escape_string($facultad->idImagen)
        );
        if (!$conn->query($query)) {
            error_log("Error al actualizar la facultad: {$conn->errno} {$conn->error}");
        }
        return $result;
    }

    private static function inserta($facultad)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        if (!isset($facultad->idImagen)){
            $query = sprintf("INSERT INTO Facultades (nombre, idUniversidad) VALUES('%s', '%d')",
                $conn->real_escape_string($facultad->nombre),
                filter_var($facultad->idUniversidad, FILTER_SANITIZE_NUMBER_INT)
            );
        }
        else{
            $query = sprintf("INSERT INTO Facultades (nombre, idUniversidad, idImagen) VALUES('%s', '%d', '%d')",
                $conn->real_escape_string($facultad->nombre),
                filter_var($facultad->idUniversidad, FILTER_SANITIZE_NUMBER_INT),
                filter_var($facultad->idImagen, FILTER_SANITIZE_NUMBER_INT)
            );
        }

        if ($conn->query($query)) {
            $facultad->id = $conn->insert_id;
            $result = $facultad;
        }
        else{
            error_log("Error al insertar la facultad: {$conn->errno} {$conn->error}");
        }
        return $result;

    }

    private static function borra($facultad)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Facultades
            WHERE id='%d'", filter_var($facultad->id, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error al borrar la facultad: {$conn->errno} {$conn->error}");
        }
        return $result;
    }

    private $id;

    private $nombre;

    private $idUniversidad;

    private $idImagen;


    private function __construct($nombre, $idUniversidad, $id = null, $idImagen = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->idUniversidad = $idUniversidad;
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

    public function getIdUniversidad()
    {
        return $this->idUniversidad;
    }

    public function getIdImagen()
    {
        return $this->idImagen;
    }
}

?>