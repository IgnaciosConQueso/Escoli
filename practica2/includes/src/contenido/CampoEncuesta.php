<?php
namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class CampoEncuesta{
    use MagicProperties;

    public $id;
    public $idEncuesta;
    public $campo;
    public $votos;

    public static function crea($idEncuesta, $campo, $votos = 0, $id = null){
        $campoEncuesta = new CampoEncuesta($idEncuesta, $campo, $votos, $id);
        return $campoEncuesta->guarda($campoEncuesta);
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public static function inserta($campoEncuesta){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO CamposEncuestas (idEncuesta, campo, votos) VALUES (%d, '%s', %d)",
            filter_var($campoEncuesta->idEncuesta, FILTER_SANITIZE_NUMBER_INT),
            $conn->real_escape_string($campoEncuesta->campo),
            filter_var($campoEncuesta->votos, FILTER_SANITIZE_NUMBER_INT)
        );
        if ($conn->query($query)) {
            $campoEncuesta->id = $conn->insert_id;
            $result = $campoEncuesta;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function actualiza($campoEncuesta){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE CamposEncuestas SET idEncuesta='%d', campo='%s', votos='%d' WHERE id='%d'",
            filter_var($campoEncuesta->idEncuesta, FILTER_SANITIZE_NUMBER_INT),
            $conn->real_escape_string($campoEncuesta->campo),
            filter_var($campoEncuesta->votos, FILTER_SANITIZE_NUMBER_INT),
            filter_var($campoEncuesta->id, FILTER_SANITIZE_NUMBER_INT)
        );
        if ($conn->query($query)) {
            $result = $campoEncuesta;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM CamposEncuestas WHERE id='%d'", filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $result = new CampoEncuesta($fila['idEncuesta'],$fila['campo'], $fila['votos'] , $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorEncuesta($idEncuesta){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM CamposEncuestas WHERE idEncuesta='%d'", filter_var($idEncuesta, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while($fila = $rs->fetch_assoc()){
                $campo = new CampoEncuesta($fila['idEncuesta'],$fila['campo'], $fila['votos'] , $fila['id']);
                array_push($result, $campo);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function vota($idUsuario, $idEncuesta, $idCampo){
        $voto = self::buscaPorUsuarioEncuesta($idUsuario, $idEncuesta);
        if($voto){
            return self::actualizarVoto($idUsuario, $idEncuesta, $idCampo);
        }else{
            return self::insertarVoto($idUsuario, $idEncuesta, $idCampo);
        }
    }

    private static function insertarVoto($idUsuario, $idEncuesta, $idCampo){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO VotosEncuesta (idUsuario, idEncuesta, idCampo) VALUES (%d, %d, %d)",
            filter_var($idUsuario, FILTER_SANITIZE_NUMBER_INT),
            filter_var($idEncuesta, FILTER_SANITIZE_NUMBER_INT),
            filter_var($idCampo, FILTER_SANITIZE_NUMBER_INT)
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function actualizarVoto($idUsuario, $idEncuesta, $idCampo){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE VotosEncuesta SET idCampo='%d' WHERE idUsuario='%d' AND idEncuesta='%d'",
            filter_var($idCampo, FILTER_SANITIZE_NUMBER_INT),
            filter_var($idUsuario, FILTER_SANITIZE_NUMBER_INT),
            filter_var($idEncuesta, FILTER_SANITIZE_NUMBER_INT)
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorUsuarioEncuesta($idUsuario, $idEncuesta){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM VotosEncuesta WHERE idUsuario='%d' AND idEncuesta='%d'", filter_var($idUsuario, FILTER_SANITIZE_NUMBER_INT), filter_var($idEncuesta, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = true;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private function __construct($idEncuesta, $campo, $votos, $id = null){

        $this->id = $id;
        $this->idEncuesta = $idEncuesta;
        $this->campo = $campo;
        $this->votos = $votos;
    }

    public function getId(){return $this->id;}
    public function getIdEncuesta(){return $this->idEncuesta;}
    public function getCampo(){return $this->campo;}
    public function getVotos(){return $this->votos;}
}


?>