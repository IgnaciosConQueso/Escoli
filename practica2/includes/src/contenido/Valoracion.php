<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Valoracion
{
    use MagicProperties;

    private $id;
    private $idUsuario;
    private $idProfesor;
    private $idAsignatura;
    private $fecha;
    private $comentario;
    private $puntuacion;
    private $likes;

    public static function crea($idUsuario, $idProfesor, $idAsignatura, $comentario, $puntuacion, $likes = 0, $id = null)
    {
        $valoracion = new Valoracion
        ($idUsuario, $idProfesor, $idAsignatura, $comentario, $puntuacion, $likes, $id);
        return $valoracion->guarda();
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

    public static function buscaValoracion($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.id='%d'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['idAsignatura'], $fila['comentario'],
                    $fila['puntuacion'], $fila['likes'], $fila['id'], $fila['fecha']
                );
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    // busca todas las valoraciones de un usuario
    public static function buscaUltimasValoracionesUsuario($idUsuario, $numPorPagina, $numPagina)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.idUsuario='%d' ORDER BY V.fecha DESC", $conn->real_escape_string($idUsuario));
        $query .= sprintf(" LIMIT %d, %d", $conn->real_escape_string(($numPagina - 1) * $numPorPagina), $conn->real_escape_string($numPorPagina));
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['idAsignatura'], $fila['comentario'],
                    $fila['puntuacion'], $fila['likes'], $fila['id'], $fila['fecha']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    // busca las 5 valoraciones con mas likes de un usuario
    public static function buscaTopCincoValoraciones($idUsuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.idUsuario='%d' ORDER BY V.likes DESC LIMIT 5", $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);

        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['idAsignatura'], $fila['comentario'],
                    $fila['puntuacion'], $fila['likes'], $fila['id'], $fila['fecha']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    /* Suma los likes de todas las valoraciones de un usuario */
    public static function sumaLikes($idUsuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT SUM(V.likes) AS likes FROM Valoraciones V WHERE V.idUsuario='%d'", $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = $fila['likes'];
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaUltimasValoracionesFacultad($idFacultad, $numPorPagina, $numPagina)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT V.* FROM Valoraciones V
            JOIN Asignaturas A ON V.idAsignatura=A.id
            WHERE A.idFacultad='%d' ORDER BY V.fecha DESC", $conn->real_escape_string($idFacultad));
        $query .= sprintf(" LIMIT %d, %d;", ($numPagina - 1) * $numPorPagina, $numPorPagina);
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['idAsignatura'], $fila['comentario'],
                    $fila['puntuacion'], $fila['likes'], $fila['id'], $fila['fecha']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaUltimasValoraciones($numPorPagina, $numPagina)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V ORDER BY V.fecha DESC");
        $query .= sprintf(" LIMIT %d, %d;", ($numPagina - 1) * $numPorPagina, $numPorPagina);
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['idAsignatura'], $fila['comentario'],
                    $fila['puntuacion'], $fila['likes'], $fila['id'], $fila['fecha']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function ultimasValoracionesProfesor($idProfesor, $numPorPagina, $numPagina)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.idProfesor='%d' ORDER BY V.fecha DESC", $conn->real_escape_string($idProfesor));
        $query .= sprintf(" LIMIT %d , %d;", ($numPagina - 1) * $numPorPagina, $numPorPagina);
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['idAsignatura'], $fila['comentario'],
                    $fila['puntuacion'], $fila['likes'], $fila['id'], $fila['fecha']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function ultimasValoracionesAsignatura($idAsignatura, $numPorPagina, $numPagina)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.idAsignatura='%d' ORDER BY V.fecha DESC", $conn->real_escape_string($idAsignatura));
        $query .= sprintf(" LIMIT %d , %d;", ($numPagina - 1) * $numPorPagina, $numPorPagina);
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['idAsignatura'], $fila['comentario'],
                    $fila['puntuacion'], $fila['likes'], $fila['id'], $fila['fecha']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function mediaValoracionesProfesor($idProfesor)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT AVG(V.puntuacion) AS media FROM Valoraciones V WHERE V.idProfesor='%d'", $conn->real_escape_string($idProfesor));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = $fila['media'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function actualiza($Valoracion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Valoraciones V SET idUsuario = '%d', idProfesor='%d', idAsignatura='%d', comentario = '%s', puntuacion = '%d', likes = %d WHERE V.id=%d",
            $conn->real_escape_string($Valoracion->idUsuario),
            $conn->real_escape_string($Valoracion->idProfesor),
            $conn->real_escape_string($Valoracion->idAsignatura),
            $conn->real_escape_string($Valoracion->comentario),
            $conn->real_escape_string($Valoracion->puntuacion),
            $conn->real_escape_string($Valoracion->likes),
            $Valoracion->id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    private static function inserta($Valoracion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Valoraciones(idUsuario, idProfesor, idAsignatura, comentario, puntuacion) 
            VALUES ('%d', '%d', '%d', '%s', '%d')",
            $conn->real_escape_string($Valoracion->idUsuario),
            $conn->real_escape_string($Valoracion->idProfesor),
            $conn->real_escape_string($Valoracion->idAsignatura),
            $conn->real_escape_string($Valoracion->comentario),
            $conn->real_escape_string($Valoracion->puntuacion)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else {
            $Valoracion->id = $conn->insert_id;
            $result = $Valoracion;
        }
        return $result;
    }


    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }


    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        }
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM Valoraciones V WHERE V.id = %d"
            ,
            $id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function actualizaLikes($id, $likes)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Valoraciones V SET likes = %d WHERE V.id=%d",
            $likes,
            $id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private function __construct($idUsuario, $idProfesor, $idAsignatura, $comentario, $puntuacion, $likes = 0, $id = null, $fecha = null)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idProfesor = $idProfesor;
        $this->idAsignatura = $idAsignatura;
        $this->fecha = $fecha;
        $this->comentario = $comentario;
        $this->puntuacion = $puntuacion;
        $this->likes = $likes;
    }

    public function getId(){return $this->id;}
    public function getIdUsuario(){return $this->idUsuario;}
    public function getIdProfesor(){return $this->idProfesor;}
    public function getIdAsignatura(){return $this->idAsignatura;}
    public function getFecha(){return $this->fecha;}
    public function getComentario(){return $this->comentario;}
    public function getPuntuacion(){return $this->puntuacion;}
    public function getLikes(){return $this->likes;}


}

?>