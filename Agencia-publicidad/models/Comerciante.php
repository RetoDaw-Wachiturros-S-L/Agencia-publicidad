<?php
namespace AgenciaPublicidad\Models;
use DateTime;
use AgenciaPublicidad\Models\UsuarioRegistrado;

class Comerciante extends UsuarioRegistrado {
    private string $nombrEmpresa;
    private string $nifEmpresa;
    private string $comentarioEmpresa;
    private string $numeroEmpresa;
    private DateTime $fechaAltaComerciante;


    public function __construct(string $nombrEmpresa, string $nifEmpresa, string $comentarioEmpresa, string $numeroEmpresa, DateTime $fechaAltaComerciante) {
        parent::__construct();
        $this->nombrEmpresa = $nombrEmpresa;
        $this->nifEmpresa = $nifEmpresa;
        $this->comentarioEmpresa = $comentarioEmpresa;
        $this->numeroEmpresa = $numeroEmpresa;
        $this->fechaAltaComerciante = $fechaAltaComerciante;
    }
    public function getNombrEmpresa(): string {
        return $this->nombrEmpresa;
    }
    public function setNombrEmpresa(string $nombrEmpresa): void {
        $this->nombrEmpresa = $nombrEmpresa;
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