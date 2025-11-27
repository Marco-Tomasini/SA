<?php
// =========================================================================================
// 1. CONFIGURAÇÃO E LÓGICA PHP PARA RELATÓRIOS (Filtro por Tópico)
// =========================================================================================

include 'db.php'; // Inclui a conexão com o banco de dados (Variável $conn)

$sensorTipos = ['S1', 'S2', 'S3', 'trem'];
$selectedSensorTipo = $_GET['sensor_tipo'] ?? null;
$selectedTopic = $_GET['topico'] ?? null;
$topicos = [];
$historico = [];
$mensagemStatusRelatorio = "Selecione um tipo de sensor e, em seguida, um tópico para visualizar o histórico de comandos.";

// Lógica de busca de Tópicos e Histórico
if ($selectedSensorTipo && in_array($selectedSensorTipo, $sensorTipos)) {
    try {
        // Busca Tópicos Distintos para o Tipo de Sensor Selecionado
        $sqlTopicos = "SELECT DISTINCT topico FROM sensor WHERE tipo = :sensorTipo ORDER BY topico";
        $stmtTopicos = $conn->prepare($sqlTopicos);
        $stmtTopicos->bindParam(':sensorTipo', $selectedSensorTipo);
        $stmtTopicos->execute();
        $topicos = $stmtTopicos->fetchAll(PDO::FETCH_COLUMN);

        $mensagemStatusRelatorio = "Selecione um tópico para ver os dados de **$selectedSensorTipo**.";
        
        // Se um tópico também foi selecionado, busca o histórico
        if ($selectedTopic) {
            // Busca Histórico de Comandos para o Tópico Selecionado (limitado aos 50 mais recentes)
            $sqlHistorico = "SELECT id, sensor_type, topico, valor, received_at FROM sensor_data WHERE topico = :topico ORDER BY received_at DESC LIMIT 50";
            $stmtHistorico = $conn->prepare($sqlHistorico);
            $stmtHistorico->bindParam(':topico', $selectedTopic);
            $stmtHistorico->execute();
            $historico = $stmtHistorico->fetchAll(PDO::FETCH_ASSOC);

            if (empty($historico)) {
                 $mensagemStatusRelatorio = "Nenhum dado encontrado para o tópico **$selectedTopic**.";
            } else {
                 $mensagemStatusRelatorio = "Histórico dos últimos 50 comandos para o tópico **$selectedTopic** de **$selectedSensorTipo**.";
            }
        }
    } catch (PDOException $e) {
        $mensagemStatusRelatorio = "Erro no Banco de Dados (Relatórios): " . $e->getMessage();
    }
}


// =============================================================
// 2. LÓGICA PHP PARA STATUS ATUAL (Velocidade e Localização)
// =============================================================

$velocidade = ['valor' => 0, 'status' => 'Parado', 'atualizado_em' => 'N/A'];
$ultimaLocalizacao = ['estacao' => 'Desconhecida', 'atualizado_em' => 'N/A'];

