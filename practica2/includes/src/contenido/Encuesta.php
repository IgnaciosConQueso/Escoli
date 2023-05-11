<?php

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Encuesta{
    use MagicProperties;

    private $id;
    private $titulo;
    private $idUsuario;
    private $opciones;
    private $idFacultad;
    private $fecha;

    public static function crea($idUsuario, $idFacultad, $titulo, $opciones, $id = null){
        $encuesta = new Encuesta($idUsuario, $idFacultad, $titulo, $opciones, $id);
        return $encuesta->guarda();
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return false;
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
        $query = sprintf("SELECT * FROM Encuestas WHERE id='%d'", filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $result = new Encuesta($fila['idUsuario'], $fila['idFacultad'], $fila['titulo'], null, $fila['id'], $fila['fecha']);
                $result->rellenaOpciones();
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorFacultad($idFacultad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Encuestas WHERE idFacultad='%d' ORDER BY fecha DESC", filter_var($idFacultad, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $encuesta = new Encuesta($fila['idUsuario'], $fila['idFacultad'], $fila['titulo'], null, $fila['id'], $fila['fecha']);
                $encuesta->rellenaOpciones();
                array_push($result, $encuesta);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function inserta($encuesta){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Encuestas (idUsuario, idFacultad, titulo) VALUES (%d, %d, '%s')",
            filter_var($encuesta->idUsuario, FILTER_SANITIZE_NUMBER_INT),
            filter_var($encuesta->idFacultad, FILTER_SANITIZE_NUMBER_INT),
            $conn->real_escape_string($encuesta->titulo)
        );
        if ($conn->query($query)) {
            $encuesta->id = $conn->insert_id;
            $result = true;
            self::insertaOpciones($encuesta->id,$encuesta->opciones);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function borra($encuesta){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Encuestas WHERE id='%d'", filter_var($encuesta->id, FILTER_SANITIZE_NUMBER_INT));
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function insertaOpciones($id,$opciones){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;
        foreach($opciones as $opcion){
            $query = sprintf(
                "INSERT INTO CamposEncuestas (idEncuesta, campo) VALUES (%d, '%s')",
                filter_var($id, FILTER_SANITIZE_NUMBER_INT),
                $conn->real_escape_string($opcion)
            );
            if ($conn->query($query)) {
                $result = true;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                file_put_contents("falloBD.txt",$query);
            }
        }
        return $result;
    }

    private function rellenaOpciones(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM CamposEncuestas WHERE idEncuesta='%d'", filter_var($this->id, FILTER_SANITIZE_NUMBER_INT));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $opciones = array();
            $result = array();
            while($fila = $rs->fetch_assoc()){
                $opciones['campo'] = $fila['campo'];
                $opciones['votos'] = $fila['votos'];
                array_push($result,$opciones);
            }
            $this->opciones = $result;
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private function __construct($idUsuario, $idFacultad, $titulo, $opciones, $id, $fecha = null){
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idFacultad = $idFacultad;
        $this->opciones = $opciones;
        $this->titulo = $titulo;
        $this->fecha = $fecha;
    }

    public function getId(){return $this->id;}
    public function getIdUsuario(){return $this->idUsuario;}
    public function getIdFacultad(){return $this->idFacultad;}
    public function getOpciones(){return $this->opciones;}
    public function getTitulo(){return $this->titulo;}
    public function getFecha(){return $this->fecha;}
}
?>