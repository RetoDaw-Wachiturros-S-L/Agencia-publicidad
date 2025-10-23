<?php 
namespace AgenciaPublicidad\Models\dataBase;

use AgenciaPublicidad\Models\Comerciante;
use AgenciaPublicidad\Models\dataBase\DBCon;
use AgenciaPublicidad\Models\Anuncio;
use AgenciaPublicidad\Models\TipoPersonaEnum;
use AgenciaPublicidad\Utils;

require_once __DIR__ . '/../../utils/auth_helper.php';
require_once __DIR__ . '/DBCon.php';
require_once __DIR__ . '/../Anuncio.php';
require_once __DIR__ . '/../TipoPersonaEnum.php';
require_once __DIR__ . '/../UsuarioRegistrado.php';
require_once __DIR__ . '/../Comerciante.php';

class AnunciosDB{
    public function getAll():array{
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("SELECT id, id_comerciante, titulo, detalles, fecha_publicacion FROM anuncios");
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?Anuncio {
        $pdo = DBCon::getConnection();

        $sql = $pdo->prepare("
            SELECT 
                a.id   AS a_id,
                a.titulo AS a_titulo,
                a.detalles AS a_detalles,
                a.fecha_publicacion AS a_fecha_publicacion,
                c.id   AS c_id,
                c.nombre_empresa AS c_nombre_empresa,
                c.nif_empresa AS c_nif_empresa,
                c.comentario_empresa AS c_comentario_empresa,
                c.num_telefono AS c_num_telefono,
                c.comerciante_desde AS c_comerciante_desde,
                u.id   AS u_id,
                u.nombre AS u_nombre,
                u.apellido AS u_apellido,
                u.email AS u_email,
                u.password_hash AS u_password_hash,
                u.fecha_inscripcion AS u_fecha_inscripcion,
                u.foto_perfil AS u_foto_perfil,
                u.tipo_usuario AS u_tipo_usuario
            FROM anuncios a
            INNER JOIN comerciantes c ON a.id_comerciante = c.id
            INNER JOIN usuarios u ON c.id_usuario = u.id
            WHERE a.id = :ID
            LIMIT 1
        ");
        $sql->bindValue(':ID', (int)$id, \PDO::PARAM_INT);

        try {
            $sql->execute();
        } catch (\PDOException $e) {
            error_log("AnunciosDB::getById SQL error: " . $e->getMessage());
            return null;
        }

        // Debug: mostrar parámetros y estado de la consulta
        ob_start();
        $sql->debugDumpParams();
        $dbg = ob_get_clean();
        error_log("AnunciosDB::getById debugDumpParams: " . $dbg);

        $errorInfo = $sql->errorInfo();
        error_log("AnunciosDB::getById errorInfo: " . json_encode($errorInfo));

        $data = $sql->fetch(\PDO::FETCH_ASSOC);
        error_log("AnunciosDB::getById fetch result: " . var_export($data, true));

        if (!$data) {
            error_log("AnunciosDB::getById: no rows for id={$id}");
            return null;
        }

        // Construir objetos con comprobaciones mínimas (ajusta constructores reales)
        $comerciante = null;
        if (!empty((int)$data['c_id'])) {
            $comerciante = new Comerciante(
                isset($data['c_id']) ? (int)$data['c_id'] : null,           // idComerciante
                isset($data['u_id']) ? (int)$data['u_id'] : null,           // id
                $data['u_nombre'] ?? '',                                     // nombre
                $data['u_apellido'] ?? null,                                 // apellido
                $data['u_email'] ?? '',                                      // email
                $data['u_password_hash'] ?? '',                              // contrasena
                $data['u_foto_perfil'] ?? null,                              // fotoPerfil
                $data['c_nombre_empresa'] ?? null,                           // nombreComercio
                $data['c_comentario_empresa'] ?? null                        // rubro
            );
        }

        $fecha = isset($data['a_fecha_publicacion']) ? new \DateTime($data['a_fecha_publicacion']) : new \DateTime();

        return new Anuncio(
            (int)$data['a_id'],
            (string)$data['a_titulo'],
            $data['f_url_foto'] ?? null, // urls fotos placeholder
            $data['a_detalles'] ?? '',
            $fecha,
            $comerciante,
            $data['cat_nombre'] ?? null, //esto ta devuelve un array (habría que recorrerlo)
        );
    }

    public function update(int $id, Anuncio $anuncioData):bool{
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("UPDATE 
                                ANUNCIOS SET
                                TITULO = :TITULO,
                                DETALLES = :DETALLES

                                --CAMPO FECHA_ACTUALIAZCION?
                                WHERE ID = :ID");
        $sql->bindValue(':TITULO', $anuncioData->getTitulo());
        $sql->bindValue(':DETALLES', $anuncioData->getDescripcion());
        $sql->execute([":ID"=> $id]);
        return $sql->rowCount() > 0; //retorna las afectadas
    }
    public function delete(int $id):bool{
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("DELETE FROM anuncios WHERE ID = :ID");
        $sql->bindValue(":ID", $id);
        return $sql->execute();
    }

    public function create(Anuncio $anuncio):bool{
        $currentUser = $_SESSION['usuario'] ?? null;
        
        // Validar que el usuario esté logueado y sea comerciante
        if (!$currentUser) {
            error_log("AnunciosDB::create - No hay usuario en sesión");
            throw new \Exception("Debe iniciar sesión para crear anuncios");
        }
        
        if (!isset($currentUser['id_comerciante'])) {
            error_log("AnunciosDB::create - Usuario no es comerciante. SESSION: " . var_export($currentUser, true));
            throw new \Exception("Solo los comerciantes pueden crear anuncios");
        }

        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("INSERT INTO 
                                anuncios(id_comerciante, titulo, detalles)
                                VALUES(:id_comerciante, :titulo, :detalles)");
                                //Aqi faltaria con añadir TAGS y FOTOS
        $sql->bindValue(":id_comerciante", $currentUser['id_comerciante']);
        $sql->bindValue(":titulo", $anuncio->getTitulo());
        $sql->bindValue(":detalles", $anuncio->getDescripcion());        
        
        return $sql->execute();
    }        
    public function getAllByIdComerciante(int $idComerciante){
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("SELECT id, titulo, detalles, fecha_publicacion FROM anuncios WHERE id_comerciante = :id_comerciante");
        $sql->bindValue(":id_comerciante", $idComerciante);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByPalabra(string $palabras) :array {
        $pdo = DBcon::getConnection();
        $sql = $pdo->prepare("SELECT id, id_comerciante, titulo, detalles, fecha_publicacion FROM anuncios WHERE titulo LIKE :palabra");
        $sql->bindValue(":palabra", '%' .  $palabras . '%', \PDO::PARAM_STR);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
        
}


?>