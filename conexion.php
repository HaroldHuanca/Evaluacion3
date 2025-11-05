<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "evaluacion3";
//$port = 3307

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    echo "<h1>¡Error al conectar con la base de datos!</h1>";
    //die("Error de conexión a la base de datos: " . $con->connect_error);
}
?>