<?php
namespace AgenciaPublicidad\Models\dataBase;

require_once __DIR__ . '/DBCon.php';

class FotosDB {
    
    /**
     * Guarda información de foto en la base de datos
     */
    public function guardarFoto($idAnuncio, $urlFoto, $orden = 0, $esPortada = false) {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("
            INSERT INTO fotos_anuncios (id_anuncio, url_foto, orden, es_portada)
            VALUES (:id_anuncio, :url_foto, :orden, :es_portada)
        ");
        
        $sql->bindValue(':id_anuncio', $idAnuncio, \PDO::PARAM_INT);
        $sql->bindValue(':url_foto', $urlFoto);
        $sql->bindValue(':orden', $orden, \PDO::PARAM_INT);
        $sql->bindValue(':es_portada', $esPortada, \PDO::PARAM_BOOL);
        
        return $sql->execute();
    }
    
    /**
     * Obtiene todas las fotos de un anuncio
     */
    public function getFotosByAnuncio($idAnuncio) {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("
            SELECT * FROM fotos_anuncios 
            WHERE id_anuncio = :id_anuncio 
            ORDER BY es_portada DESC, orden ASC
        ");
        $sql->bindValue(':id_anuncio', $idAnuncio, \PDO::PARAM_INT);
        $sql->execute();
        
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtiene la foto de portada de un anuncio
     */
    public function getFotoPortada($idAnuncio) {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("
            SELECT * FROM fotos_anuncios 
            WHERE id_anuncio = :id_anuncio AND es_portada = TRUE
            LIMIT 1
        ");
        $sql->bindValue(':id_anuncio', $idAnuncio, \PDO::PARAM_INT);
        $sql->execute();
        
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Elimina una foto
     */
    public function eliminarFoto($idFoto) {
        $pdo = DBCon::getConnection();
        
        // Primero obtener la URL para eliminar el archivo físico
        $sql = $pdo->prepare("SELECT url_foto FROM fotos_anuncios WHERE id = :id");
        $sql->bindValue(':id', $idFoto, \PDO::PARAM_INT);
        $sql->execute();
        $foto = $sql->fetch(\PDO::FETCH_ASSOC);
        
        if ($foto) {
            // Eliminar archivo físico
            \AgenciaPublicidad\Utils\ImageUploader::deleteImage(basename($foto['url_foto']));
            
            // Eliminar registro de BD
            $sqlDelete = $pdo->prepare("DELETE FROM fotos_anuncios WHERE id = :id");
            $sqlDelete->bindValue(':id', $idFoto, \PDO::PARAM_INT);
            return $sqlDelete->execute();
        }
        
        return false;
    }
}
?>