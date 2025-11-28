<?php
// =========================================================================================
// 1. CONFIGURAÇÃO E LÓGICA PHP PARA RELATÓRIOS (Mantida Original)
// =========================================================================================

include 'db.php'; // Inclui a conexão com o banco de dados

$sensorTipos = ['S1', 'S2', 'S3', 'trem'];
$selectedSensorTipo = $_GET['sensor_tipo'] ?? null;
$selectedTopic = $_GET['topico'] ?? null;
$topicos = [];
$historico = [];
$mensagemStatusRelatorio = "Selecione um tipo de sensor e, em seguida, um tópico para visualizar o histórico.";

// Lógica de busca de Tópicos e Histórico
if ($selectedSensorTipo && in_array($selectedSensorTipo, $sensorTipos)) {
    try {
        $sqlTopicos = "SELECT DISTINCT topico FROM sensor WHERE tipo = :sensorTipo ORDER BY topico";
        $stmtTopicos = $conn->prepare($sqlTopicos);
        $stmtTopicos->bindParam(':sensorTipo', $selectedSensorTipo);
        $stmtTopicos->execute();
        $topicos = $stmtTopicos->fetchAll(PDO::FETCH_COLUMN);

        $mensagemStatusRelatorio = "Selecione um tópico para ver os dados de **$selectedSensorTipo**.";

        if ($selectedTopic) {
            $sqlHistorico = "SELECT id, sensor_type, topico, valor, received_at FROM sensor_data WHERE topico = :topico ORDER BY received_at DESC LIMIT 50";
            $stmtHistorico = $conn->prepare($sqlHistorico);
            $stmtHistorico->bindParam(':topico', $selectedTopic);
            $stmtHistorico->execute();
            $historico = $stmtHistorico->fetchAll(PDO::FETCH_ASSOC);

            if (empty($historico)) {
                $mensagemStatusRelatorio = "Nenhum dado encontrado para o tópico **$selectedTopic**.";
            } else {
                $mensagemStatusRelatorio = "Histórico dos últimos 50 comandos para o tópico **$selectedTopic**.";
            }
        }
    } catch (PDOException $e) {
        $mensagemStatusRelatorio = "Erro no Banco de Dados: " . $e->getMessage();
    }
}

// =============================================================
// 2. LÓGICA PHP PARA STATUS ATUAL (Mantida Original)
// =============================================================

$velocidade = ['valor' => 0, 'status' => 'Parado', 'atualizado_em' => 'N/A'];
$ultimaLocalizacao = ['estacao' => 'Desconhecida', 'atualizado_em' => 'N/A'];

