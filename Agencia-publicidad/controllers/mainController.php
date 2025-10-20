<?php
require_once __DIR__ . '/../config/config.php';

class MainController {
    
    public function index() {
        require_once __DIR__ . '/../views/index.php';
    }
    
    public function portada() {
        require_once __DIR__ . '/../views/portada.php';
    }
}

?>