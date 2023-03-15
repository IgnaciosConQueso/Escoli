<?

//esto es un aparoximacion de lo que puede ser la clase, sientete libre de cambiarlo como quieras.
//Igual piensa que si quisieramos podríamos reciclar esta clase y hacerla abstracta para poder hacer reviews de otras cosas como facultades.

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;



class Review
{
    use MagicProperties;

     //AVISO ESTOY USANDO DATE COMO UN STRING PORQUE ESTOY PROTOTIPANDO !!!!

    public static function crea($id, $idUsuario, $idProfesor, $fecha, $comentario, $puntuacion)
    {
        $review = new Review($id, $idUsuario, $idProfesor, $fecha, $comentario, $puntuacion);
        return $review->guarda();
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

    public static function buscaReview($idProfesor)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Valoraciones V WHERE V.idProfesor='%i'", $conn->real_escape_string($idProfesor));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Review($fila['id'], $fila['idUsuario'], $fila['idProfesor'], $fila['fecha'], $fila['comentario'], $fila['puntuacion']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    private static function actualiza($Review)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Valoraciones V SET idUsuario = '%i', idProfesor='%i', fecha='%s', comentario = '%s', puntuacion = '%i' WHERE V.id=%d"
            , $conn->real_escape_string($Review->idUsuario)
            , $conn->real_escape_string($Review->idProfesor)
            , $conn->real_escape_string($Review->fecha)
            , $conn->real_escape_string($Review->comentario)
            , $conn->real_escape_string($Review->puntuacion)
            , $Review->id
        );
        if (! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } 
        return $result;
    }


    private static function inserta($Review)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Valoraciones(id, idUsuario, idProfesor, fecha, comentario, puntuacion) VALUES ('%i', '%i', '%i', '%s','%s','%i')"
        , $Review->id
        , $conn->real_escape_string($Review->idUsuario)
        , $conn->real_escape_string($Review->idProfesor)
        , $conn->real_escape_string($Review->fecha)
        , $conn->real_escape_string($Review->comentario)
        , $conn->real_escape_string($Review->puntuacion)
        );
        if ( ! $conn->query($query) ) {
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
        $query = sprintf("DELETE FROM Valoraciones V WHERE V.id = %d"
            , $id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }



    private $id;

    private $idUsuario;

    private $idProfesor;

    private $fecha;

    private $comentario;

    private $puntuacion;

    private function __construct($id, $idUsuario, $idProfesor, $fecha, $comentario,$puntuacion )
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idProfesor = $idProfesor;
        $this->fecha = $fecha;
        $this->comentario = $comentario;
        $this->puntuacion = $puntuacion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function idUsuario()
    {
        return $this->idUsuario;
    }

    public function idProfesor()
    {
        return $this->idProfesor;
    }

    public function comentario()
    {
        return $this->comentario;
    }

    public function puntuacion()
    {
        return $this->puntuacion;
    }

}