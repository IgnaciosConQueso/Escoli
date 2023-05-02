<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;


class LikesyKarma
{
    use MagicProperties;

    private $id;

    private $idUsuario;

    private $idValoracion;

    private $valor;

    public static function crea($idUsuario, $idValoracion, $valor, $id = null){
        $karma = new LikesyKarma ($idUsuario, $idValoracion, $valor, $id);
        return $karma->guarda();
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

    private static function actualiza($Karma)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Karma K SET K.valor=%d WHERE K.idUsuario=%d AND K.idValoracion = %d",
            filter_var($Karma->valor),
            filter_var($Karma->idUsuario),
            filter_var($Karma->idValoracion)
            
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($Karma)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Karma(idUsuario, idValoracion, valor) 
            VALUES ('%d', '%d', '%d')",
           filter_var($Karma->idUsuario),
           filter_var($Karma->idValoracion),
           filter_var($Karma->valor)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } else {
            $result = true;
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
            "DELETE FROM Karma K WHERE K.id = %d"
            ,
            $id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function checkLike($idUsuario, $idValoracion, $valor){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Karma K WHERE K.idUsuario='%d' AND K.idValoracion=%d",
         $conn->real_escape_string($idUsuario),
         $conn->real_escape_string($idValoracion)
        );
        $rs = $conn->query($query);
        $result = NULL;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new LikesyKarma
                ($fila['idUsuario'],$fila['idValoracion'],$fila['valor'],$fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        if($result->id == NULL){
            LikesyKarma :: crea($idUsuario,$idValoracion,$valor, NULL);
            return true;
        } else if($result->valor != $valor){ //no se por aqui esta casi casi no se que puede fallar.
            $result->valor = $valor;
            LikesyKarma :: actualiza($result);
            return true;
        }
        return false;
    }

    public static function existeLike($idUsuario, $idValoracion)
    {
        $salida = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Karma K WHERE K.idUsuario='%d' AND K.idValoracion=%d",
         $conn->real_escape_string($idUsuario),
         $conn->real_escape_string($idValoracion)
        );
        $rs = $conn->query($query);
        if ($rs) {
            $salida = true;
            $rs->free();
        } 
        return $salida;
    }

    public static function valorLike($idUsuario, $idValoracion)
    {
        $valor = 0;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Karma K WHERE K.idUsuario='%d' AND K.idValoracion=%d",
         $conn->real_escape_string($idUsuario),
         $conn->real_escape_string($idValoracion)
        );
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $valor = $fila['valor'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $valor;
    }


    private function __construct( $idUsuario, $idValoracion, $valor,$id = null)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idValoracion = $idValoracion;
        $this->valor = $valor;
    }

}