<?php 
//CRUD de tabla usuarios

require_once __DIR__ . '/DBCon.php';

function getAll(){
    $pdo = DBCon::getConnection();
    $sql = "SELECT 
                nombre, apellido,
                email, fecha_inscripcion, foto_perfil, tipo_usuario
            FROM usuarios";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



?>