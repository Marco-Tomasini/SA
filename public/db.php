<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "smartcitiesv7";

// A variável aqui precisa ser $mysqli
$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}
?>
