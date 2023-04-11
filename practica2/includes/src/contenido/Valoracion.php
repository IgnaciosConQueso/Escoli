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

    private $fecha;

    private $comentario;

    private $puntuacion;

    private $likes;

    public static function crea($idUsuario, $idProfesor, $fecha, $comentario, $puntuacion, $likes)
    {
        $valoracion = new Valoracion
        ($idUsuario, $idProfesor, $fecha, $comentario, $puntuacion, $likes);
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

    public static function buscaValoracion($idProfesor)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.idProfesor='%i'", $conn->real_escape_string($idProfesor));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Valoracion
                ($fila['idUsuario'], $fila['idProfesor'], $fila['fecha'], $fila['comentario'], $fila['puntuacion'], $fila['likes']
                , $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //busca todas las valoraciones de profesores pertenecientes a esa facultad
    public static function buscaValoracionPorIdProfesor($idFacultad)
    {

    }

    // busca todas las valoraciones de un usuario
    public static function buscaValoracionesPorIdUsuario($idUsuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.idUsuario='%d' ", $conn->real_escape_string($idUsuario));

        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['fecha'], $fila['comentario'], $fila['puntuacion'], $fila['likes'],
                    $fila['id']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

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
                    $fila['idUsuario'], $fila['idProfesor'], $fila['fecha'], $fila['comentario'], $fila['puntuacion'], $fila['likes'],
                    $fila['id']
                );
                array_push($result, $valoracion);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaUltimasValoraciones($idFacultad, $numPorPagina, $numPagina)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT V.* FROM `Valoraciones` V
            JOIN `Asignaturas` A ON V.idProfesor = A.idProfesor
            WHERE A.idFacultad = %d
            GROUP BY V.id ORDER BY V.fecha ASC", $idFacultad);
        $query .= sprintf(" LIMIT %d, %d;", ($numPagina - 1) * $numPorPagina, $numPorPagina);

        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $valoracion = new Valoracion(
                    $fila['idUsuario'], $fila['idProfesor'], $fila['fecha'], $fila['comentario'], $fila['puntuacion'], $fila['likes'],
                    $fila['id']
                );
                array_push($result, $valoracion);
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
            "UPDATE Valoraciones V SET idUsuario = '%d', idProfesor='%d', comentario = '%s', puntuacion = '%d', likes = %d WHERE V.id=%d",
            $conn->real_escape_string($Valoracion->idUsuario),
            $conn->real_escape_string($Valoracion->idProfesor),
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
        $query = sprintf("INSERT INTO Valoraciones(id, idUsuario, idProfesor, comentario, puntuacion, likes) 
            VALUES ('%i', '%i', '%i', '%s','%i', '%i')",
            $Valoracion->id,
            $conn->real_escape_string($Valoracion->idUsuario),
            $conn->real_escape_string($Valoracion->idProfesor),
            $conn->real_escape_string($Valoracion->comentario),
            $conn->real_escape_string($Valoracion->puntuacion),
            $conn->real_escape_string($Valoracion->likes)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
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

    public static function darLike($valoracion){
        $valoracion->aumentaLikes();
    }

    private function aumentaLikes()
    {
        $this->likes++;
        $this->actualiza($this); 
    }

    public static function dislike($valoracion){
        $valoracion->quitaLikes();
    }

    private function quitaLikes()
    {
        $this->likes--;
        $this->actualiza($this); 
    }

    private function __construct($idUsuario, $idProfesor, $fecha, $comentario, $puntuacion, $likes, $id = null)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idProfesor = $idProfesor;
        $this->fecha = $fecha;
        $this->comentario = $comentario;
        $this->puntuacion = $puntuacion;
        $this->likes =$likes;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getIdProfesor()
    {
        return $this->idProfesor;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    public function getLikes(){
        return $this->likes;
    }

    
}

?>