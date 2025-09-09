<?php

// DEFINICIÓN DE PARÁMETROS PARA CONECTARNOS A LA BASE DE DATOS
define ('DB_HOSTNAME', '127.0.0.1');
define ('DB_PORT', 3306);
define ('DB_USER', 'root');
define ('DB_PASSWD', '');
define ('DB_SCHEMA', 'dwes07');

// CONEXIÓN DSN
define ('DB_DSN', 'mysql:host='.DB_HOSTNAME.';port='.DB_PORT.';dbname='.DB_SCHEMA);

if (!defined('DB_USER') || !defined('DB_PASSWD'))
{
    die("<H1>Configura en ".__FILE__." las constantes DB_USER y DB_PASSWD");
}
