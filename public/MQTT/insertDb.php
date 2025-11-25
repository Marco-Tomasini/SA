<?php


function inserir_dado_simples($topic, $value) {
    global $conexao;
    
    // Extrai o tipo de sensor e o ID do sensor do tópico
    $parts = explode('/', $topic);
    if (count($parts) !== 2) {
        echo "AVISO: Tópico com formato inválido: $topic. Ignorando.\n";
        return false;
    }
    $sensor_id   = $parts[0];
    $sensor_type = $parts[1];

    // Validação básica de dados
    if (!is_numeric($value)) {
        echo "AVISO: Valor não numérico recebido para o tópico $topic. Ignorando.\n";
        return false;
    }

    // Proteção básica contra SQL Injection (usando mysqli_real_escape_string)
    $sensor_id_esc = mysqli_real_escape_string($conexao, $sensor_id);
    $sensor_type_esc = mysqli_real_escape_string($conexao, $sensor_type);
    $value_esc = mysqli_real_escape_string($conexao, $value);

    $sql = "INSERT INTO sensor_data (sensor_id, sensor_type, value, received_at) 
            VALUES ('$sensor_id_esc', '$sensor_type_esc', '$value_esc', NOW())";
    
    if (mysqli_query($conexao, $sql)) {
        echo "DADOS SALVOS (Simples): Tópico: $topic, Valor: $value\n";
        return true;
    } else {
        echo "ERRO ao salvar no DB: " . mysqli_error($conexao) . "\n";
        return false;
    }
}

?>