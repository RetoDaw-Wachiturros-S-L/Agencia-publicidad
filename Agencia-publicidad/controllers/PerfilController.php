<?php
namespace AgenciaPublicidad\Controllers;

require_once __DIR__ . '/../models/dataBase/DBUser.php';
require_once __DIR__ . '/../utils/auth_helper.php';

use AgenciaPublicidad\Models\Comerciante;
use AgenciaPublicidad\Models\dataBase\DBUser;
use AgenciaPublicidad\Models\UsuarioRegistrado;

class PerfilController {
    private DBUser $dbUser;
    
    public function __construct() {
        $this->dbUser = new DBUser();
    }
    
    public function miPerfil() {
        // Verificar que el usuario esté autenticado usando auth_helper
        if (!\AgenciaPublicidad\Utils\isLoggedIn()) {
            header('Location: index.php?controller=AuthController&accion=iniciarSesion');
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
    
    public function editarPerfil() {
        // Verificar que el usuario esté autenticado
        if (!\AgenciaPublicidad\Utils\isLoggedIn()) {
            header('Location: index.php?controller=AuthController&accion=iniciarSesion');
            exit;
        }
        $id=$_SESSION["usuario"]["id"];
        $perfil = $this->dbUser->verMiPerfil($id);
        
        require_once __DIR__ . '/../views/editarPerfil.php';
    }
    public function insertarDatosPerfilComerci() {
        $id = $_SESSION["usuario"]["id"];

        $usuarioData = new Comerciante(
            null,
          $_SESSION["usuario"]["id"],
            $_POST['nombre'] ?? '',
            $_POST['apellido'] ?? '',
            $_SESSION["usuario"]["email"],
            '',
            null,
            $_POST['nombre_empresa'] ?? '',
            $_POST['nif_empresa'] ?? '',
            $_POST['comentario_empresa'] ?? '',
            $_POST['num_telefono'] ?? ''
        );


        // Llamar al método que actualiza la base de datos
        $resultado = $this->dbUser->actualizarComerciante($id, $usuarioData);

        if($resultado){
            require_once __DIR__ . '/../views/editarExito.php';

        }else{
            require_once __DIR__ . '/../views/editarError.php';
        }
    }

    public function insertarDatosPerfil(){
        $id=$_SESSION["usuario"]["id"];
        $usuarioData = new UsuarioRegistrado(
            $_SESSION["usuario"]["id"],
            $_POST['nombre'] ?? '',
            $_POST['apellido'] ?? '',
            $_SESSION["usuario"]["email"],
            null,
            null,
            null,
            $_SESSION["usuario"]["tipo"]
        );


   
        $resultado= $this->dbUser->actualizarUsuario($id, $usuarioData);
        if($resultado){
            require_once __DIR__ . '/../views/editarExito.php';

        }else{
            require_once __DIR__ . '/../views/editarError.php';
        }
    }

}
?>
