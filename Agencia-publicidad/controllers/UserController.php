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


class UserController{


    private DBFunctions $dbFunctions;
    private DBUser $dbUser;
    
    public function __construct() {
        $this->dbFunctions = new DBFunctions();
        $this->dbUser = new DBUser();
    }




    public function editarPerfil(){

        
    }

}

?>