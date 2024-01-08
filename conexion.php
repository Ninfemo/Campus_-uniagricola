<?php

$servidor="localhost"; //127.0.0.1
$baseDeDatos="proyecto-diu";
$usuario="root";
$contrasenia="";

try
{
    $conexion = new PDO("mysql:host=$servidor; dbname=$baseDeDatos", $usuario, $contrasenia);
}catch(Exception $ex){
    echo $e->getMessage("Esta malo mi papa");
}

?>