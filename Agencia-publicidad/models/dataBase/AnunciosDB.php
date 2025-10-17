<?php 
namespace AgenciaPublicidad\Models\DataBase;

use AgenciaPublicidad\Models\DataBase\DBCon;
use \AgenciaPublicidad\Models\Anuncio;

require_once __DIR__ ."/DBCon.php";

class AnunciosDB{
    public function getAll():array{
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("SELECT id, id_comerciante, titulo, detalles, fecha_publicacion FROM anuncios");
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id):Anuncio|null{
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("SELECT id, id_comerciante, titulo, detalles, fecha_publicacion FROM anuncios WHERE ID = :ID");
        //Aqui para obtener todo hay que hacer con join pero de momento no hace falta
        $sql->execute([':ID' => $id]);
        $data = $sql->fetch(\PDO::FETCH_ASSOC);
        if(!$data) return null;
        return new Anuncio(
        $data['id'],
        $data['titulo'],
        $data['urlFotos'] ?? null,
        $data['descripcion'] ?? null,
        $data['fechaPublicacion'],
        // $data['anunciante'],
        $data['categorias'] ?? null,
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
        $sql = $pdo->prepare("DELTE FROM ANUNCIOS WHERE ID = :ID");
        $sql->bindValue(":ID", $id);
        return $sql->execute();
    }
}


?>