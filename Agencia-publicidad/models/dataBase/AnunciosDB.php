<?php 
namespace AgenciaPublicidad\Models\DataBase;

use AgenciaPublicidad\Models\Comerciante;
use AgenciaPublicidad\Models\DataBase\DBCon;
use AgenciaPublicidad\Models\Anuncio;
use AgenciaPublicidad\Models\TipoPersonaEnum;

require_once __DIR__ . '/DBCon.php';
require_once __DIR__ . '/../Anuncio.php';
require_once __DIR__ . '/../Comerciante.php';
require_once __DIR__ . '/../TipoPersonaEnum.php';

class AnunciosDB{
    public function getAll():array{
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("SELECT id, id_comerciante, titulo, detalles, fecha_publicacion FROM anuncios");
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id):Anuncio|null{
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("SELECT 
                                        a.id,
                                        a.titulo,
                                        a.detalles,
                                        a.fecha_publicacion,

                                        c.id,
                                        c.id_usuario,
                                        c.nombre_empresa,
                                        c.cif_empresa,
                                        c.comentario_empresa,
                                        c.num_telefono,
                                        c.comerciante_desde,

                                        u.id,
                                        u.nombre,
                                        u.apellido,
                                        u.email,
                                        u.password_hash,
                                        u.fecha_inscripcion,
                                        u.foto_perfil,
                                        u.tipo_usuario

                                        FROM anuncios a 
                                        INNER JOIN comerciantes c ON a.id_comerciante = c.id 
                                        INNER JOIN usuarios u ON c.id_usuario = u.id
                                        WHERE a.id = :ID");
        //Aqui para obtener todo hay que hacer con join pero de momento no hace falta
        $sql->execute([':ID' => $id]);
        $data = $sql->fetch(\PDO::FETCH_ASSOC);
        if(!$data) return null;

        $comerciante = new Comerciante(
            $data['u.nombre'] ,
            $data['u.apellido'] ,
            $data['u.email'] ,
            $data['u.password_hash'] ,
            $data['u.fecha_inscripcion'] ?? new \DateTime(),
            $data['u.foto_perfil'] ?? null,
            $data['u.tipo_persona'] ?? TipoPersonaEnum::COMERCIANTE,
            $data['c.nombre_empresa'],
            $data['c.nif_empresa'],
            $data['c.comentario_empresa'] ?? null,
            $data['c.num_telefono'] ?? null,
            $data['c.comerciante_desde'] ?? new \DateTime()
        );

        $fecha = isset($data['a.fecha_publicacion']) ? new \DateTime($data['a.fecha_publicacion']) : new \DateTime();

        return new Anuncio(
            (int)$data['a.id'],
            (string)$data['a.titulo'],
            [], // urlFotos
            isset($data['a.detalles']) ? (string)$data['a.detalles'] : null,
            null, // precio no disponible en SELECT
            $fecha,
            $comerciante,
            [] // categorias, cudruple join
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
        $sql = $pdo->prepare("DELETE FROM ANUNCIOS WHERE ID = :ID");
        $sql->bindValue(":ID", $id);
        return $sql->execute();
    }
}


?>