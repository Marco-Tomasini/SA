<?php

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "smartcitiesv11";

    try{
        $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password);

        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Coneção Falhou, erro: " . $e->getMessage();

    }
    
    if (!isset($conn) || !$conn instanceof PDO) {
        try {
            $servername = "sql305.infinityfree.com";
            $username   = "if0_40538950";
            $password   = "marconic0712";
            $dbname     = "if0_40538950_smartcitiesv11";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Conexão alterna (InfinityFree) falhou: " . $e->getMessage();
        }
    }