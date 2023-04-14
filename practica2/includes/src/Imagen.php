<?php

namespace escoli;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Imagen
{

    public static function crea($nombre, $mimeType, $ruta)
    {
        $imagen = new Imagen($ruta, $nombre, $mimeType);
        return $imagen;
    }

    public static function listaImagenes()
    {
        return self::getImagenes();
    }

    private static function getImagenes()
    {
        $result = [];

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Imagenes';
        
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Imagen($fila['ruta'], $fila['nombre'], $fila['mimeType'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log($conn->error);
        }

        return $result;
    }

    public static function buscaPorId($idImagen)
    {
        $result = null;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM Imagenes I WHERE I.id = %d', intval($idImagen));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result = new Imagen($fila['ruta'], $fila['nombre'], $fila['mimeType'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log($conn->error);
        }

        return $result;
    }

    private static function inserta($imagen)
    {
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Imagenes (ruta, nombre, mimeType) VALUES ('%s', '%s', '%s')",
            $conn->real_escape_string($imagen->ruta),
            $conn->real_escape_string($imagen->nombre),
            $conn->real_escape_string($imagen->mimeType),
        );

        $result = $conn->query($query);
        if ($result) {
            $imagen->id = $conn->insert_id;
            $result = $imagen;
        } else {
            error_log($conn->error);
        }

        return $result;
    }

    private static function actualiza($imagen)
    {
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Imagenes I SET ruta = '%s', nombre = '%s', mimeType = '%s' WHERE I.id = %d",
            $conn->real_escape_string($imagen->ruta),
            $conn->real_escape_string($imagen->nombre),
            $conn->real_escape_string($imagen->mimeType),
            $imagen->id
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han actualizado '$conn->affected_rows' !");
        }

        return $result;
    }

    private static function borra($imagen)
    {
        return self::borraPorId($imagen->id);
    }

    private static function borraPorId($idImagen)
    {
        $result = false;

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Imagenes WHERE id = %d", intval($idImagen));
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    private $id;

    private $ruta;

    private $nombre;

    private $mimeType;

    private function __construct($ruta, $nombre, $mimeType,  $id = NULL)
    {
        $this->ruta = $ruta;
        $this->nombre = $nombre;
        $this->mimeType = $mimeType;
        $this->id = intval($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function setRuta($nuevaRuta)
    {
        $this->ruta = $nuevaRuta;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nuevoNombre)
    {
        $this->nombre = $nuevoNombre;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function guarda()
    {
        if (!$this->id) {
            self::inserta($this);
        } else {
            self::actualiza($this);
        }

        return $this;
    }

    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}
