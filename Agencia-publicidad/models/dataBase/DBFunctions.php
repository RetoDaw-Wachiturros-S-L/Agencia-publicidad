<?php 
//CRUD de tabla usuarios
namespace AgenciaPublicidad\Models\dataBase;

use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\dataBase\DBCon;

require_once __DIR__ . '/DBCon.php';
require_once __DIR__ . '/../UsuarioRegistrado.php';

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

    public function getById($id): UsuarioRegistrado|null {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("SELECT 
                    nombre, apellido,
                    email, fecha_inscripcion, foto_perfil, tipo_usuario, password_hash
                FROM usuarios
                WHERE ID = :ID");
        $sql->bindValue(":ID", $id);
        $sql->execute();
        $data = $sql->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            // Ajusta los parámetros según el constructor de UsuarioRegistrado
            return new UsuarioRegistrado(
                $data['nombre'],
                $data['apellido'] ?? '',
                $data['email'],
                $data['password_hash'], // o null si no quieres exponer el hash
                $data['fecha_inscripcion'] ?? null,
                $data['foto_perfil'] ?? null,
                $data['tipo_usuario']
            );
        }
        return null;
    }

    public function update(int $id, UsuarioRegistrado $usuario): bool {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare('UPDATE USUARIOS SET
                                NOMBRE = :NOMBRE,
                                APELLIDO = :APELLIDO,
                                EMAIL = :EMAIL,
                                PASSWORD_HASH = :PASSWORD_HASH,
                                FOTO_PERFIL = :FOTO_PERFIL,
                                TIPO_USUARIO = :TIPO_USUARIO 
                                WHERE ID = :ID');

        $sql->bindValue(':NOMBRE', $usuario->getNombre(), \PDO::PARAM_STR);
        $sql->bindValue(':APELLIDO', $usuario->getApellido() ??null, \PDO::PARAM_STR);
        $sql->bindValue(':EMAIL', $usuario->getEmail() ??null, \PDO::PARAM_STR);
        $sql->bindValue(':PASSWORD_HASH', password_hash($usuario->getContrasena() ?? '', PASSWORD_BCRYPT), \PDO::PARAM_STR);
        $sql->bindValue(':FOTO_PERFIL', $usuario->getFotoPerfil() ??null, \PDO::PARAM_STR);
        $sql->bindValue(':TIPO_USUARIO', $usuario->getTipo()->value, \PDO::PARAM_STR);
        $sql->bindValue(':ID', $id);
        return $sql->execute();
    }               

    public function delete(int $id): bool {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare('DELETE FROM USUARIOS WHERE ID = :ID');
        $sql->bindValue(':ID', $id);
        return $sql->execute();
    }
        
}



?>