<?php
namespace AgenciaPublicidad\Controllers;

use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\TipoPersonaEnum;
use AgenciaPublicidad\Models\dataBase\DBFunctions;
use AgenciaPublicidad\Models\dataBase\DBUser;
use AgenciaPublicidad\Models\Comerciante;
use Exception;

require_once __DIR__ . '/../models/UsuarioRegistrado.php';
require_once __DIR__ . '/../models/TipoPersonaEnum.php';
require_once __DIR__ . '/../models/dataBase/DBFunctions.php';
require_once __DIR__ . '/../models/dataBase/DBUser.php';
require_once __DIR__ . '/../models/Comerciante.php';
require_once __DIR__ . '/../utils/auth_helper.php';

class OutController {
    
    private DBFunctions $dbFunctions;
    private DBUser $dbUser;
    
    public function __construct() {
        $this->dbFunctions = new DBFunctions();
        $this->dbUser = new DBUser();
    }

    public function store() {
        // Usar las funciones del auth_helper
        if (!\Agenciapublicidad\Utils\isLoggedIn()) {
            http_response_code(403);
            echo "Error: Usuario no autenticado";
            require_once __DIR__ . '/../views/errors/403.php';
            exit;
        }

        if (!\Agenciapublicidad\Utils\isAdmin()) {
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

            $email = strtolower(trim($email));
            
            // Validaciones contraseña
            if (empty($contrasena)) {
                $errores[] = "La contraseña es obligatoria";
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

            // Validaciones para comerciante
            $esComercio = isset($_POST["es_comercio"]) && $_POST["es_comercio"] == 1;
            $nombreEmpresa = null;
            $nifEmpresa = null;
            $comentarioEmpresa = null;

            if ($esComercio) {
                $nombreEmpresa = $_POST['nombreEmpresa'] ?? '';
                $nifEmpresa = $_POST['nifEmpresa'] ?? '';
                $comentarioEmpresa = $_POST['comentarioEmpresa'] ?? '';

                if (empty($nombreEmpresa)) {
                    $errores[] = "El nombre de la empresa es obligatorio";
                }
                
                if(empty($nifEmpresa)){
                    $errores[] = 'El nif de la empresa no puede estar vacío si eres un comercio';
                }
                
                if (empty($comentarioEmpresa)) {
                    $errores[] = "El rubro/comentario sobre la empresa es obligatorio";
                }

                $comentarioEmpresa = htmlspecialchars(trim($comentarioEmpresa), ENT_QUOTES, 'UTF-8');
            }
            
            // Si no hay errores, procesar el registro
            if (empty($errores)) {
                try {
                    // Sanitizar datos
                    $nombre = htmlspecialchars(trim($nombre), ENT_QUOTES, 'UTF-8');
                    $apellido = htmlspecialchars(trim($apellido), ENT_QUOTES, 'UTF-8');
                    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                    
                    // Determinar el tipo de usuario
                    $tipoUsuario = $esComercio ? TipoPersonaEnum::COMERCIANTE : TipoPersonaEnum::VISITANTE;
                    
                    // Si es comerciante, crear directamente como Comerciante
                    if ($esComercio) {
                        $nuevoComerciante = new Comerciante(
                            null,               // idComerciante (será generado por la BD)
                            null,               // id (será generado por la BD)
                            $nombre,
                            $apellido,
                            $email,
                            $contrasena,
                            $fotoPerfil,
                            $nombreEmpresa,     // nombreComercio
                            $nifEmpresa,
                            $comentarioEmpresa 
                        );
                        
                        $this->dbUser->guardarComerciante($nuevoComerciante);
                    } else {
                        // Si es visitante normal
                        $nuevoUsuario = new UsuarioRegistrado(
                            null,
                            $nombre,
                            $apellido,
                            $email,
                            $contrasena,
                            $tipoUsuario,
                            $fotoPerfil
                        );
                        
                        $this->dbUser->guardarUsuario($nuevoUsuario);
                    }
                    
                    // Redirigir o mostrar éxito
                    header('Location: index.php?success=Usuario registrado exitosamente');
                    exit;
                    
                } catch (Exception $e) {
                    $errores[] = "Error al guardar el usuario: " . $e->getMessage();
                    $mensaje_error = implode("<br>", $errores);
                    include 'views/auth/register.php';
                }
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

    public function iniciarSesion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $errores = [];

            if (empty($email)) {
                $errores[] = "El email es obligatorio";
            }
            
            if (empty($contrasena)) {
                $errores[] = "La contraseña no puede estar vacía";
            }
            
            if (empty($errores)) {
                try {
                    $usuario = $this->dbUser->comprobarUsuario($email, $contrasena);

                    if (!empty($usuario)) {
                        // Iniciar sesión
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }

                        $_SESSION['usuario'] = [
                            'id' => $usuario->getIdUsuario(),
                            'email' => $usuario->getEmail(),
                            'nombre' => $usuario->getNombre(),
                            'apellido' => $usuario->getApellido(),
                            'tipo' => $usuario->getTipo()->value,
                            'login_time' => time(),
                        ];

                        // Si es comerciante, obtener datos adicionales
                        if ($usuario->getTipo()->value === 'COMERCIANTE') {
                            $comerciante = $this->dbUser->usuarioComerciante($usuario);
                            
                            if ($comerciante && $comerciante->getIdComerciante()) {
                                $_SESSION['usuario']['id_comerciante'] = $comerciante->getIdComerciante();
                                $_SESSION['usuario']['nombre_comercio'] = $comerciante->getNombreComercio();
                                $_SESSION['usuario']['rubro'] = $comerciante->getRubro();
                            }
                        }
                        
                        header('Location: index.php');
                        exit;
                    } else { 
                        $errores[] = "Usuario o contraseña incorrectos";
                        $mensaje_error = implode("<br>", $errores);
                        include '/views/auth/login.php';
                    }
                } catch (Exception $e) {
                    $errores[] = "Error al iniciar sesión: " . $e->getMessage();
                    $mensaje_error = implode("<br>", $errores);
                    include 'views/auth/login.php';
                }
            } else {
                $mensaje_error = implode("<br>", $errores);
                include 'views/auth/login.php';
            }
        } else {
            include 'views/auth/login.php';
        }
    } 

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();
        session_destroy();
        
        // Regenerar ID de sesión por seguridad
        session_start();
        session_regenerate_id(true);
        
        header('Location: index.php');
        exit;
    }
    public function favourites(){
        $id=$_SESSION["usuario"]["id"];
        $anuncios = $this->dbUser->sacarfavoritos($id);
        require_once __DIR__ . '/../views/favoritos.php';
           
    }
    public function verAnuncios(){
        $id=$_SESSION["usuario"]["id"];
        $anuncios = $this->dbUser->verMisAnuncios($id);
        require_once BASE_URL.'views/misAdds.php';
    }
    public function miPerfil(){
        $id=$_SESSION["usuario"]["id"];
        $perfil = $this->dbUser->verMisAnuncios($id);
        require_once BASE_URL.'views/misAdds.php';
    }
}
?>