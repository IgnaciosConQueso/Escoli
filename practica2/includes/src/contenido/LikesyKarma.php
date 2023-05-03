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
            return self::actualiza($this->idUsuario, $this->idValoracion, $this->valor);
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

    private static function actualiza($idUsuario, $idValoracion, $valor)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Karma K SET K.valor=%d WHERE K.idUsuario=%d AND K.idValoracion = %d",
            filter_var($valor),
            filter_var($idUsuario),
            filter_var($idValoracion)
            
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            file_put_contents("falloBD.txt",$query);
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
            file_put_contents("falloBD.txt",$query);
        } else {
            $result = true;
            file_put_contents("falloBD.txt",$query);
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
            $fila = $rs->fetch_assoc();
            if ($fila)
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
            file_put_contents("falloBD.txt",$query ."   ". $valor);
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $valor;
    }

    public static function hazLike($idUsuario, $idValoracion, $valor)
    {
        
        if(self :: existeLike($idUsuario, $idValoracion) === false){
            file_put_contents("falloLyK.txt","no encuentra el like");
            self :: crea($idUsuario,$idValoracion,$valor, NULL);
            return;
        }
        self:: actualiza($idUsuario, $idValoracion, $valor);
    }

    private function __construct( $idUsuario, $idValoracion, $valor,$id = null)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idValoracion = $idValoracion;
        $this->valor = $valor;
    }

}