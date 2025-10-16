<?php 
namespace Agenciapublicidad\Agenciapublicidad\Controllers;
use Agenciapublicidad\Models\Anuncio;
use AgenciaPublicidad\Models\DataBase\AnunciosDB;

class AdsController{
    private AnunciosDB $dbFunctions;
    
    public function __construct(){
        $this->dbFunctions = new AnunciosDB();
    }

    public function showAll():array {


        return $this->dbFunctions->getAll();
    }

    public function show(int $id):Anuncio {
        $id = $_POST["id"] ?? null;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay id");
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");

        return $this->dbFunctions->getByID($id);
    }
    public function edit(int $id, Anuncio $anuncio):bool {
        //no hace falta obtener el id comerciante xq se da por hecho que la sesion del admin o del comerciante ya lo tiene implicito
        $id = $_POST["id"] ?? null;

        if(!isset($id)) throw new \Exception("No se puede buscar por un id si no hay");
        if($id == "" || $id <= 0) throw new \Exception("El id no puede ser menor a 0");

        return $this->dbFunctions->update($id,$anuncio);
    }
}

?>;