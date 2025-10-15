<?php 
//CRUD de tabla usuarios
namespace AgenciaPublicidad\Models;

require_once __DIR__ . '/DBCon.php';

class DBFunctions {

    public function guardarUsuario(UsuarioRegistrado $usuario) {
        $pdo = DBCon::getConnection();
        $sql = "INSERT INTO usuarios (nombre, apellido, email, password_hash, tipo_usuario) 
                VALUES (:nombre, :apellido, :email, :contrasenna, :tipo_usuario)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombre', $usuario->getNombre());
        $stmt->bindValue(':apellido', $usuario->getApellido());
        $stmt->bindValue(':email', $usuario->getEmail());
        // Hashear la contraseña antes de guardarla
        $hashedPassword = password_hash($usuario->getPassword(), PASSWORD_BCRYPT);
        $stmt->bindValue(':contrasenna', $hashedPassword);
        $stmt->bindValue(':tipo_usuario', $usuario->getTipo()->value);
        
        return $stmt->execute();
    }

    public function comprobarUsuario($email,$contrasena) {
        $pdo = DBCon::getConnection();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($usuario && isset($usuario['password_hash'])) {
            if (password_verify($contrasena, $usuario['password_hash'])==1){
                return $usuario;
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

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