<?php

function conexion($bd_config) {
    $conn = new mysqli('localhost', $bd_config['usuario'], $bd_config['pass'], $bd_config['basedatos']);

    if($conn->connect_errno) {
        return false;
    } else {
        return $conn;
    }
}

function close_conexion($conexion) {
    $thread = $conexion->thread_id;
    $conexion->kill($thread);
    $conexion->close();
}

function limpiarDatos($datos) {
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    
    return $datos;
}

function pagina_actual() {
    return isset($_GET['p']) ? (int)$_GET['p'] : 1;
}

function obtener_post($post_por_pagina, $conexion) {
    $inicio = (pagina_actual() > 1) ? pagina_actual() * $post_por_pagina - $post_por_pagina : 0;
    $statement = $conexion->query("
        SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT $inicio, $post_por_pagina 
    ");

    $sentencia = array();

    while($rows = $statement->fetch_assoc()) {
        $articulo = array(
            'id'        => $rows['id'],
            'titulo'    => $rows['titulo'],
            'extracto'  => $rows['extracto'],
            'fecha'     => $rows['fecha'],
            'texto'     => $rows['texto'],            
            'thumb'     => $rows['thumb']
        );
        array_push($sentencia, $articulo);
    }

    return $sentencia;
}

function numero_paginas($post_por_pagina, $conexion) {
    $total_post = $conexion->query("SELECT COUNT(*) total FROM articulos");
    $total_post = $total_post->fetch_assoc()['total'];

    $numero_paginas = ceil($total_post / $post_por_pagina);

    return $numero_paginas;
}

function id_articulo($id) {
    return (int)limpiarDatos($id);
}

function obtener_post_por_id($conexion, $id) {
    $resultado = $conexion->query("
        SELECT * FROM articulos WHERE id = $id LIMIT 1
    ");
    $resultado = $resultado->fetch_assoc();

    return ($resultado) ? $resultado : false;
}

function fecha($fecha) {
    $timestamp = strtotime($fecha);
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

    $dia = date('d', $timestamp);
    $mes = date('m', $timestamp) - 1;
    $year = date('Y', $timestamp);

    $fecha = "$dia de " . $meses[$mes] . " del $year";

    return $fecha;
};

function comprobar_session() {
    if(!isset($_SESSION['admin'])) {
        header('Location: ' . RUTA);
    }
}

