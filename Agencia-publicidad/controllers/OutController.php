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
        // Verificar que la petición sea POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Recibir todos los datos del formulario
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $contrasena2 = $_POST['contrasena2'] ?? '';
            $fotoPerfil = $_POST['fotoPerfil'] ?? null;
            
            // Validaciones básicas
            // TODO Pasar validaciones a UTILS
            $errores = [];
            
            if (empty($nombre)) {
                $errores[] = "El nombre es obligatorio";
            }
            
            if (empty($email)) {
                $errores[] = "El email es obligatorio";
            }
            
            if (strlen($contrasena) < 6) {
                $errores[] = "La contraseña debe tener al menos 6 caracteres";
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
                include 'Views/auth/register.php';
            }
            
        } else {
            // Si no es POST, mostrar el formulario
            include 'Views/auth/register.php';
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
                //Comprobar usuario devuelve Usuario si es true y si no devuelve null
                $usuario = $this->dbUser->comprobarUsuario($email, $contrasena);
                if($usuario->getTipo() == TipoPersonaEnum::COMERCIANTE){
                    $comerciante = $this->dbUser->usuarioComerciante($usuario);
                }
                echo "<pre>DEBUG - Usuario devuelto: ";
                // var_dump($usuario);
                var_dump($comerciante);
                echo "</pre>";
                //Si existe procedo a crear la sesion
                if (!(empty($usuario) && empty($comerciante))) {

                    $_SESSION['usuario'] = [
                        'id' => $usuario->getIdUsuario(),
                        'email' => $usuario->getEmail(),
                        'nombre' => $usuario->getNombre(),
                        'apellido' => $usuario->getApellido(),
                        'tipo' => $usuario->getTipo()->value,
                        'login_time' => time(),
                        'id_comerciante' => $comerciante->getIdComerciante(),
                    ];

                    // Mostrar el estado de la sesión DEBUG
                    echo "<pre>Contenido de \$_SESSION['usuario']:\n";
                    var_dump($_SESSION['usuario']);
                    echo "</pre>";

                } else { echo "Usuario o contraseña incorrectos"; }
            } else {
                // Mostrar errores
                $mensaje_error = implode("<br>", $errores);
                include 'Views/auth/login.php';
            }
        } else {
            include 'Views/auth/login.php';
        }
    } 

    public function logout() {
        echo "Entra en logout";
        if (isset($_SESSION['usuario'])) {
            echo "Sesion cerrada";
            session_destroy();
            header("Location: ../index.php?controller=mainController");
            exit;
        }
    }

}

?>