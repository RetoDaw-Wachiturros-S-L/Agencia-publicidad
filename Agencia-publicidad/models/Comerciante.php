<?php
namespace AgenciaPublicidad\Models;

use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\TipoPersonaEnum;
use Stringable;

class Comerciante extends UsuarioRegistrado {
    private ?int $idComerciante;
    private ?string $nombreComercio;
    private ?string $nifEmpresa;
    private ?string $rubro;
    private ?string $numTelefono;

    public function __construct(
        ?int $idComerciante = null,
        ?int $id = null,
        string $nombre = '',
        ?string $apellido = null,
        string $email = '',
        string $contrasena = '',
        ?string $fotoPerfil = null,
        ?string $nombreComercio = null,
        ?string $nifEmpresa = '',
        ?string $rubro = null,
        ?string $numTelefono = null
    ) {
        // Llamar al constructor padre PRIMERO
        parent::__construct(
            $id,
            $nombre,
            $apellido,
            $email,
            $contrasena,
            TipoPersonaEnum::COMERCIANTE,
            $fotoPerfil
        );
        
        // Luego inicializar las propiedades de Comerciante
        $this->idComerciante = $idComerciante;
        $this->nombreComercio = $nombreComercio;
        $this->nifEmpresa = $nifEmpresa;
        $this->rubro = $rubro;
        $this->numTelefono = $numTelefono;
    }

    // Getters
    public function getIdComerciante(): ?int {
        return $this->idComerciante;
    }

    public function getNombreComercio(): ?string {
        return $this->nombreComercio;
    }

    public function getRubro(): ?string {
        return $this->rubro;
    }

    // Setters
    public function setIdComerciante(?int $idComerciante): void {
        $this->idComerciante = $idComerciante;
    }
    public function getNifEmpresa():?string{
        return $this->nifEmpresa;
    }

    public function setNifEmpresa(?string $nifEmpersa):void{
        $this->nifEmpresa = $nifEmpersa;
    }

    public function setNombreComercio(?string $nombreComercio): void {
        $this->nombreComercio = $nombreComercio;
    }

    public function setRubro(?string $rubro): void {
        $this->rubro = $rubro;
    }
    public function getNumTelefono():?string{
        return $this->numTelefono;
    }
    public function setNumTelefono(?string $numTelefono):void{
        $this->numTelefono = $numTelefono;
    }
    

    // Método para obtener información completa
    public function toArray(): array {
        return [
            'idComerciante' => $this->idComerciante,
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'apellido' => $this->getApellido(),
            'email' => $this->getEmail(),
            'tipo' => $this->getTipo()->value,
            'fotoPerfil' => $this->getFotoPerfil(),
            'nombreComercio' => $this->nombreComercio,
            'nifEmpresa'=>$this->nifEmpresa,
            'rubro' => $this->rubro,
            'numTelefono' => $this->numTelefono,
        ];
    }
}