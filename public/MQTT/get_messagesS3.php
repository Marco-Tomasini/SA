<?php
// Inclui a biblioteca phpMQTT
require("phpMQTT.php");
// Inclui o arquivo de conexão simples com a função de inserção
require("conexao_simples.php");

// 1. Configurações do MQTT (Baseado na análise do arquivo .ino)
$server   = 'ssl://81e7fafe091e4b09b0b93bf45fb52950.s1.eu.hivemq.cloud';
$port     = 8883; 
$client_id = "phpmqtt-s3-subscriber-" . rand();
$username = 's3_Marco'; // Credencial específica do S3
$password = 'Loscrias#67';

// 2. Conexão com o Broker MQTT
$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)){
    echo "Erro ao conectar ao broker MQTT.\n";
    exit(1);
}

echo "Conectado ao broker MQTT: $server:$port\n";

// 3. Tópicos a serem assinados (S3)
$topics = [
    "Presenca3"      => ["qos" => 0, "function" => function ($topic, $msg) {
        $value = trim($msg);
        echo "[" . date("Y-m-d H:i:s") . "] MENSAGEM RECEBIDA (S3): Tópico: $topic, Mensagem: $value\n";
        inserir_dado_simples($topic, $value);
    }],
    "Servo1"         => ["qos" => 0, "function" => function ($topic, $msg) {
        $value = trim($msg);
        echo "[" . date("Y-m-d H:i:s") . "] MENSAGEM RECEBIDA (S3): Tópico: $topic, Mensagem: $value\n";
        inserir_dado_simples($topic, $value);
    }],
    "Servo2"         => ["qos" => 0, "function" => function ($topic, $msg) {
        $value = trim($msg);
        echo "[" . date("Y-m-d H:i:s") . "] MENSAGEM RECEBIDA (S3): Tópico: $topic, Mensagem: $value\n";
        inserir_dado_simples($topic, $value);
    }],
];

$mqtt->subscribe($topics, 0);

// 4. Loop de Escuta Contínua
echo "Iniciando o loop de escuta contínua para S3... Pressione Ctrl+C para parar.\n";
while(true){
    $mqtt->proc();
    usleep(100000); // Pequena pausa para evitar uso excessivo de CPU
}

// 5. Desconexão (Só será alcançado se o loop for interrompido)
$mqtt->close();
// Fecha a conexão mysqli
mysqli_close($conexao);
echo "Desconectado.\n";

?>