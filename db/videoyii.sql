drop table if exists socios cascade;

create table socios (
    id        bigserial     constraint pk_socios primary key,
    numero    numeric(6)    not null constraint uq_socios_numero unique,
    nombre    varchar(255)  not null,
    direccion varchar(255),
    telefono  numeric(9),
    borrado   bool          default false
);

drop table if exists peliculas cascade;

create table peliculas (
    id      bigserial    constraint pk_peliculas primary key,
    codigo  numeric(4)   not null constraint uq_peliculas_codigo unique,
    titulo  varchar(255) not null,
    precio  numeric(5,2) not null,
    borrado bool         default false
);

drop table if exists alquileres cascade;

create table alquileres (
    id          bigserial    constraint pk_alquileres primary key,
    socio_id    bigint       not null constraint fk_alquileres_socios
                             references socios (id)
                             on delete no action on update cascade,
    pelicula_id bigint       not null constraint fk_alquileres_peliculas
                             references peliculas (id)
                             on delete no action on update cascade,
    precio_alq  numeric(5,2) not null,
    alquilado   timestamptz  not null default current_timestamp,
    devuelto    timestamptz
);

drop table if exists usuarios cascade;

create table usuarios (
    id         bigserial    constraint pk_usuarios primary key,
    nombre     varchar(15)  not null constraint uq_usuarios_nombre unique,
    password   varchar(60)  not null,
    email      varchar(255) not null,
    token      varchar(32),
    activacion varchar(32),
    created_at timestamptz  default current_timestamp
);

create index idx_usuarios_activacion on usuarios (activacion);
create index idx_usuarios_created_at on usuarios (created_at);
