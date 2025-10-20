<?php 
namespace AgenciaPublicidad\Models;
use DateTime;
use AgenciaPublicidad\Models\TipoPersonaEnum;

class UsuarioRegistrado{
    private ?int $id_usuario;
    private string $nombre;
    private ?string $apellido;
    private string $email;
    private string $password;
    private ?DateTime $fecha_inscripcion;
    private ?string $foto_perfil;
    private TipoPersonaEnum $tipo; 
    // admin, comerciante, visitante

    public function __construct(?int $id_usuario, string $nombre, ?string $apellido, string $email, string $password, ?DateTime $fecha_inscripcion, ?string $foto_perfil, TipoPersonaEnum $tipo) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido ?? '';
        $this->email = $email;
        $this->password = $password;
        $this->fecha_inscripcion = $fecha_inscripcion;
        $this->foto_perfil = $foto_perfil ?? '';
        $this->tipo = $tipo;
    }
    public function getIdUsuario(): ?int {
         return $this->id_usuario; 
    }
    public function setIdUsuario(?int $id_usuario): void {
         $this->id_usuario = $id_usuario; 
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellido
     */ 
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set the value of apellido
     *
     * @return  self
     */ 
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of fecha_inscripcion
     */ 
    public function getFecha_inscripcion()
    {
        return $this->fecha_inscripcion;
    }

    /**
     * Set the value of fecha_inscripcion
     *
     * @return  self
     */ 
    public function setFecha_inscripcion($fecha_inscripcion)
    {
        $this->fecha_inscripcion = $fecha_inscripcion;

        return $this;
    }

    /**
     * Get the value of foto_perfil
     */ 
    public function getFoto_perfil()
    {
        return $this->foto_perfil;
    }

    /**
     * Set the value of foto_perfil
     *
     * @return  self
     */ 
    public function setFoto_perfil($foto_perfil)
    {
        $this->foto_perfil = $foto_perfil;

        return $this;
    }

    /**
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
}



?>