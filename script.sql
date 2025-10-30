create table categorias
(
    id int auto_increment
        primary key,
    nombre varchar(50) not null,
    constraint nombre
        unique (nombre)
);

create table usuarios
(
    id                int auto_increment
        primary key,
    nombre            varchar(50)                                        not null,
    apellido          varchar(50)                                        null,
    email             varchar(100)                                       not null,
    password_hash     varchar(255)                                       not null,
    fecha_inscripcion datetime default CURRENT_TIMESTAMP                 null,
    foto_perfil       varchar(255)                                       null,
    tipo_usuario      enum ('ADMINISTRADOR', 'COMERCIANTE', 'VISITANTE') not null,
    constraint email
        unique (email)
);

create table comerciantes
(
    id                 int auto_increment
        primary key,
    id_usuario         int                                not null,
    nombre_empresa     varchar(50)                        not null,
    nif_empresa        varchar(9)                         not null,
    comentario_empresa text                               null,
    num_telefono       varchar(20)                        null,
    comerciante_desde  datetime default CURRENT_TIMESTAMP null,
    constraint comerciantes_ibfk_1
        foreign key (id_usuario) references usuarios (id)
            on delete cascade
);

create table anuncios
(
    id                int auto_increment
        primary key,
    id_comerciante    int                                not null,
    titulo            varchar(150)                       not null,
    detalles          text                               null,
    fecha_publicacion datetime default CURRENT_TIMESTAMP null,
    constraint anuncios_ibfk_1
        foreign key (id_comerciante) references comerciantes (id)
            on delete cascade
);

create index idx_anuncios_comerciante
    on anuncios (id_comerciante);

create table anuncios_categorias
(
    id_anuncio   int not null,
    id_categoria int not null,
    primary key (id_anuncio, id_categoria),
    constraint anuncios_categorias_ibfk_1
        foreign key (id_anuncio) references anuncios (id)
            on delete cascade,
    constraint anuncios_categorias_ibfk_2
        foreign key (id_categoria) references categorias (id)
            on delete cascade
);

create index idx_anuncios_categoria
    on anuncios_categorias (id_categoria);

create index id_usuario
    on comerciantes (id_usuario);

create table conversaciones
(
    id             int auto_increment
        primary key,
    id_anuncio     int                                not null,
    id_visitante   int                                not null,
    id_comerciante int                                not null,
    fecha_inicio   datetime default CURRENT_TIMESTAMP null,
    constraint conversaciones_ibfk_1
        foreign key (id_anuncio) references anuncios (id)
            on delete cascade,
    constraint conversaciones_ibfk_2
        foreign key (id_visitante) references usuarios (id)
            on delete cascade,
    constraint conversaciones_ibfk_3
        foreign key (id_comerciante) references comerciantes (id)
            on delete cascade
);

create index id_comerciante
    on conversaciones (id_comerciante);

create index id_visitante
    on conversaciones (id_visitante);

create index idx_conversaciones_anuncio
    on conversaciones (id_anuncio);

create table favoritos
(
    id_usuario     int                                not null,
    id_anuncio     int                                not null,
    fecha_guardado datetime default CURRENT_TIMESTAMP null,
    primary key (id_usuario, id_anuncio),
    constraint favoritos_ibfk_1
        foreign key (id_usuario) references usuarios (id)
            on delete cascade,
    constraint favoritos_ibfk_2
        foreign key (id_anuncio) references anuncios (id)
            on delete cascade
);

create index id_anuncio
    on favoritos (id_anuncio);

create table fotos_anuncios
(
    id           int auto_increment
        primary key,
    id_anuncio   int                                  not null,
    url_foto     varchar(500)                         not null,
    orden        int        default 0                 null comment 'Orden de visualización',
    es_portada   tinyint(1) default 0                 null comment 'Imagen principal del anuncio',
    fecha_subida timestamp  default CURRENT_TIMESTAMP null,
    constraint fotos_anuncios_ibfk_1
        foreign key (id_anuncio) references anuncios (id)
            on delete cascade
);

create index idx_anuncio
    on fotos_anuncios (id_anuncio);

create table mensajes
(
    id              int auto_increment
        primary key,
    id_conversacion int                                  not null,
    id_emisor       int                                  not null,
    contenido       text                                 not null,
    fecha_envio     datetime   default CURRENT_TIMESTAMP null,
    visto           tinyint(1) default 0                 null,
    constraint mensajes_ibfk_1
        foreign key (id_conversacion) references conversaciones (id)
            on delete cascade,
    constraint mensajes_ibfk_2
        foreign key (id_emisor) references usuarios (id)
            on delete cascade
);

create index id_emisor
    on mensajes (id_emisor);

create index idx_mensajes_conversacion
    on mensajes (id_conversacion);


