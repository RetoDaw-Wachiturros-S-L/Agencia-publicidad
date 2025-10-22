<?php

use AgenciaPublicidad\Controllers\AdsController;

require_once __DIR__ . '/../utils/auth_helper.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/AdsController.php';

class MainController {
    private $AdsDbFunctions;
    public function __construct()
    {
        $this->AdsDbFunctions = new AdsController();
    }
    
    public function index() {
        $anuncios = $this->AdsDbFunctions->showAll();
        require_once __DIR__ . '/../views/index.php';
    }
    
    public function portada() {
        require_once __DIR__ . '/../views/portada.php';
    }
}

?>