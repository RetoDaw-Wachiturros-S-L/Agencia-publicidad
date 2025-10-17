<?php

class MainController {
    
    public function index() {
        echo "<h1>🎨 Bienvenido a Nuestra Agencia de Publicidad</h1>";
        echo "<p>Esta es la página principal de la agencia.</p>";
        echo "<nav>";
        echo "<a href='index.php?controller=OutController&accion=store'>📝 Registro de Usuario</a><br>";
        echo "<a href='index.php?controller=mainController&accion=about'>ℹ️ Sobre Nosotros</a><br>";
        echo "<a href='index.php?controller=AdsController.php&accion=getAll'>Obtener todos los anuncios</a><br>";
        echo "<a href='index.php?controller=OutController&accion=iniciarSesion'>Login de Usuario</a><br>";
        echo "<a href='index.php?controller=OutController&accion=logout'>Logout</a><br>";
        echo "</nav>";
    }
    
    public function about() {
        echo "<h1>Sobre Nosotros</h1>";
        echo "<p>Somos una agencia de publicidad especializada en marketing digital.</p>";
        echo "<a href='index.php'>🏠 Volver al inicio</a>";
    }
}

?>