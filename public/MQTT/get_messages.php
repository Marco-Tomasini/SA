<?php
require("phpMQTT.php");
include '../db.php';

$server = "81e7fafe091e4b09b0b93bf45fb52950.s1.eu.hivemq.cloud";
$port = 8883;
$topic = "S1/umidade";
$client_id = "phpmqtt-" . rand();

$username = "s1_Brayan";
$password = "Loscrias#67";
$cafile = __DIR__ . "/cacert.pem";
$message = "";



$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
$mqtt->cafile = $cafile;
if (!$mqtt->connect(true, NULL, $username, $password)) {
    echo "Não foi possível conectar ao broker";
    exit;
}

// Subscribing e coletando mensagens por 1-2 segundos
$mqtt->subscribe([
    $topic => [
        "qos" => 0,
        "function" => function ($topic, $msg) use (&$message) {
            if (!empty($msg)) {
                $message = (int)$msg;
            }
        }
    ]
], 0);

$start = time();
while (time() - $start < 2) { // escuta 2 segundos
    $mqtt->proc();
}

$mqtt->close();

echo $message;


if ($message <> 0) {
        $sql = "INSERT INTO sensor_data (sensor_id, sensor_type, valor, topico) 
                VALUES (:sensor_id, :sensor_type, :valor, :topico)";
        
        $sensor_id = 1;
        $sensor_type = 'S1';
        $valor = (float)$message; // Cast to float, change to (int) if 'valor' is INT in DB
        $topico = $topic;

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sensor_id', $sensor_id, PDO::PARAM_INT);
        $stmt->bindParam(':sensor_type', $sensor_type, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR); // Use PARAM_INT if 'valor' is INT
        $stmt->bindParam(':topico', $topico, PDO::PARAM_STR);
        $stmt->execute();
        
        echo "Dados inseridos com sucesso!";
}