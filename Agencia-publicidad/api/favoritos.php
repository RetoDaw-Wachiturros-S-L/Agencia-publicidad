<?php 
namespace AgenciaPublicidad\api\Favorito;

use PDOException;

require_once "models/dataBase/DBCon.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$anuncioId = $data['anuncioId'] ?? null;
$usuarioId = $_SESSION<['usuario']['id'];

//si no existe id de usuario le redirige a iniciar sesion
if(!$usuarioId){
    header('Location: ../views/auth/login.php');
    exit;
}

if(!$anuncioId){
    throw new \Exception("No hay un Id de anuncio");
    exit;
}
try{
    $stmt = $pdo->prepare("INSERT INTO favoritos id_usuario, id_anuncio");
    $stmt->bindValue('id_usuario', $usuarioId);
    $stmt->bindValue('id_anuncio', $anuncioId);
    $stmt->execute();

}catch(PDOException $ex){
    http_response_code(500);
    echo json_encode(['error: '. $ex->getMessage()]);
}
?>