<?php 
namespace AgenciaPublicidad\Models;

use DateTime;

class Anuncio{
    private int $id;
    private string $titulo;
    private array $urlFotos;
    private string $descripcion;
    private DateTime $fechaPublicacion;
    private UsuarioRegistrado $anunciante;
    private array $categorias;
    
    public function __construct(int $id, string $titulo, ?array $urlFotos, ?string $descripcion, ?float $precio, DateTime $fechaPublicacion, UsuarioRegistrado $anunciante, ?array $categorias){
        $this->id = $id;
        $this->titulo = $titulo;
        $this->urlFotos = $urlFotos;
        $this->descripcion = $descripcion;
        $this->fechaPublicacion = $fechaPublicacion;
        $this->anunciante = $anunciante;
        $this->categorias = $categorias;
    }

    public function getTitulo(): string{
        return $this->titulo;
    }
    public function setTitulo(string $titulo): void{
        $this->titulo = $titulo;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombre(): string {
        return $this->titulo;
    }

    public function setNombre(string $nombre): void {
        $this->titulo = $nombre;
    }

    public function getUrlFotos(): ?array {
        return $this->urlFotos;
    }

    public function setUrlFotos(?array $urlFotos): void {
        $this->urlFotos = $urlFotos;
    }

    public function getDescripcion(): ?string {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): void {
        $this->descripcion = $descripcion;
    }


    public function getFechaPublicacion(): DateTime {
        return $this->fechaPublicacion;
    }

    public function setFechaPublicacion(DateTime $fechaPublicacion): void {
        $this->fechaPublicacion = $fechaPublicacion;
    }

    public function getAnunciante(): UsuarioRegistrado {
        return $this->anunciante;
    }

    public function setAnunciante(UsuarioRegistrado $anunciante): void {
        $this->anunciante = $anunciante;
    }

    public function getCategorias(): ?array {
        return $this->categorias;
    }

    public function setCategorias(?array $categorias): void {
        $this->categorias = $categorias;
    }

}

?>