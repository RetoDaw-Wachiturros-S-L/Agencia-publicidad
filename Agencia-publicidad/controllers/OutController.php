<?php
namespace AgenciaPublicidad\Controllers;


use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\TipoPersonaEnum;
use AgenciaPublicidad\Models\DBFunctions;

// Cargas directas para entornos sin autoloader
require_once __DIR__ . '/../models/UsuarioRegistrado.php';
require_once __DIR__ . '/../models/TipoPersonaEnum.php';
require_once __DIR__ . '/../models/dataBase/DBFunctions.php';

    // require_once __DIR__ . '/../models/UsuarioRegistrado.php';
    // require_once __DIR__ . '/../models/TipoPersonaEnum.php';
    // require_once __DIR__ . '/../models/DBFunctions.php';

class OutController {
    
    private DBFunctions $dbFunctions;
    
    public function __construct() {
        $this->dbFunctions = new DBFunctions();
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
            
            // Si no hay errores, procesar el registro
            if (empty($errores)) {
                // Aquí guardarías en la base de datos
            $nuevoUsuario = new UsuarioRegistrado(
                $nombre,
                $apellido,
                $email,
                $contrasena,
                new \DateTime(),
                null,
                TipoPersonaEnum::VISITANTE); //se tiene que poner la opcion pero si no poner VISITANTE por defecto

                $this->dbFunctions->guardarUsuario($nuevoUsuario);
                
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
        $this->dbFunctions->guardarUsuario($nuevoUsuario);
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
                $errores[] = "La constraseña no puede estar vacia subnormal";
            }
            if(empty($errores)){
                //Almaceno en usuarioData la información del usuario solicitado
                $usuarioData = $this->dbFunctions->comprobarUsuario($email, $contrasena);
                //Si existe procedo a crear la sesion
                if (!empty($usuarioData)) {
                    echo "Iniciaste sesión correctamente";
                    $usuario = new UsuarioRegistrado(
                        $usuarioData['nombre'],
                        $usuarioData['apellido'],
                        $usuarioData['email'],
                        '', // No guardes la contraseña
                        new \DateTime($usuarioData['fecha_inscripcion']), //La ia me recomienda almacenar la fecha asique pa dentro
                        $usuarioData['foto_perfil'] ?? null, //No es para nada necesario asique tampoco lo guardamos
                        TipoPersonaEnum::from($usuarioData['tipo_usuario'])
                    );
                    // Mostrar el estado del objeto UsuarioRegistrado
                    echo "<pre>Objeto UsuarioRegistrado:\n";
                    var_dump($usuario);
                    echo "</pre>";
                    $_SESSION['usuario'] = [
                        // 'id' => $usuarioData['id'], En cuanto se pueda, hacer función para obtener el id
                        'email' => $usuarioData['email'],
                        'nombre' => $usuarioData['nombre'],
                        'apellido' => $usuarioData['apellido'],
                        'tipo' => $usuarioData['tipo_usuario'],
                        'login_time' => time()
                    ];
                    // Mostrar el estado de la sesión
                    echo "<pre>Contenido de \$_SESSION['usuario']:\n";
                    var_dump($_SESSION['usuario']);
                    echo "</pre>";
                } else {
                    echo "Usuario o contraseña incorrectos";
                }
            } else {
                // Mostrar errores
                $mensaje_error = implode("<br>", $errores);
                include 'Views/auth/login.php';
            }
        } else {
            include 'Views/auth/login.php';
        }
    } 

}

?>