try {
    // 2.1. BUSCA DA VELOCIDADE (Último valor do tópico 'trem/velocidade')
    $sqlVelocidade = "SELECT valor, received_at FROM sensor_data WHERE topico = 'trem_Carlos' ORDER BY received_at DESC LIMIT 1";
    $stmtVelocidade = $conn->query($sqlVelocidade);
    $resultVelocidade = $stmtVelocidade->fetch(PDO::FETCH_ASSOC);

    if ($resultVelocidade) {
        $v = (int)$resultVelocidade['valor'];
        $velocidade['valor'] = $v;
        $velocidade['atualizado_em'] = (new DateTime($resultVelocidade['received_at']))->format('H:i:s');
        if ($v > 0) {
            $velocidade['status'] = 'Em Movimento';
        }
    }

    // 2.2. BUSCA DA ÚLTIMA LOCALIZAÇÃO (Presença S2 e S3)
    $topicosPresenca = [
        'Presenca1' => 'Estação S2-A', 
        'Presenca2' => 'Estação S2-B', 
        'Presenca1' => 'Estação S3-A', 
        'Presenca2' => 'Estação S3-B', 
        'Presenca3' => 'Estação S3-C'
    ];
    $topicosString = "'" . implode("','", array_keys($topicosPresenca)) . "'";
    
    // Busca o último registro de presença POSITIVA (valor > 0)
    $sqlLocalizacao = "
        SELECT 
            topico, 
            received_at 
        FROM 
            sensor_data 
        WHERE 
            topico IN ($topicosString) 
            AND valor > 0 
        ORDER BY 
            received_at DESC 
        LIMIT 1
    ";

    $stmtLocalizacao = $conn->query($sqlLocalizacao);
    $resultLocalizacao = $stmtLocalizacao->fetch(PDO::FETCH_ASSOC);

    if ($resultLocalizacao) {
        $topicoEncontrado = $resultLocalizacao['topico'];
        // Pega o nome amigável da Estação
        $ultimaLocalizacao['estacao'] = $topicosPresenca[$topicoEncontrado] ?? "Localização Desconhecida";
        $ultimaLocalizacao['atualizado_em'] = (new DateTime($resultLocalizacao['received_at']))->format('H:i:s');
    }

} catch (PDOException $e) {
    // Apenas registra o erro para não quebrar a página de relatórios
    error_log("Erro ao buscar status: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios e Status do Trem</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body class="bodyGeral">
    <main>
        <div class="container-fluid p-0">
            <div class="row headerDash d-flex justify-content-between align-items-center sticky-top" style="background-color: #343a40; color: white;">
                <div class="col-8 welcome lh-1">
                    <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                        <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'" style="cursor: pointer;"></i>
                        <p class="mb-0">Relatórios e Status Operacional</p>
                    </div>
                </div>
                <div class="col-3 d-flex justify-content-end align-items-center">
                    <i class="bi bi-bell fs-4 me-3 text-light" onclick="window.location.href='alertas.php'" style="cursor: pointer;"></i>
                    <?php include 'partials/sidebar.php'; ?>
                </div>
            </div>
            <div class="container mt-4">

                <h2 class="mb-3">🚅 Status Atual do Trem</h2>
                <div class="row g-3 mb-5">
                    
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100 border-start border-5 border-<?php echo ($velocidade['status'] === 'Em Movimento') ? 'success' : 'warning'; ?>">
                            <div class="card-body">
                                <h5 class="card-title text-muted">Velocidade (km/h)</h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="display-4 mb-0 fw-bold"><?php echo $velocidade['valor']; ?></p>
                                    <span class="badge bg-<?php echo ($velocidade['status'] === 'Em Movimento') ? 'success' : 'warning'; ?> p-2 fs-6">
                                        <?php echo $velocidade['status']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer text-muted small">
                                Último dado: <?php echo $velocidade['atualizado_em']; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100 border-start border-5 border-primary">
                            <div class="card-body">
                                <h5 class="card-title text-muted">Última Localização Registrada</h5>
                                <p class="display-6 mb-0 fw-bold text-primary"><?php echo $ultimaLocalizacao['estacao']; ?></p>
                                <p class="text-secondary small mt-1 mb-0">(Baseado em Presença S2/S3)</p>
                            </div>
                            <div class="card-footer text-muted small">
                                Visto às: <?php echo $ultimaLocalizacao['atualizado_em']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>

                <h2 class="mt-4">📊 Histórico de Comandos (Relatórios)</h2>

                <h4 class="mt-4">Passo 1: Tipo de Sensor</h4>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php foreach ($sensorTipos as $tipo): ?>
                        <a href="?sensor_tipo=<?php echo $tipo; ?>" 
                           class="btn btn-lg 
                                <?php echo ($selectedSensorTipo == $tipo) ? 'btn-success' : 'btn-primary'; ?>">
                            <?php echo strtoupper($tipo); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($topicos)): ?>
                    <h4 class="mt-4">Passo 2: Tópico MQTT</h4>
                    <div class="d-flex flex-wrap gap-2 mb-4 p-3 border rounded">
                        <?php foreach ($topicos as $topico): ?>
                            <a href="?sensor_tipo=<?php echo $selectedSensorTipo; ?>&topico=<?php echo urlencode($topico); ?>" 
                               class="btn 
                                    <?php echo ($selectedTopic == $topico) ? 'btn-info text-white' : 'btn-outline-secondary'; ?> topico-btn">
                                <?php echo $topico; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <hr>

                <h3 class="mt-4">📋 Dados Coletados</h3>
                <p class="text-muted"><?php echo $mensagemStatusRelatorio; ?></p>
                
                <?php if (!empty($historico)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo Sensor</th>
                                    <th>Tópico</th>
                                    <th>Valor</th>
                                    <th>Recebido em</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historico as $data): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($data['id']); ?></td>
                                        <td><?php echo htmlspecialchars($data['sensor_type']); ?></td>
                                        <td><?php echo htmlspecialchars($data['topico']); ?></td>
                                        <td><span class="badge bg-primary"><?php echo htmlspecialchars($data['valor']); ?></span></td>
                                        <td><?php echo htmlspecialchars($data['received_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Recarrega a página inteira a cada 15 segundos (15000 milissegundos)
        // Isso garante que o status do trem no topo esteja sempre atualizado.
        // O filtro de relatórios também será mantido, pois os parâmetros GET (sensor_tipo e topico)
        // são passados automaticamente no recarregamento.
        setTimeout(function(){
            window.location.reload(1);
        }, 15000); 
    </script>
</body>

</html>