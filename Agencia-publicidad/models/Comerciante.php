<?php
namespace AgenciaPublicidad\Models;

use DateTime;
use AgenciaPublicidad\Models\TipoPersonaEnum;

// Cargar la clase padre si no existe autoloader
require_once __DIR__ . '/UsuarioRegistrado.php';
require_once __DIR__ . '/TipoPersonaEnum.php';

use AgenciaPublicidad\Models\UsuarioRegistrado;

class Comerciante extends UsuarioRegistrado {
    private ?int $idComerciante;
    private ?string $nombreEmpresa;
    private ?string $nifEmpresa;
    private ?string $comentarioEmpresa;
    private ?string $numeroEmpresa;
    private ?DateTime $fechaAltaComerciante;

    public function __construct(?int $idUsuario, string $nombre, ?string $apellido, string $email, string $password, ?DateTime $fechaInscripcion, ?string $fotoPerfil, TipoPersonaEnum $tipo, ?int $idComerciante,  ?string $nombreEmpresa, ?string $nifEmpresa, ?string $comentarioEmpresa, ?string $numeroEmpresa, ?DateTime $fechaAltaComerciante) {
        // Llamada al constructor padre con los parámetros de UsuarioRegistrado
        parent::__construct($idUsuario, $nombre, $apellido, $email, $password, $fechaInscripcion, $fotoPerfil, $tipo);

        // Inicializar campos específicos de Comerciante
        $this->idComerciante = $idComerciante;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->nifEmpresa = $nifEmpresa;
        $this->comentarioEmpresa = $comentarioEmpresa;
        $this->numeroEmpresa = $numeroEmpresa;
        $this->fechaAltaComerciante = $fechaAltaComerciante;
    }
    public function getIdComerciante():int{
        return $this->idComerciante;
    }
    
    public function setIdComerciante($id):void{
        $this->idComerciante = $id;
    }

    public function getEmail(): string {
        return parent::getEmail();
    }
    public function getNombrEmpresa(): string {
        return $this->nombreEmpresa;
    }
    public function setNombrEmpresa(string $nombrEmpresa): void {
        $this->nombreEmpresa = $nombrEmpresa;
    }
    public function getNifEmpresa(): string{
        return $this->nifEmpresa;
    }
    public function setNifEmpresa(string $nifEmpresa):void{
        $this->nifEmpresa = $nifEmpresa;
    }
    public function getComentarioEmpresa(): string{
        return $this->comentarioEmpresa;
    }
    public function setComentarioEmpresa(string $comentarioEmpresa): void{
        $this->comentarioEmpresa = $comentarioEmpresa;
    }
    public function getNumeroEmpresa(): string{
        return $this->numeroEmpresa;
    }
    public function setNumeroEmpresa(string $numeroEmpresa): void{
        $this->numeroEmpresa = $numeroEmpresa;
    }
    public function getFechaAltaComerciante(): DateTime{
        return $this->fechaAltaComerciante;
    }



}

?>