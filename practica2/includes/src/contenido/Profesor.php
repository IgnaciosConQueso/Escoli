<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Profesor
{
    use MagicProperties;

    public static function crea($nombre, $idImagen = null)
    {
        $profesor = new Profesor($nombre, $idImagen);
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

    public static function buscaProfesoresPorIdFacultad($idFacultad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT P.id, P.nombre FROM Profesores P
            JOIN Asignaturas A ON P.id = A.idProfesor
            WHERE A.idFacultad = '%d'
            GROUP BY P.id",
            filter_var($idFacultad, FILTER_SANITIZE_NUMBER_INT)
        );

        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Profesor($fila['nombre'], $fila['idImagen'], $fila['id']);
                array_push($result, $profesor);
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
        $query = sprintf("SELECT * FROM Profesores WHERE id='%d'", filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $profesor = new Profesor($fila['nombre'], $fila['idImagen'], $fila['id']);
                $result = $profesor;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaProfesorQueImpartaAsignatura($idAsignatura)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT P.* FROM Imparte I 
                        JOIN Profesores P ON I.idProfesor = P.Id
                        WHERE I.idAsignatura='%d'" , filter_var($idAsignatura, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Profesor($fila['nombre'], $fila['idImagen'] ,$fila['id']);    
                array_push($result, $profesor);
            }
            $rs->free();
        } else {
            error_log("Error al consultar en la BD: {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorNombre($nombre){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Profesores WHERE nombre='%s'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        $result = false;
        if($rs){
            if($fila = $rs->fetch_assoc()){
                $profesor = new Profesor($fila['nombre'], $fila['idImagen'], $fila['id']);
                $result = $profesor;
            }
            $rs->free();
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function actualiza($profesor)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Profesores SET nombre='%s', idImagen='%d' WHERE id='%d'",
            $conn->real_escape_string($profesor->nombre),
            filter_var($profesor->idImagen, FILTER_SANITIZE_NUMBER_INT),
            filter_var($profesor->id, FILTER_SANITIZE_NUMBER_INT)
        );
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    public static function getProfesoresAsignatura($idAsignatura)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT P.id, P.nombre FROM Profesores P
            JOIN Imparte I ON P.id = I.idProfesor
            WHERE I.idAsignatura = '%d'
            GROUP BY P.id",
            filter_var($idAsignatura, FILTER_SANITIZE_NUMBER_INT)
        );
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Profesor($fila['nombre'], $fila['idImagen'], $fila['id']);
                array_push($result, $profesor);
            }
            $rs->free();
        } else {
            error_log("Error al consultar en la BD: {$conn->error}");
        }
        return $result;
    }

    private static function inserta($profesor)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Profesores(nombre, idImagen) VALUES('%s', '%d')", $conn->real_escape_string($profesor->nombre), filter_var($profesor->idImagen, FILTER_SANITIZE_NUMBER_INT));
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

    private $idImagen;

    private function __construct($nombre, $idImagen = null, $id = null)
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