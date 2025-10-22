<?php 
//CRUD de tabla usuarios
namespace AgenciaPublicidad\Models\dataBase;

use AgenciaPublicidad\Models\dataBase\DBCon;
use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\Comerciante;
use AgenciaPublicidad\Models\TipoPersonaEnum;
use PDO;

require_once __DIR__ . '/DBCon.php';
require_once __DIR__ . '/../UsuarioRegistrado.php';
require_once __DIR__ . '/../Comerciante.php';
require_once __DIR__ . '/../TipoPersonaEnum.php';

class DBUser {
    
    public function guardarUsuario(UsuarioRegistrado $usuario) {
        $pdo = DBCon::getConnection();
        $sql = "INSERT INTO usuarios (nombre, apellido, email, password_hash, tipo_usuario) 
                VALUES (:nombre, :apellido, :email, :contrasenna, :tipo_usuario)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombre', $usuario->getNombre());
        $stmt->bindValue(':apellido', $usuario->getApellido());
        $stmt->bindValue(':email', $usuario->getEmail());
        // Hashear la contraseña antes de guardarla
        $hashedPassword = password_hash($usuario->getContrasena(), PASSWORD_BCRYPT);
        $stmt->bindValue(':contrasenna', $hashedPassword);
        $stmt->bindValue(':tipo_usuario', $usuario->getTipo()->value);
        
        return $stmt->execute();
    }
    public function guardarComerciante(Comerciante $usuario) {
        // Primero guardar como usuario normal
        $this->guardarUsuario($usuario);
        
        // Obtener el ID del usuario recién creado
        $id = $this->sacarIdUsuario($usuario->getEmail());
        
        $pdo = DBCon::getConnection();
        $sql = "INSERT INTO comerciantes (id_usuario, nombre_empresa, comentario_empresa) 
                VALUES (:idUsuario, :nombreEmpresa, :comentarioEmpresa)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idUsuario', $id);
        $stmt->bindValue(':nombreEmpresa', $usuario->getNombreComercio());
        $stmt->bindValue(':comentarioEmpresa', $usuario->getRubro());
        
        return $stmt->execute();
    }

    public function sacarIdUsuario($email){
        $pdo = DBCon::getConnection();
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($usuario && isset($usuario['id'])) {
            return $usuario['id'];
        } else {
            return null;
        }
    }
    

    public function comprobarUsuario($email, $contrasena): ?UsuarioRegistrado {
        $pdo = DBCon::getConnection();
        $sql = "SELECT id, nombre, apellido, email, password_hash, fecha_inscripcion, foto_perfil, tipo_usuario FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($usuario && isset($usuario['password_hash'])) {
            if (password_verify($contrasena, $usuario['password_hash'])) {
                return new UsuarioRegistrado(
                    (int)$usuario['id'],
                    $usuario['nombre'],
                    $usuario['apellido'],
                    $usuario['email'],
                    $usuario['password_hash'],
                    TipoPersonaEnum::from($usuario['tipo_usuario']),
                    $usuario['foto_perfil'] ?? null
                );
            }
        } 
        return null;   
    }

    public function usuarioComerciante($usuarioRegistrado) :Comerciante|null{
        $pdo = DBCon::getConnection();
        $sql = "SELECT id AS id_comerciante, id_usuario, nombre_empresa, nif_empresa, comentario_empresa,
        num_telefono, comerciante_desde FROM comerciantes WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id_usuario", $usuarioRegistrado->getIdUsuario());
        $stmt->execute();
        
        $comerciante = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if(!$comerciante) return null;
        
        return new Comerciante(
            (int)$comerciante['id_comerciante'],  // idComerciante
            $usuarioRegistrado->getIdUsuario(),    // id
            $usuarioRegistrado->getNombre(),       // nombre
            $usuarioRegistrado->getApellido(),     // apellido
            $usuarioRegistrado->getEmail(),        // email
            $usuarioRegistrado->getContrasena(),   // contrasena
            $usuarioRegistrado->getFotoPerfil(),   // fotoPerfil
            $comerciante['nombre_empresa'],        // nombreComercio
            $comerciante['comentario_empresa']     // rubro
        );
    }

    public function sacarfavoritos($id) {
    $pdo = DBCon::getConnection();


    $sql = "SELECT
                a.id,
                a.id_comerciante,
                a.titulo,
                a.detalles,
                a.fecha_publicacion
            FROM anuncios a
            JOIN favoritos f ON a.id = f.id_anuncio
            JOIN usuarios u ON f.id_usuario = u.id
            WHERE f.id_usuario = :id_usuario";


    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id_usuario", $id, PDO::PARAM_INT);
    $stmt->execute();


    $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);


    return $anuncios;
   }


    public function verMisAnuncios($id) {
        $pdo = DBCon::getConnection();


        $sql = "SELECT 
                    a.titulo,
                    a.detalles,
                    a.fecha_publicacion 
                FROM anuncios a
                JOIN comerciantes c ON a.id_comerciante = c.id
                JOIN usuarios u ON c.id_usuario  =  u.id";


        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id_usuario", $id, PDO::PARAM_INT);
        $stmt->execute();


        $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $anuncios;
    }


}
?>