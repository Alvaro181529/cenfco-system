<?php
$host = '127.0.0.1'; 
$user = 'root';
$password = '';
$dbname = 'cenefco';

$mysqli = new mysqli($host, $user, $password, $dbname);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}
return $mysqli;
