<?php 
//CRUD de tabla usuarios
namespace AgenciaPublicidad\Models;

require_once __DIR__ . '/DBCon.php';

class DBFunctions {

    function getAll(){
        $pdo = DBCon::getConnection();
        $sql = "SELECT 
                    nombre, apellido,
                    email, fecha_inscripcion, foto_perfil, tipo_usuario
                FROM usuarios";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}



?>