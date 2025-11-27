<?php
    $whitelist = array('127.0.0.1', '::1', 'localhost');

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

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch(PDOException $e) {
        echo "Erro na conexão: " . $e->getMessage();
        exit;
    }
?>