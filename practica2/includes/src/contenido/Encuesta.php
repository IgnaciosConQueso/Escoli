<?

namespace escoli\contenido;

use escoli\Aplicacion;
use escoli\MagicProperties;

class Encuesta{
    use MagicProperties;

    private $opciones;
    private $id;
    private $idUsuario;

    private function __construct($idUsuario, $opciones, $id = null){
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->opciones = $opciones;
    }

    public static function crea($idUsuario, $opciones, $id = null){
        $encuesta = new Encuesta($idUsuario, $opciones, $id);
        return $encuesta->guarda();
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public static function inserta($encuesta){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Encuestas (idUsuario) VALUES (%d)",
            filter_var($encuesta->idUsuario, FILTER_SANITIZE_NUMBER_INT)
        );
        if ($conn->query($query)) {
            $encuesta->id = $conn->insert_id;
            $result = true;
            self::insertaOpciones($encuesta->id,$encuesta->opciones);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            file_put_contents("falloBD.txt",$query);
        }
        return $result;
    }

    public static function actualiza($encuesta){

    }

    private static function insertaOpciones($id,$opciones){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;
        foreach($opciones as $opcion){
            $query = sprintf(
                "INSERT INTO CampoEncuestas (idEncuesta, opcion) VALUES (%d, '%s', 0)",
                filter_var($id, FILTER_SANITIZE_NUMBER_INT),
                filter_var($opcion, FILTER_SANITIZE_STRING)
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
}
?>