<?php 
namespace AgenciaPublicidad\Models;

use AgenciaPublicidad\Models\TipoPersonaEnum;

class UsuarioRegistrado {
    private ?int $id_usuario;
    private string $nombre;
    private ?string $apellido;
    private string $email;
    private string $contrasena;
    private TipoPersonaEnum $tipo;
    private ?string $foto_perfil;

    public function __construct(
        ?int $id_usuario,
        string $nombre,
        ?string $apellido,
        string $email,
        string $contrasena,
        TipoPersonaEnum $tipo,
        ?string $foto_perfil = null
    ) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->tipo = $tipo;
        $this->foto_perfil = $foto_perfil;
    }

    // Getters
    public function getIdUsuario(): ?int {
        return $this->id_usuario;
    }

    public function getId(): ?int {
        return $this->id_usuario;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellido(): ?string {
        return $this->apellido;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getContrasena(): string {
        return $this->contrasena;
    }

    public function getTipo(): TipoPersonaEnum {
        return $this->tipo;
    }

    public function getFotoPerfil(): ?string {
        return $this->foto_perfil;
    }

    // Setters
    public function setIdUsuario(?int $id_usuario): void {
        $this->id_usuario = $id_usuario;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellido(?string $apellido): void {
        $this->apellido = $apellido;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setContrasena(string $contrasena): void {
        $this->contrasena = $contrasena;
    }

    public function setTipo(TipoPersonaEnum $tipo): void {
        $this->tipo = $tipo;
    }

    public function setFotoPerfil(?string $foto_perfil): void {
        $this->foto_perfil = $foto_perfil;
    }

    // Método toArray para serialización
    public function toArray(): array {
        return [
            'id' => $this->id_usuario,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'tipo' => $this->tipo->value,
            'fotoPerfil' => $this->foto_perfil
        ];
    }
}
?>