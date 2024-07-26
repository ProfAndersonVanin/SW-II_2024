<?php
$host = 'localhost';
$dbname = 'cadastro_clientes';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die('Conexão falhou: ' . $mysqli->connect_error);
}
?>
