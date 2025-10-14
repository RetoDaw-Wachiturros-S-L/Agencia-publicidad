<?php

class OutController {
    
    public function store() {
        // Verificar que la petición sea POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Recibir todos los datos del formulario
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $contrasena2 = $_POST['contrasena2'] ?? '';
            $es_comercio = isset($_POST['es_comercio']) ? 1 : 0;
            
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
                $this->guardarUsuario($nombre, $apellido, $email, $contrasena, $es_comercio);
                
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
                //verificar en la base de datos
            } else {
                // Mostrar errores
                $mensaje_error = implode("<br>", $errores);
                include 'Views/auth/login.php';
            }
        }else {
            include 'Views/auth/login.php';
        }
    } 
    private function guardarUsuario($nombre, $apellido, $email, $contrasena, $es_comercio) {
        // Aquí implementarás la lógica para guardar en BD
        // Por ahora solo mostramos los datos recibidos
        echo "<h3>Datos a guardar:</h3>";
        echo "Nombre: $nombre<br>";
        echo "Apellido: $apellido<br>";
        echo "Email: $email<br>";
        echo "Es comercio: " . ($es_comercio ? 'Sí' : 'No') . "<br>";
    }
}

?>