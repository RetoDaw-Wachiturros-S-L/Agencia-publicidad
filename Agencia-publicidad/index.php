<?php 
require "Router.php";
include "./models/UsuarioRegistrado.php";
include "./models/tipoPersonaEnum.php";

use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\TipoPersonaEnum;

// Usuario 1: Comerciante
$usuario1 = new UsuarioRegistrado(
    "Laura",
    "Gómez",
    "laura.gomez@example.com",
    "hash123",
    new DateTime("2025-10-13 11:00:00"),
    "laura.jpg",
    TipoPersonaEnum::COMERCIANTE
);

// Usuario 2: Visitante sin apellido ni foto
$usuario2 = new UsuarioRegistrado(
    "Carlos",
    null,
    "carlos.ruiz@example.com",
    "hash456",
    new DateTime("2025-10-12 09:30:00"),
    null,
    TipoPersonaEnum::VISITANTE
);

// Usuario 3: Administrador
$usuario3 = new UsuarioRegistrado(
    "Ana",
    "Martínez",
    "ana.martinez@example.com",
    "hash789",
    new DateTime("2025-10-10 14:15:00"),
    "ana.png",
    TipoPersonaEnum::ADMINISTRADOR
);

echo $usuario1->getNombre(); // "Laura"
echo $usuario2->getApellido() ?? 'No tiene ningun apellido'; // ""
echo $usuario3->getTipo()->value; // TipoPersonaEnum::ADMINISTRADOR

//Router::dispatch();





?>