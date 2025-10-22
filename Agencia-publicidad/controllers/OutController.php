<?php
namespace AgenciaPublicidad\Controllers;


use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\TipoPersonaEnum;
use AgenciaPublicidad\Models\dataBase\DBFunctions;
use AgenciaPublicidad\Models\DBUser;
use AgenciaPublicidad\Models\Comerciante;

// Cargas directas para entornos sin autoloader
require_once __DIR__ . '/../models/UsuarioRegistrado.php';
require_once __DIR__ . '/../models/TipoPersonaEnum.php';
require_once __DIR__ . '/../models/dataBase/DBFunctions.php';
require_once __DIR__ . '/../models/dataBase/DBUser.php';
require_once __DIR__ . '/../models/Comerciante.php';


class OutController {
    
    private DBFunctions $dbFunctions;
    private DBUser $dbUser;
    
    public function __construct() {
        $this->dbFunctions = new DBFunctions();
        $this->dbUser = new DBUser();
        session_start();
    }

    public function store() {
        // Verificar autenticación y permisos
        require_once __DIR__ . '/../utils/auth_helper.php';
        
        if (!isset($currentUser) || empty($currentUser)) {
            echo "Error: Usuario no autenticado";
            require_once __DIR__ . '/../views/errors/403.php';
            exit;
        }

        if ($currentUser['tipo'] !== 'ADMINISTRADOR') {
            http_response_code(403);
            echo "Error: No tienes permisos para registrar usuarios";
            require_once __DIR__ . '/../views/errors/403.php';
            exit;
        }

        // Verificar que la petición sea POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Recibir todos los datos del formulario
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $contrasena2 = $_POST['contrasena2'] ?? '';
            $fotoPerfil = $_POST['fotoPerfil'] ?? null;
            
            $errores = [];

            // Validaciones nombre
            
            if (empty($nombre)) {
                $errores[] = "El nombre es obligatorio";
            }

            if (strlen($nombre) < 2) {
                $errores[] = "El nombre debe tener al menos 2 caracteres";
            }

            if (strlen($nombre) > 100) {
                $errores[] = "El nombre no puede exceder 100 caracteres";
            }

            if (!preg_match("/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s'-]+$/u", $nombre)) {
                $errores[] = "El nombre solo puede contener letras, espacios, guiones y apóstrofes";
            }
            
            // Validaciones apellido

            if (!empty($apellido) && strlen($apellido) < 2) {
                $errores[] = "El apellido debe tener al menos 2 caracteres";
            }

            if (!empty($apellido) && strlen($apellido) > 100) {
                $errores[] = "El apellido no puede exceder 100 caracteres";
            }

            if (!empty($apellido) && !preg_match("/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s'-]+$/u", $apellido)) {
                $errores[] = "El apellido solo puede contener letras, espacios, guiones y apóstrofes";
            }

            // Validaciones email

            if (empty($email)) {
                $errores[] = "El email es obligatorio";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El formato del email no es válido";
            }

            if (strlen($email) > 255) {
                $errores[] = "El email no puede exceder 255 caracteres";
            }

            $email = strtolower(trim($email)); // Pasarlo todo a minúsculas sin espacios
            
            // Validaciones contraseña

            if (empty($contrasena)) {
                $errores[] = "La contrasena es obligatoria";
            }

            if (strlen($contrasena) < 6) {
                $errores[] = "La contraseña debe tener al menos 6 caracteres";
            }

            if (strlen($contrasena) > 72) {
                $errores[] = "La contraseña no puede exceder 72 caracteres";
            }
            
            if ($contrasena !== $contrasena2) {
                $errores[] = "Las contraseñas no coinciden";
            }

            if (isset($_POST["es_comercio"]) && $_POST["es_comercio"]==1){
                $nombreEmpresa = $_POST['nombreEmpresa'] ?? '';
                $nifEmpresa = $_POST['nifEmpresa'] ?? '';
                $comentarioEmpresa = $_POST['comentarioEmpresa'] ?? '';
                $telefonoEmpresa = $_POST['telefonoEmpresa'] ?? '';

                if (empty($nombreEmpresa)) {
                    $errores[] = "El nombre de la empresa es obligatorio";
                }  
                
                if (empty($nifEmpresa)) {
                    $errores[] = "El NIF de la empresa es obligatorio";
                }
                
                if (empty($comentarioEmpresa)) {
                    $errores[] = "El comentario sobre la empresa es obligatorio";
                }

                $comentarioEmpresa = strtolower(trim($comentarioEmpresa)); // Pasamos comentario empresa a minus y quitamos espacios
                
                if (empty($telefonoEmpresa)) {
                    $errores[] = "El teléfono de la empresa es obligatorio";
                }

            }
            
            // Si no hay errores, procesar el registro
            if (empty($errores)) {
                // Aquí guardarías en la base de datos
                $nuevoUsuario = new UsuarioRegistrado(
                null, // id_usuario (null para usuario nuevo)
                $nombre,
                $apellido,
                $email,
                $contrasena,
                new \DateTime(),
                null, // foto_perfil
                TipoPersonaEnum::VISITANTE); //se tiene que poner la opcion pero si no poner VISITANTE por defecto
                $this->dbUser->guardarUsuario($nuevoUsuario);
                
                if (isset($_POST["es_comercio"]) && $_POST["es_comercio"]==1) {
                    TipoPersonaEnum::COMERCIANTE;
                $nuevoComerciante = new Comerciante(
                    $nombre,
                    $apellido,
                    $email,
                    $contrasena,
                    new \DateTime(),
                    "",
                    TipoPersonaEnum::COMERCIANTE,
                    $nombreEmpresa,
                    $nifEmpresa,
                    $comentarioEmpresa,
                    $telefonoEmpresa,
                    new \DateTime(),
                    );

                    $this->dbUser->guardarComerciante($nuevoComerciante);
                }               
                
                // Redirigir o mostrar éxito
                echo "Usuario registrado exitosamente";
               
                
            } else {
                // Mostrar errores
                $mensaje_error = implode("<br>", $errores);
                include 'views/auth/register.php';
            }
            
        } else {
            // Si no es POST, mostrar el formulario
            include 'views/auth/register.php';
        }
    }
    
    private function guardarUsuario($nuevoUsuario) {
        $this->dbUser->guardarUsuario($nuevoUsuario);
    }

    public function iniciarSesion(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $errores = [];


            if (empty($email)) {
                $errores[] = "El email es obligatorio";
            }
            
            if (empty($contrasena)) {
                $errores[] = "La constraseña no puede estar vacia";
            }
            if(empty($errores)){
                $comerciante = null;
                $usuario = $this->dbUser->comprobarUsuario($email, $contrasena);

                if (!(empty($usuario))) {

                    if($usuario->getTipo() == TipoPersonaEnum::COMERCIANTE){
                        $comerciante = $this->dbUser->usuarioComerciante($usuario);
                        $_SESSION['usuario'] = [
                        'id' => $usuario->getIdUsuario(),
                        'email' => $usuario->getEmail(),
                        'nombre' => $usuario->getNombre(),
                        'apellido' => $usuario->getApellido(),
                        'tipo' => $usuario->getTipo()->value,
                        'login_time' => time(),
                        'id_comerciante' => $comerciante->getIdComerciante(),
                    ];
                    } else {
                        $_SESSION['usuario'] = [
                        'id' => $usuario->getIdUsuario(),
                        'email' => $usuario->getEmail(),
                        'nombre' => $usuario->getNombre(),
                        'apellido' => $usuario->getApellido(),
                        'tipo' => $usuario->getTipo()->value,
                        'login_time' => time(),
                    ];}
                    echo "Iniciaste sesión correctamente";
                } else { echo "Usuario o contraseña incorrectos"; }
            } else {
                // Mostrar errores
                $mensaje_error = implode("<br>", $errores);
                include 'views/auth/login.php';
            }
        } else {
            include 'views/auth/login.php';
        }
    } 

    public function logout() {
        if (isset($_SESSION['usuario'])) {
            session_destroy();
            header('Location: ?index.php&controller=MainController&action=index');
            exit;
        }
    }
    public function favourites(){
        $id=$_SESSION["usuario"]["id"];
        $anuncios = $this->dbUser->sacarfavoritos($id);
        require_once BASE_URL.'views/favourites.php';
            
    }
    public function misAnuncios(){
        $id=$_SESSION["usuario"]["id"];
        $anuncios = $this->dbUser->sacarAnuncios($id);
        require_once BASE_URL.'views/misAdds.php';
    }
    public function miPerfil(){
    }

    
    

}

?>