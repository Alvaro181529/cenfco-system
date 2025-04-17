<?php
$host = '127.0.0.1'; 
$user = 'root';
$password = '';
$dbname = 'cenefco';
// $host = '127.0.0.1'; 
// $user = 'u283573835_cenefco';
// $password = 'Cenefco2025';
// $dbname = 'u283573835_cenefco';

$mysqli = new mysqli($host, $user, $password, $dbname);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}
// $mysqli->query("SET SESSION max_allowed_packet = 64*1024*1024");  // 64 MB
return $mysqli;
