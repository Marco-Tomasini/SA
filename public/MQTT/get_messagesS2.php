<?php
// Inclui a biblioteca phpMQTT
require("phpMQTT.php");
// Inclui o arquivo de conexão simples com a função de inserção
require("conexao_simples.php");

// 1. Configurações do MQTT (Baseado na análise do arquivo .ino)
$server   = 'ssl://81e7fafe091e4b09b0b93bf45fb52950.s1.eu.hivemq.cloud';
$port     = 8883; 
$client_id = "phpmqtt-s2-subscriber-" . rand();
$username = 's2_Enzo'; // Credencial específica do S2
$password = 'Loscrias#67';

// 2. Conexão com o Broker MQTT
$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)){
    echo "Erro ao conectar ao broker MQTT.\n";
    exit(1);
}

echo "Conectado ao broker MQTT: $server:$port\n";

// 3. Tópicos a serem assinados (S2)
$topics = [
    "Presenca1"      => ["qos" => 0, "function" => function ($topic, $msg) {
        $value = trim($msg);
        echo "[" . date("Y-m-d H:i:s") . "] MENSAGEM RECEBIDA (S2): Tópico: $topic, Mensagem: $value\n";
        inserir_dado_simples($topic, $value);
    }],
    "Presenca2"      => ["qos" => 0, "function" => function ($topic, $msg) {
        $value = trim($msg);
        echo "[" . date("Y-m-d H:i:s") . "] MENSAGEM RECEBIDA (S2): Tópico: $topic, Mensagem: $value\n";
        inserir_dado_simples($topic, $value);
    }],
    "ilum"           => ["qos" => 0, "function" => function ($topic, $msg) {
        $value = trim($msg);
        echo "[" . date("Y-m-d H:i:s") . "] MENSAGEM RECEBIDA (S2): Tópico: $topic, Mensagem: $value\n";
        inserir_dado_simples($topic, $value);
    }],
];

$mqtt->subscribe($topics, 0);

// 4. Loop de Escuta Contínua
echo "Iniciando o loop de escuta contínua para S2... Pressione Ctrl+C para parar.\n";
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