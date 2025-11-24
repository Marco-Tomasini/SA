<?php

session_start();
include 'db.php';

$sql = "SELECT id_viagem, nome_viagem, data_partida, data_chegada_previsao, data_chegada, status_viagem, nome_viagem 
        FROM viagem";

$resultViagem = $conn->query($sql);
$viagens = $resultViagem->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM alerta";

$resultAlerta = $conn->query($sql);
$alertas = $resultAlerta->fetchAll(PDO::FETCH_ASSOC);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body class="overflow-y-hidden">
    <main>
        <div class="container-fluid fullscreen p-0">
            <div class="row headerDash d-flex align-items-center">
                <div class="col-8 mt-4 ms-5 welcome lh-1">
                    <p>Bem-vindo(a)</p>
                    <p class="fw-bold fs-5" onclick="window.location.href='upload_foto.php'" style="cursor: pointer;"><?php echo htmlspecialchars($_SESSION['nome']); ?></p>
                </div>

                <div class="col-4 me-4">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
            <div class="scrollViagens">
                <?php if (count($viagens) > 0): ?>
                    <?php foreach ($viagens as $row): ?>
                        <div class="row d-flex justify-content-between border-bottom border-black mt-2">
                            <div class="col-4 d-flex flex-column justify-items-between align-items-start ms-3 ms-md-5">
                                <div class="d-flex">
                                    <?php $partida = new DateTime($row['data_partida']); ?>
                                    <p class="mb-1"><?php echo $partida->format('H:i'); ?></p>
                                    <p class="mb-1"> ··· </p>
                                    <?php $chegadaPrev = new DateTime($row['data_chegada_previsao']); ?>
                                    <p class="mb-1"><?php echo $chegadaPrev->format('H:i'); ?></p>
                                </div>
                                <div class="d-flex flex-column align-items-center previsaoDash">
                                    <?php
                                    $intervalo = $partida->diff($chegadaPrev);
                                    $minutos = ($intervalo->h * 60) + $intervalo->i;
                                    ?>
                                    <p class="mb-1">Chega em:</p>
                                    <p class="mb-1 tempoPrev"><?php echo $minutos; ?> min</p>
                                </div>
                            </div>

                            <div class="col-7 col- col-md-6 d-flex align-items-center justify-content-center me-3 me-md-5">
                                <div class=" col-4 col-md-2 d-flex flex-column align-items-center justify-content-center">
                                    <p class="mb-0">Status:</p>
                                    <p class="mb-0"><?php echo htmlspecialchars($row['status_viagem']); ?></p>
                                </div>

                                <div class="col d-flex align-items-center justify-content-center text-center">
                                    <p class="mb-0"><?php echo htmlspecialchars($row['nome_viagem']); ?></p>
                                </div>

                                <div class="col-2 d-flex align-items-center justify-content-center">
                                    <img src="../assets/icon/train 1.svg" alt="">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>



            <div class="row alertasDash d-flex align-items-center justify-content-between">
                <div class="col-6 d-flex align-items-center justify-content-start ms-5">
                    <p class="mb-0">Alertas e Notficações</p>
                </div>
                <div class="col-1 d-flex justify-content-center me-5">
                    <img src="../assets/icon/seta-curva-esquerda 2.svg" alt="" height="32">
                </div>
            </div>
            <div class="scrollAlertas">
                <?php if (count($alertas) > 0): ?>
                    <?php foreach ($alertas as $row): ?>
                        <div class="row d-flex justify-content-start align-items-center border-bottom border-black">
                            <div class="col-1 d-flex justify-content-center align-items-center ms-4 mt-2 mb-2 p-0">
                                <img src="../assets/icon/Ellipse 16.svg" alt="">
                            </div>

                            <div class="col d-flex flex-column justify-content-center align-items-start mt-2 mb-2">
                                <p class="mb-1"><?php echo htmlspecialchars($row['tipo']); ?></p>
                                <p class="mb-1"><?php echo htmlspecialchars($row['mensagem']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>