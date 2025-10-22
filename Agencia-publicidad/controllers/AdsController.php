<?php 
namespace AgenciaPublicidad\Controllers;

require_once __DIR__ . '/../utils/auth_helper.php';
require_once __DIR__ . '/../models/Anuncio.php';
require_once __DIR__ . '/../models/dataBase/AnunciosDB.php';

use AgenciaPublicidad\Models\Anuncio;
use AgenciaPublicidad\Models\dataBase\AnunciosDB;

class AdsController{
    private AnunciosDB  $dbFunctions;
    
    public function __construct(){
        $this->dbFunctions = new AnunciosDB();
    }

    public function showAll():array {
        $anuncios = $this->dbFunctions->getAll();
        // if($anuncios){
        //     echo json_encode($anuncios);
        // }else{
        //     echo "anuncios nulos";
        // }
        return $anuncios;
    }

    //TODO todas las funciones deberian de devolver algo a la view de momento solo estamos depurando
    public function show():?Anuncio {

        $id = $_GET["id"] ?? null;
        echo $id;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay id");
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");

		$anuncio = $this->dbFunctions->getById($id);
        
        return $anuncio;
    }

    public function showAllByIdComerciante(){
        $idComerciante = $_SESSION['usuario']['id_comerciante'] ?? null;

        if(!isset($idComerciante)){
            echo "El id de comerciante no existe en la BD";
            require "views/index.php";
        } 
        $anunciosPorIdComerciante = $this->dbFunctions->getAllByIdComerciante($idComerciante);

        require "views/ads/ads.delete.php";
    }

    public function edit(int $id, Anuncio $anuncio):bool {
        //no hace falta obtener el id comerciante xq se da por hecho que la sesion del admin o del comerciante ya lo tiene implicito
        $id = $_POST["id"] ?? null;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay");
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");

        return $this->dbFunctions->update($id,$anuncio);
    }

    public function delete():bool {
        $id = $_POST["idAnuncio"] ?? null;
        if(!isset($id)) throw new \Exception("No se puede borrar un anuncio si no se proporciona un Id");
        return $this->dbFunctions->delete($id);
    }

    public function create() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            // Recibir todos los datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'] ?? '';
            $urlFotos = $_POST['url_fotos'] ?? null;
            $categorias = $_POST['categorias'] ?? null; 

            // Validaciones

            $errores = [];
            
            if (empty($titulo)) {
                $errores[] = "El titulo es obligatorio";
            }

            // Si no hay errores, procesar el registro
            if (empty($errores)) {
                //crea un obj anuncio y lo manda a insert
                $anuncio = new Anuncio(
                    id: null, //id
                    titulo: $titulo,
                    urlFotos: $urlFotos,
                    descripcion: $descripcion,
                    fechaPublicacion: new \DateTime,
                    anunciante: null, //usuario comerciante
                    categorias: $categorias,                 
                );

                try {
                    // Verificar que el usuario sea comerciante antes de intentar crear
                    $currentUser = $_SESSION['usuario'] ?? null;
                    if (!$currentUser || !$currentUser['tipo']=='ADMINISTRADOR' || !$currentUser['tipo']=='COMERCIANTE') {
                        echo "<script>alert('ERROR: Solo los comerciantes pueden crear anuncios. Tu tipo de usuario es: " . ($currentUser['tipo'] ?? 'NO DEFINIDO') . "'); window.history.back();</script>";
                        exit;
                    }
                    
                    $this->dbFunctions->create($anuncio);
                    echo "<script>alert('Anuncio creado con éxito'); window.location.href='index.php';</script>";
                } catch (\Exception $e) {
                    error_log("AdsController::create - Error: " . $e->getMessage());
                    echo "<script>alert('ERROR: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
                    exit;
                }
            }
        
        }  else {
            // Si no es POST, mostrar el formulario
            include 'views/ads/ads.create.php';
        }

    }
    public function buscarByPalabra(){
        $palabras = $_POST['buscar_palabra'] ?? null;

        if($palabras){
            //Si el campo buscar_palabra tiene algo hará la consulta, si no hará la select de todo
            $anuncios = $this->dbFunctions->getByPalabra($palabras);
        }else{
            $anuncios = $this->dbFunctions->getAll();
        }
        require __DIR__ . '/../views/ads/ads.view.php';
    }
}