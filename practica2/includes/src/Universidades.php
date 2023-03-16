<?

//esto es un aparoximacion de lo que puede ser la clase, sientete libre de cambiarlo como quieras.
//Igual piensa que si quisieramos podríamos reciclar esta clase y hacerla abstracta para poder hacer reviews de otras cosas como facultades.

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;



class Universidades
{
    use MagicProperties;

     //AVISO ESTOY USANDO DATE COMO UN STRING PORQUE ESTOY PROTOTIPANDO !!!!

    public static function crea($id, $nombre)
    {
        $universidad = new Universidades($id, $nombre);
        return $universidad->guarda();
    }

    public static function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public static function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }

    //es posible que no este bien
    public static function buscaUniversidad($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM universidades WHERE id='%i'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Universidades($fila['id'], $fila['nombre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //revisar tambien
    private static function actualiza($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE universidades SET nombre='%s' WHERE id='%i'", $conn->real_escape_string($universidad->nombre), $conn->real_escape_string($universidad->id));
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    //revisar
    private static function inserta($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO universidades (id, nombre) VALUES('%i', '%s')", $conn->real_escape_string($universidad->id), $conn->real_escape_string($universidad->nombre));
        if ($conn->query($query)) {
            $universidad->id = $conn->insert_id;
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    //revisar
    private static function borra($universidad)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM universidades WHERE id='%i'", $conn->real_escape_string($universidad->id));
        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    private $id;

    private $nombre;

    private function __construct($id, $nombre)
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