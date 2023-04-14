<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Asignatura
{
    use MagicProperties;

    public static function crea($nombre, $idProfesor, $idFacultad)
    {
        $asignatura = new Asignatura($nombre, $idProfesor, $idFacultad);
        return $asignatura->guarda();
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

    private static function actualiza($asignatura)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Asignaturas SET nombre='%s', idProfesor='%d', idFacultad='%d' WHERE id='%d'", $conn->real_escape_string($asignatura->nombre), filter_var($asignatura->idProfesor, FILTER_SANITIZE_NUMBER_INT), filter_var($asignatura->idFacultad, FILTER_SANITIZE_NUMBER_INT), filter_var($asignatura->id, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            return true;
        }
        error_log("Error BD ({$conn->errno}): {$conn->error}");
        return false;
    }

    private static function inserta($asignatura)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Asignaturas(nombre, idProfesor, idFacultad) VALUES('%s', '%d', '%d')", $conn->real_escape_string($asignatura->nombre), filter_var($asignatura->idProfesor, FILTER_SANITIZE_NUMBER_INT), filter_var($asignatura->idFacultad, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            $asignatura->id = $conn->insert_id;
            return true;
        }
        error_log("Error BD ({$conn->errno}): {$conn->error}");
        return false;
    }

    private static function borra($profesor)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM Asignaturas WHERE id='%d'"
            ,
            filter_var($profesor->id, FILTER_SANITIZE_NUMBER_INT));
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private $id;
    private $nombre;
    private $idProfesor;
    private $idFacultad;

    public function __construct($nombre, $idProfesor, $idFacultad, $id = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->idProfesor = $idProfesor;
        $this->idFacultad = $idFacultad;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getIdProfesor()
    {
        return $this->idProfesor;
    }

    public function getIdFacultad()
    {
        return $this->idFacultad;
    }
}

?>