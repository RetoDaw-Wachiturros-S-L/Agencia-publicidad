<?php
namespace AgenciaPublicidad\AgenciaPublicidad\api\Favorito;

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

class Favoritos {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = DBCon::getConnection();
    }

    public function insertar($usuarioId, $anuncioId) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO favoritos (id_usuario, id_anuncio) VALUES (:id_usuario, :id_anuncio)");
            $stmt->bindValue(':id_usuario', $usuarioId);
            $stmt->bindValue(':id_anuncio', $anuncioId);
            $stmt->execute();

            echo json_encode(['success' => true]);

        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') { 
                //Esto mira si en favoritos ya está ese id_anuncio y devuelve constraint violation (23000)
                http_response_code(409);
                echo json_encode(['error' => 'Ya existe este favorito', 'exists' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => $ex->getMessage()]);
            }
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

$favoritos = new Favoritos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $favoritos->insertar($usuarioId, $anuncioId);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $favoritos->borrar($usuarioId, $anuncioId);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>