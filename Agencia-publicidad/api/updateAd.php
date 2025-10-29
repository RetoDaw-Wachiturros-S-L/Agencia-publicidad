<?php
namespace AgenciaPublicidad\AgenciaPublicidad\api\UpdateAd;

error_log("Método recibido: " . $_SERVER['REQUEST_METHOD']);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PDOException;
use AgenciaPublicidad\Models\dataBase\DBCon;

session_start();
require_once "../models/dataBase/DBCon.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$anuncioId = $data['anuncioId'] ?? null;
$usuarioId = $_SESSION['usuario']['id'] ?? null;
$titulo = $data['titulo'];
$descripcion = $data['descripcion'] ?? null;

// Validaciones
if (!$usuarioId) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

if (!$anuncioId) {
    http_response_code(400);
    echo json_encode(['error' => 'No hay un Id de anuncio']);
    exit;
}
if(!$titulo){
    http_response_code(400);
    echo json_encode(['error' => 'EL titulo es un campo obligatorio']);
    exit;
}

class UpdateAd {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = DBCon::getConnection();
    }

    public function insertar($usuarioId, $anuncioId, $titulo, $descripcion) {
        try {
                $stmt = $this->pdo->prepare("UPDATE anuncios SET TITULO = :titulo,
                    DESCRIPCION = :descripcion
                    WHERE id = :id_anuncio
                    AND id_comerciante = :id_usuario");

                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':descripcion', $descripcion);
                $stmt->bindValue(':id_usuario', $usuarioId);
                $stmt->bindValue(':id_anuncio', $anuncioId);

            $stmt->execute();

            echo json_encode(['success' => true]);

        } catch (PDOException $ex) {
            http_response_code(500);
            echo json_encode(['error' => $ex->getMessage()]);
        }
    }


    public function borrar($usuarioId, $anuncioId) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM favoritos WHERE id_anuncio = :idAnuncio AND id_usuario = :idUsuario");
            $stmt->bindValue(':idAnuncio', $anuncioId);
            $stmt->bindValue(':idUsuario', $usuarioId);
            $stmt->execute();

            echo json_encode(['success' => true]);

        } catch (PDOException $ex) {
            http_response_code(500);
            echo json_encode(['error' => $ex->getMessage()]);
        }
    }
}

$updateAd = new UpdateAd();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $updateAd->insertar($usuarioId, $anuncioId, $titulo, $descripcion);
}

?>