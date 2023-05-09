<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Asignatura
{
    use MagicProperties;

    public static function crea($nombre, $idFacultad)
    {
        $asignatura = new Asignatura($nombre, $idFacultad);
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

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE id='%d'", filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $result = new Asignatura($fila['nombre'], $fila['idFacultad'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    
    public static function buscaAsignaturasPorIdFacultad($idFacultad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE idFacultad='%d'", filter_var($idFacultad, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $asignatura = new Asignatura($fila['nombre'], $fila['idFacultad'], $fila['id']);
                array_push($result, $asignatura);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorNombre($nombre){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE nombre='%s'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        $result = false;
        if($rs){
            $result = array();
            while($fila = $rs->fetch_assoc()){
                $asignatura = new Asignatura($fila['nombre'], $fila['idProfesor'], $fila['idFacultad'], $fila['id']);
                array_push($result, $asignatura);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaAsignaturasProfesor($idProfesor)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT A.* FROM Imparte I 
                        JOIN Asignaturas A ON I.idAsignatura = A.Id
                            WHERE I.idProfesor='%d'" , filter_var($idProfesor, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $asignatura = new Asignatura($fila['nombre'], $fila['idFacultad'], $fila['id']);    
                array_push($result, $asignatura);
            }
            $rs->free();
        } else {
            error_log("Error al consultar en la BD: {$conn->error}");
        }
        return $result;
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
            filter_var($profesor->id, FILTER_SANITIZE_NUMBER_INT)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private $id;
    private $nombre;
    private $idFacultad;

    public function __construct($nombre, $idFacultad, $id = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
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

    public function getIdFacultad()
    {
        return $this->idFacultad;
    }
}

?>