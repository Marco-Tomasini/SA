<?php
    $whitelist = array('127.0.0.1', '::1', 'localhost');

    // Verifica se está rodando localmente ou no servidor
    if (in_array($_SERVER['HTTP_HOST'], $whitelist)) {
        $servername = "localhost";
        $username   = "root";
        $password   = "root"; 
        $dbname     = "smartcitiesv11";
    } else {
        $servername = "sql305.infinityfree.com";
        $username   = "if0_40538950";
        $password   = "marconic0712";
        $dbname     = "if0_40538950_smartcitiesv11";
    }

    // Cria a conexão usando MySQLi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
?>