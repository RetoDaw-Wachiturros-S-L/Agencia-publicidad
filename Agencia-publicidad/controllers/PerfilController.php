<?php
namespace AgenciaPublicidad\Controllers;

require_once __DIR__ . '/../models/dataBase/DBUser.php';
require_once __DIR__ . '/../utils/auth_helper.php';

use AgenciaPublicidad\Models\dataBase\DBUser;

class PerfilController {
    private DBUser $dbUser;
    
    public function __construct() {
        $this->dbUser = new DBUser();
    }
    
    public function miPerfil() {
        // Verificar que el usuario esté autenticado usando auth_helper
        if (!\AgenciaPublicidad\Utils\isLoggedIn()) {
            header('Location: index.php?controller=OutController&accion=iniciarSesion');
            exit;
        }
        
        // Obtener el usuario actual usando auth_helper
        $currentUser = \AgenciaPublicidad\Utils\getCurrentUser();
        $id = $currentUser["id"];
        
        $perfil = $this->dbUser->verMiPerfil($id);
        
        // Extraer variables globales al scope local (ya configuradas por auth_helper)
        $isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
        $isAdmin = $GLOBALS['isAdmin'] ?? false;
        
        require_once __DIR__ . '/../views/miPerfil.php';
    }
   // Controlador
    public function editarPerfil() {
        $updates = [];

        $nombre = $_POST['nombre'] ?? null;
        $apellido = $_POST['apellido'] ?? null;
        $contrasena = $_POST['contrasena'] ?? null;
        $nombre_empresa = $_POST['nombre_empresa'] ?? null;
        $comentario_empresa = $_POST['comentario_empresa'] ?? null;
        $telefono_empresa = $_POST['telefono_empresa'] ?? null;
        $nif_empresa = $_POST['nif_empresa'] ?? null;

        if (!empty($nombre)) {
            $updates['nombre'] = $nombre;
        }

        if (!empty($apellido)) {
            $updates['apellido'] = $apellido;
        }

        if (!empty($contrasena)) {
            $updates['password_hash'] = password_hash($contrasena, PASSWORD_BCRYPT);
        }

        if (!empty($nombre_empresa)) {
            $updates['nombre_empresa'] = $nombre_empresa;
        }

        if (!empty($comentario_empresa)) {
            $updates['comentario_empresa'] = $comentario_empresa;
        }

        if (!empty($telefono_empresa)) {
            $updates['num_telefono'] = $telefono_empresa;
        }

        if (!empty($nif_empresa)) {
            $updates['nif_empresa'] = $nif_empresa;
        }

        // Foto de perfil
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = uniqid() . "-" . basename($_FILES['foto_perfil']['name']);
            $rutaDestino = 'uploads/' . $nombreArchivo;
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                $updates['foto_perfil'] = $rutaDestino;
            }
        }

        $id=$_SESSION["id"];

        $resultado = $this->dbUser->editarMiPerfil($id, $updates);
        if($resultado){
            echo "aaaa";
        }
    }


}
?>
