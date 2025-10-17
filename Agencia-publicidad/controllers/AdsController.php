<?php 
namespace AgenciaPublicidad\Controllers;

require_once __DIR__ . '/../models/Anuncio.php';
require_once __DIR__ . '/../models/dataBase/AnunciosDB.php';

use AgenciaPublicidad\Models\Anuncio;
use AgenciaPublicidad\Models\DataBase\AnunciosDB;

class AdsController{
    private AnunciosDB $dbFunctions;
    
    public function __construct(){
        $this->dbFunctions = new AnunciosDB();
    }

    public function showAll():void {
        $anuncios = $this->dbFunctions->getAll();
        // if($anuncios){
        //     echo json_encode($anuncios);
        // }else{
        //     echo "anuncios nulos";
        // }
        require __DIR__ . '/../Views/ads/ads.view.php';
    }

    //TODO todas las funciones deberian de devolver algo a la view de momento solo estamos depurando
    public function show():void {
        $id = $_POST["boton"] ?? null;
        echo $id;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay id");
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");

		$anuncio = $this->dbFunctions->getById($id);
    }

    public function edit(int $id, Anuncio $anuncio):bool {
        //no hace falta obtener el id comerciante xq se da por hecho que la sesion del admin o del comerciante ya lo tiene implicito
        $id = $_POST["id"] ?? null;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay");
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");

        return $this->dbFunctions->update($id,$anuncio);
    }

    public function delete(int $id):bool {
        $id = $_POST["id"] ?? null;
        if(!isset($id)) throw new \Exception("No se puede borrar un anuncio si no se proporciona un Id");
        return $this->dbFunctions->delete($id);
    }

    public function create() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            // Recibir todos los datos del formulario
            $titulo = $_POST['titulo'] ?? '';
            $contenido = $_POST['editordata'] ?? '';

            // Validaciones

            $errores = [];
            
            if (empty($nombre)) {
                $errores[] = "El nombre es obligatorio";
            }

            // Si no hay errores, procesar el registro
            if (empty($errores)) {
                
            }
        
        }  else {
            // Si no es POST, mostrar el formulario
            include 'views/ads/ads.create.php';
        }

    }
}