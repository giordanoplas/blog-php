<?php

require 'functions.php';
require 'admin/config.php';

$conexion = conexion($bd_config);
if(!$conexion) {
    header('Location: error.php');
}

$articulos= obtener_post($blog_config['post_por_pagina'], $conexion);

if(!$articulos) {
    close_conexion($conexion);
    header('Location: error.php');
}

close_conexion($conexion);

require 'views/index.view.php';