try {
    // 2.1. BUSCA DA VELOCIDADE
    $sqlVelocidade = "SELECT valor, received_at FROM sensor_data WHERE topico = 'trem_Carlos' ORDER BY received_at DESC LIMIT 1";
    $stmtVelocidade = $conn->query($sqlVelocidade);
    $resultVelocidade = $stmtVelocidade->fetch(PDO::FETCH_ASSOC);

    if ($resultVelocidade) {
        $v = (int)$resultVelocidade['valor'];
        $velocidade['valor'] = $v;
        $velocidade['atualizado_em'] = (new DateTime($resultVelocidade['received_at']))->format('H:i:s');
        if ($v > 0) $velocidade['status'] = 'Em Movimento';
    }

    // 2.2. BUSCA DA ÚLTIMA LOCALIZAÇÃO
    $topicosPresenca = [
        'Presenca1' => 'Estação S2-A', 'Presenca2' => 'Estação S2-B',
        'Presenca1' => 'Estação S3-A', 'Presenca2' => 'Estação S3-B', 'Presenca3' => 'Estação S3-C'
    ];
    $topicosString = "'" . implode("','", array_keys($topicosPresenca)) . "'";

    $sqlLocalizacao = "SELECT topico, received_at FROM sensor_data WHERE topico IN ($topicosString) AND valor > 0 ORDER BY received_at DESC LIMIT 1";
    $stmtLocalizacao = $conn->query($sqlLocalizacao);
    $resultLocalizacao = $stmtLocalizacao->fetch(PDO::FETCH_ASSOC);

    if ($resultLocalizacao) {
        $topicoEncontrado = $resultLocalizacao['topico'];
        $ultimaLocalizacao['estacao'] = $topicosPresenca[$topicoEncontrado] ?? "Localização Desconhecida";
        $ultimaLocalizacao['atualizado_em'] = (new DateTime($resultLocalizacao['received_at']))->format('H:i:s');
    }
} catch (PDOException $e) {
    error_log("Erro ao buscar status: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios e Status</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icon/logoSite.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body class="bodyGeral">
    <main>
        <div class="container-fluid p-0">
            
            <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                <div class="col-8 welcome lh-1">
                    <div class="col ms-4 fw-bold fs-5 d-flex align-items-center sticky-top">
                        <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'" style="cursor: pointer;"></i>
                        <p class="mb-0">Relatórios e Status Operacional</p>
                    </div>
                </div>

                <div class="col-4 col-lg-3 d-flex justify-content-end align-items-center">
                    <div class="col-5 col-md-3 d-flex justify-content-start align-items-center">
                        <i class="bi bi-bell fs-4 me-2 text-light" onclick="window.location.href='alertas.php'" style="cursor: pointer;"></i>
                    </div>
                    <div class="col-5 col-md-3 d-flex justify-content-end align-items-center">
                        <?php include 'partials/sidebar.php'; ?>
                    </div>
                </div>
            </div>
            <div class="container mt-5 mb-5">

                <div class="row mb-4">
                    <div class="col-12">
                         <h3 class="fw-bold mb-3"><i class="bi bi-speedometer2 me-2"></i>Status Atual</h3>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card shadow border-0 rounded-4 h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4">
                                <h5 class="text-secondary fw-semibold">Velocidade (km/h)</h5>
                                <div class="my-3">
                                    <span class="display-3 fw-bold <?php echo ($velocidade['status'] === 'Em Movimento') ? 'text-success' : 'text-warning'; ?>">
                                        <?php echo $velocidade['valor']; ?>
                                    </span>
                                </div>
                                <span class="badge rounded-pill <?php echo ($velocidade['status'] === 'Em Movimento') ? 'bg-success' : 'bg-warning text-dark'; ?> fs-6 px-3 py-2">
                                    <?php echo $velocidade['status']; ?>
                                </span>
                                <small class="text-muted mt-3">Atualizado às: <?php echo $velocidade['atualizado_em']; ?></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow border-0 rounded-4 h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4">
                                <h5 class="text-secondary fw-semibold">Última Localização</h5>
                                <div class="my-3">
                                    <span class="display-6 fw-bold text-primary">
                                        <?php echo $ultimaLocalizacao['estacao']; ?>
                                    </span>
                                </div>
                                <p class="text-muted small mb-0">(Baseado em sensores S2/S3)</p>
                                <small class="text-muted mt-3">Visto às: <?php echo $ultimaLocalizacao['atualizado_em']; ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5 text-secondary">

                <div class="row mb-3">
                    <div class="col-12">
                        <h3 class="fw-bold"><i class="bi bi-clipboard-data me-2"></i>Histórico de Comandos</h3>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <p class="fs-5 mb-2">1. Selecione o Tipo:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($sensorTipos as $tipo): ?>
                                <a href="?sensor_tipo=<?php echo $tipo; ?>"
                                   class="btn rounded-4 fw-semibold px-4 py-2 
                                   <?php echo ($selectedSensorTipo == $tipo) ? 'btn-success text-white shadow' : 'btn-dark text-white-50'; ?>">
                                    <?php echo strtoupper($tipo); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($topicos)): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <p class="fs-5 mb-2 mt-3">2. Selecione o Tópico:</p>
                        <div class="d-flex flex-wrap gap-2 p-3 bg-light rounded-4 shadow-sm border">
                            <?php foreach ($topicos as $topico): ?>
                                <a href="?sensor_tipo=<?php echo $selectedSensorTipo; ?>&topico=<?php echo urlencode($topico); ?>"
                                   class="btn rounded-4 btn-sm fw-semibold px-3 
                                   <?php echo ($selectedTopic == $topico) ? 'btn-primary shadow' : 'btn-outline-secondary border-0'; ?>">
                                    <?php echo $topico; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                            <div class="card-header bg-dark text-white p-3">
                                <span class="fw-semibold"><?php echo $mensagemStatusRelatorio; ?></span>
                            </div>
                            
                            <?php if (!empty($historico)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Sensor</th>
                                            <th>Tópico</th>
                                            <th>Valor</th>
                                            <th>Recebido em</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($historico as $data): ?>
                                            <tr>
                                                <td>#<?php echo htmlspecialchars($data['id']); ?></td>
                                                <td><?php echo htmlspecialchars($data['sensor_type']); ?></td>
                                                <td><span class="fw-bold"><?php echo htmlspecialchars($data['topico']); ?></span></td>
                                                <td>
                                                    <span class="badge rounded-pill bg-primary px-3">
                                                        <?php echo htmlspecialchars($data['valor']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-muted small"><?php echo htmlspecialchars($data['received_at']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                                <div class="p-5 text-center text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    Nenhum dado para exibir no momento.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div> </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script>
        // Reload automático para atualizar status do trem (15s)
        setTimeout(function() {
            window.location.reload(1);
        }, 15000);
    </script>
</body>

</html>