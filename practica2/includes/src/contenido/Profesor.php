<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Profesor
{
    use MagicProperties;

    public static function crea($nombre)
    {
        $profesor = new Profesor($nombre);
        return $profesor->guarda();
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

    public static function buscaProfesoresPorIdFacultad($idFacultad){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT P.id, P.nombre FROM Profesores P
            JOIN Asignaturas A ON P.id = A.idProfesor
            WHERE A.idFacultad = '%d'",
            filter_var($idFacultad, FILTER_SANITIZE_NUMBER_INT));
        
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Profesor($fila['nombre'], $fila['id']);
                array_push($result, $profesor);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }

    private static function actualiza($profesor)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Profesores SET nombre='%s', idFacultad='%d' WHERE id='%d'", $conn->real_escape_string($profesor->nombre), filter_var($profesor->idFacultad, FILTER_SANITIZE_NUMBER_INT), filter_var($profesor->id, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    private static function inserta($profesor)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Profesores(nombre, idFacultad) VALUES('%s', '%d')", $conn->real_escape_string($profesor->nombre), filter_var($profesor->idFacultad, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            $profesor->id = $conn->insert_id;
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    private static function borra($profesor)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM Profesores WHERE id='%d'"
            , filter_var($profesor->id, FILTER_SANITIZE_NUMBER_INT));
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private $id;

    private $nombre;

    private function __construct($nombre, $id = null)
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

?>