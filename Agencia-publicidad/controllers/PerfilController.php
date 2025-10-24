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
}
?>
