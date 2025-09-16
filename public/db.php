<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "smartcitiesv7";

$conn = new mysqli($servername,$username,$password,$dbname);

if ( $conn -> connect_error ){
    die("Conexão Falhou " . $conn->connect_error);
}
