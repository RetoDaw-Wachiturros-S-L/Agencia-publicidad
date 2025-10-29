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
    public function show() {
        $id = $_GET["id"] ?? null;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay id");
        
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");

		$anuncio = $this->dbFunctions->getById($id);
        $fechaFormateada = $anuncio->getFechaPublicacion()->format('Y-m-d H:i');
        
        // Verificar si el anuncio está en favoritos del usuario actual
        $esFavorito = false;
        if (isset($_SESSION['usuario']['id'])) {
            $esFavorito = $this->dbFunctions->isFavorito($id, $_SESSION['usuario']['id']);
        }
        
        require "views/ads/one.add.view.php";
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

    public function edit() {
        //no hace falta obtener el id comerciante xq se da por hecho que la sesion del admin o del comerciante ya lo tiene implicito
        $id = $_GET['id'] ?? null;
        // echo "El id existe ";
        // echo $id ?? 0;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay");
        // echo "El id existe dps de la primera validacion";
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");
        
        // echo "El id seigue existiendo dps de las validaciones";
        $anuncio = $this->dbFunctions->getById($id);
        $fechaFormateada = $anuncio->getFechaPublicacion()->format('Y-m-d H:i');

        require __DIR__ . "/../views/ads/ads.update.php";
    }

    public function delete():bool {
        $id = $_POST["idAnuncio"] ?? null;
        if(!isset($id)) throw new \Exception("No se puede borrar un anuncio si no se proporciona un Id");
        return $this->dbFunctions->delete($id);
    }

    public function create() {

        // Usar las funciones del auth_helper
        if (!\Agenciapublicidad\Utils\isLoggedIn()) {
            http_response_code(403);
            echo "Error: Usuario no autenticado";
            require_once __DIR__ . '/../views/errors/403.php';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            // Recibir todos los datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'] ?? '';
            $fotoPortadaIndex = (int)($_POST['foto_portada'] ?? 0);
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
                    urlFotos: null,
                    descripcion: $descripcion,
                    fechaPublicacion: new \DateTime,
                    anunciante: null, //usuario comerciante
                    categorias: $categorias,                 
                );

                try {
                    // Verificar que el usuario sea comerciante antes de intentar crear
                    $currentUser = $_SESSION['usuario'] ?? null;
                    if (!$currentUser || $currentUser['tipo'] != 'COMERCIANTE') {
                        echo "<script>alert('ERROR: Solo los comerciantes pueden crear anuncios. Tu tipo de usuario es: " . ($currentUser['tipo'] ?? 'NO DEFINIDO') . "'); window.history.back();</script>";
                        exit;
                    }
                    
                    // Crear anuncio y obtener el ID
                    $idAnuncio = $this->dbFunctions->create($anuncio);

                    // Procesar imágenes si existen
                    if (!empty($_FILES['fotos']['name'][0])) {
                        require_once __DIR__ . '/../models/dataBase/FotosDB.php';
                        require_once __DIR__ . '/../utils/ImageUploader.php';
                        
                        $fotosDB = new \AgenciaPublicidad\Models\dataBase\FotosDB();
                        
                        $totalFiles = count($_FILES['fotos']['name']);
                        
                        for ($i = 0; $i < $totalFiles && $i < 5; $i++) {
                            $file = [
                                'name' => $_FILES['fotos']['name'][$i],
                                'type' => $_FILES['fotos']['type'][$i],
                                'tmp_name' => $_FILES['fotos']['tmp_name'][$i],
                                'error' => $_FILES['fotos']['error'][$i],
                                'size' => $_FILES['fotos']['size'][$i]
                            ];
                            
                            $result = \AgenciaPublicidad\Utils\ImageUploader::uploadImage($file, $idAnuncio);
                            
                            if ($result['success']) {
                                $esPortada = ($i === $fotoPortadaIndex);
                                $fotosDB->guardarFoto(
                                    $idAnuncio,
                                    $result['data']['medium'],
                                    $i,
                                    $esPortada
                                );
                            }
                        }
                    }

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