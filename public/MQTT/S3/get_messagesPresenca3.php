<?php
require("../phpMQTT.php");
include '../dbbrokerconnect.php';   

$server = "81e7fafe091e4b09b0b93bf45fb52950.s1.eu.hivemq.cloud";
$port = 8883;
$topic = "Presenca3";
$client_id = "phpmqtt-" . rand();

$username = "s3_Marco";
$password = "Loscrias#67";
$cafile = __DIR__ . "../cacert.pem";
$message = 0;

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

if($message <> 0 && $message <> ""){
    $sensor_id = 9;
    $sensor_type = "S3";
    $topico = "Presenca3";

    $stmt = $conn->prepare("INSERT INTO sensor_data (sensor_id, sensor_type, topico, valor) VALUES (?, ?, ?, ?)");
    
    $stmt->bind_param("issi",$sensor_id, $sensor_type, $topico,$message);

    if ($stmt->execute()) {
        echo "teste" . $message;
    } else {
        echo "Erro ao inserir dados: " . $stmt->error;
    }

    $stmt->close();
}