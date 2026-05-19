<?php
//conexión a la base de datos
$host='localhost';
$usuario='dekeva';
$contraseña='passDekeva#1234';
$db='configurador_presupuestos';

$conexion = new mysqli($host, $usuario, $contraseña, $db);

if($conexion->connect_error){
    die("Conexión de la bases de datos: Error --> " . $conexion->connect_error);
}
?>