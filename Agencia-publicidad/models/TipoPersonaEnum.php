<?php 
namespace AgenciaPublicidad\Models;

enum TipoPersonaEnum: string {
    case ADMINISTRADOR = 'ADMINISTRADOR';
    case COMERCIANTE = 'COMERCIANTE';
    case VISITANTE = 'VISITANTE';
}
?>