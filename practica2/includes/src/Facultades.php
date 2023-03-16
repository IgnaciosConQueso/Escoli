<?

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Facultades{
    use MagicProperties;

    public static function crea($id, $nombre, $idUniversidad){
        $facultad = new Facultades($id, $nombre, $idUniversidad);
        return $facultad->guarda();
    }

    public function guarda(){
        if($this->id !== null){
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public function borrate(){
        if($this->id !== null){
            return self::borra($this);
        }
        return false;
    }
    //revisar
    public static function buscaFacultad($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Facultades F WHERE F.id='%i'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if($rs){
            $fila = $rs->fetch_assoc();
            if($fila){
                $result = new Facultades($fila['id'], $fila['nombre'], $fila['idUniversidad']);
            }
            $rs->free();
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    //revisar
    private static function actualiza($facultad){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Facultades F SET F.nombre='%s', F.idUniversidad='%i' WHERE F.id='%i'"
            , $conn->real_escape_string($facultad->nombre)
            , $conn->real_escape_string($facultad->idUniversidad)
            , $conn->real_escape_string($facultad->id));
        if ( !$conn->query($query) ) {
            error_log("Error al actualizar la facultad: {$conn->errno} {$conn->error}");
        } 
        return $result;
    }
    //revisar
    private static function inserta($facultad){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Facultades(nombre, idUniversidad) VALUES('%s', '%i')"
            , $conn->real_escape_string($facultad->nombre)
            , $conn->real_escape_string($facultad->idUniversidad));
        if ( !$conn->query($query) ) {
            error_log("Error al insertar la facultad: {$conn->errno} {$conn->error}");
        }
        return $result;

    }
    //revisar
    private static function borra($facultad){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("DELETE FROM Facultades F WHERE F.id='%i'"
            , $conn->real_escape_string($facultad->id));
        if ( !$conn->query($query) ) {
            error_log("Error al borrar la facultad: {$conn->errno} {$conn->error}");
        }
        return $result;
    }

    private $id;

    private $nombre;

    private $idUniversidad;

    private function __construct($id, $nombre, $idUniversidad){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->idUniversidad = $idUniversidad;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getIdUniversidad(){
        return $this->idUniversidad;
    }
}
