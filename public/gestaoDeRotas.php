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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <main>
        <div class="container-fluid">
            <div class="row headerDash d-flex align-items-center sticky-top">
                <div class="col-8  welcome lh-1">
                    <div class="col ms-4 fw-bold fs-5">
                        <p class="mb-0">Atualização de Viagem</p>
                    </div>
                </div>

                <div class="col-4">
                    <div class="col d-flex align-items-center justify-content-end">
                        <?php include 'partials/sidebar.php'; ?>
                    </div>
                </div>
            </div>

            <div class="row d-flex flex-column justify-content-center align-items-center p-2 gap-3">
                <?php if (count($segmentos) > 0): ?>
                    <?php foreach ($segmentos as $row): ?>
                        <div class="row d-none d-md-flex justify-content-center align-items-center border-bottom border-black">
                            <div class="col-3 d-flex flex-column flex-lg-row justify-content-start align-items-center mt-2 mb-2" style="cursor: pointer;" onclick="window.location='cadastrorotas.php?id=<?php echo htmlspecialchars($row['id_rota_fk']); ?>'">
                                <?php
                                $rota = $conn->prepare("SELECT nome FROM rota WHERE id_rota = :id_rota");
                                $rota->bindParam(':id_rota', $row['id_rota_fk'], PDO::PARAM_INT);
                                $rota->execute();
                                $nomeRota = $rota->fetch(PDO::FETCH_ASSOC)['nome'];
                                ?>
                                <p class="mb-0  ms-3 me-2 fw-semibold">Rota Pertencente: </p>
                                <p class="mb-0"><?php echo htmlspecialchars($nomeRota); ?></p>
                            </div>

                            <div class="col-6 d-flex flex-column justify-content-center align-items-center mt-2 mb-2" style="cursor: pointer;" onclick="window.location='createSegmentoRota.php?id=<?php echo htmlspecialchars($row['id_segmento_rota']); ?>'">
                                <?php
                                $estacaoOrigem = $conn->prepare("SELECT nome FROM estacao WHERE id_estacao = :id_estacao");
                                $estacaoOrigem->bindParam(':id_estacao', $row['id_estacao_origem'], PDO::PARAM_INT);
                                $estacaoOrigem->execute();
                                $nomeOrigem = $estacaoOrigem->fetch(PDO::FETCH_ASSOC)['nome'];

                                $estacaoDestino = $conn->prepare("SELECT nome FROM estacao WHERE id_estacao = :id_estacao");
                                $estacaoDestino->bindParam(':id_estacao', $row['id_estacao_destino'], PDO::PARAM_INT);
                                $estacaoDestino->execute();
                                $nomeDestino = $estacaoDestino->fetch(PDO::FETCH_ASSOC)['nome'];
                                ?>
                                <div class="col d-flex flex-column justify-content-center align-items-start">
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <p class="mb-0 fw-semibold">Estação Origem: </p>
                                        <p class="ms-2 mb-0"><?php echo htmlspecialchars($nomeOrigem); ?></p>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <p class="mb-0 fw-semibold">Estação Destino: </p>
                                        <p class="ms-2 mb-0"><?php echo htmlspecialchars($nomeDestino); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 d-flex flex-column justify-content-center align-items-end mt-2 mb-2">
                                <div class="col d-flex flex-column justify-content-center align-items-center">
                                    <div class="col d-flex justify-content-end align-items-center">
                                        <p class="mb-0 fw-semibold">Distância: </p>
                                        <p class="ms-2 mb-0"><?php echo htmlspecialchars($row['distancia_km']); ?> km</p>
                                    </div>
                                    <?php if (isset($_SESSION['perfil']) && strcasecmp(trim($_SESSION['perfil']), 'Gerente') === 0): ?>
                                        <button onclick="window.location='createSegmentoRota.php?id=<?php echo htmlspecialchars($row['id_segmento_rota']); ?>'" class="btn btnEditaViagem btn-dark mb-2">Editar</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex d-md-none justify-content-center align-items-center">
                            <div class="card d-flex cardViagem">
                                <div class="card-body d-flex justify-content-center align-items-center p-0 mt-3 mb-3">
                                    <div class="col-9 d-flex gap-3 justify-content-center align-items-center">
                                        <div class="col-5 d-flex flex-column justify-content-center align-items-center">
                                            <?php
                                            $estacaoOrigem = $conn->prepare("SELECT nome FROM estacao WHERE id_estacao = :id_estacao");
                                            $estacaoOrigem->bindParam(':id_estacao', $row['id_estacao_origem'], PDO::PARAM_INT);
                                            $estacaoOrigem->execute();
                                            $nomeOrigem = $estacaoOrigem->fetch(PDO::FETCH_ASSOC)['nome'];

                                            $rota = $conn->prepare("SELECT nome FROM rota WHERE id_rota = :id_rota");
                                            $rota->bindParam(':id_rota', $row['id_rota_fk'], PDO::PARAM_INT);
                                            $rota->execute();
                                            $nomeRota = $rota->fetch(PDO::FETCH_ASSOC)['nome'];
                                            ?>

                                            <p class="mb-0 fw-semibold"><?php echo htmlspecialchars($nomeOrigem); ?></p>
                                            <p class="mb-0 fw-semibold"><?php echo htmlspecialchars($nomeRota); ?></p>
                                        </div>
                                        <div class="col-1 d-flex flex-column justify-content-center align-items-center gap-2">
                                            <i class="bi bi-arrow-right"></i>
                                            <i class="bi bi-dot"></i>
                                        </div>

                                        <div class="col-5 d-flex flex-column justify-content-center align-items-center">
                                            <?php
                                            $estacaoDestino = $conn->prepare("SELECT nome FROM estacao WHERE id_estacao = :id_estacao");
                                            $estacaoDestino->bindParam(':id_estacao', $row['id_estacao_destino'], PDO::PARAM_INT);
                                            $estacaoDestino->execute();
                                            $nomeDestino = $estacaoDestino->fetch(PDO::FETCH_ASSOC)['nome'];
                                            ?>

                                            <p class="mb-0 fw-semibold text-center"><?php echo htmlspecialchars($nomeDestino); ?></p>
                                            <p class="mb-0 fw-semibold text-center"><?php echo htmlspecialchars($row['distancia_km']); ?> km</p>
                                        </div>
                                    </div>

                                    <?php if (isset($_SESSION['perfil']) && strcasecmp(trim($_SESSION['perfil']), 'Gerente') === 0): ?>
                                        <div class="col-3 d-flex justify-content-end align-items-center">
                                            <button onclick="window.location='createSegmentoRota.php?id=<?php echo htmlspecialchars($row['id_segmento_rota']); ?>'" class="btn btnEditaViagem btn-dark">Editar</button>
                                        </div>
                                    <?php endif; ?>
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