<?php
// Configuración de la conexión a la base de datos
//Conexion ferozo:
/* $dbhost = 'localhost';
$dbuser = 'c2331051_isft';
$dbpass = '48muKOwiwo';
$dbname = 'c2331051_isft'; */

//Conexion db4:
/*
$dbhost = 'localhost';
$dbuser = 'isft225';
$dbpass = 'isft2252023';
$dbname = 'c2331051_isft';
*/
//Conexion don web cuando tengamos alojamiento?:
/*
$dbhost = 'localhost';
$dbuser = 'c1602068_isft225';
$dbpass = 'kifuGAru26';
$dbname = 'c1602068_isft225';
*/


//Conexion local Karina(no usar)
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'c1602068_isft225'; 
    
// Crear la conexión
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
/* $conn->set_charset("utf8"); */

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
?>
