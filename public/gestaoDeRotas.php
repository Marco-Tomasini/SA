<?php

session_start();
include 'db.php';

$sql = "SELECT * FROM segmento_rota";

$result_segmentorota = $conn->query($sql);
$segmentos = $result_segmentorota->fetchAll(PDO::FETCH_ASSOC);

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Rotas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center sticky-top">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <div class="d-flex flex-column">
                        <p class="mb-0">Atualização de Viagem</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div class="scrollViagens">
                <?php if (count($segmentos) > 0): ?>
                    <?php foreach ($segmentos as $row): ?>
                        <div style="cursor: pointer;" class="row row-cols-1 border-bottom border-black">
                            <div class="col-12 d-flex justify-content-between align-items-center lh-1 mt-3 mb-3">
                                <div class="col-4 d-flex flex-column align-items-start">


                                    <div class="d-flex">
                                        <?php
                                            $rota = $conn->prepare("SELECT nome FROM rota WHERE id_rota = :id_rota");
                                            $rota->bindParam(':id_rota', $row['id_rota_fk'], PDO::PARAM_INT);
                                            $rota->execute();
                                            $nomeRota = $rota->fetch(PDO::FETCH_ASSOC)['nome'];
                                        ?>
                                        <p style="cursor: pointer;" class="mb-1" onclick="window.location='cadastrorotas.php?id=<?php echo htmlspecialchars($row['id_rota_fk']); ?>'">Rota Pertencente: <?php echo htmlspecialchars($nomeRota); ?></p>
                                    </div>


                                </div>

                                <div class="col-4 d-flex flex-column align-items-center">
                                        <p class="mb-1">
                                            <?php
                                                $estacaoOrigem = $conn->prepare("SELECT nome FROM estacao WHERE id_estacao = :id_estacao");
                                                $estacaoOrigem->bindParam(':id_estacao', $row['id_estacao_origem'], PDO::PARAM_INT);
                                                $estacaoOrigem->execute();
                                                $nomeOrigem = $estacaoOrigem->fetch(PDO::FETCH_ASSOC)['nome'];

                                                $estacaoDestino = $conn->prepare("SELECT nome FROM estacao WHERE id_estacao = :id_estacao");
                                                $estacaoDestino->bindParam(':id_estacao', $row['id_estacao_destino'], PDO::PARAM_INT);
                                                $estacaoDestino->execute();
                                                $nomeDestino = $estacaoDestino->fetch(PDO::FETCH_ASSOC)['nome'];

                                                echo '<p style="cursor: pointer; hover: " class="mb-1" onclick="window.location=\'createEstacao.php?id=' . htmlspecialchars($row['id_estacao_origem']) . '\'">Estação Origem: ' . htmlspecialchars($nomeOrigem) . '</p>';
                                                echo '<p style="cursor: pointer;" class="mb-1" onclick="window.location=\'createEstacao.php?id=' . htmlspecialchars($row['id_estacao_destino']) . '\'">Estação Destino: ' . htmlspecialchars($nomeDestino) . '</p>';
                                            ?>
                                        </p>
                                </div>

                                
                                <div class="col-4 d-flex flex-column align-items-end">
                                    <p class="mb-1">Distância: <?php echo htmlspecialchars($row['distancia_km']); ?> km</p>
                                    <button onclick="window.location='createSegmentoRota.php?id=<?php echo htmlspecialchars($row['id_segmento_rota']); ?>'" class="mb-1 btn btn-primary">Editar</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum segmento de rota encontrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>