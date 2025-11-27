<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}


if (isset($_GET['id'])) {
    $id_ordem = $_GET['id'];

    $sql = "SELECT * FROM ordem_manutencao WHERE id_ordem='$id_ordem'";
    $result = $conn->query($sql);
    $manutencao_row = $result->fetch(PDO::FETCH_ASSOC);

    $id_trem_fk = $manutencao_row['id_trem_fk'];
    $data_abertura = $manutencao_row['data_abertura'];
    $data_fechamento = $manutencao_row['data_fechamento'];
    $tipo = $manutencao_row['tipo'];
    $descricao = $manutencao_row['descricao'];
    $status_manutencao = $manutencao_row['status_manutencao'];

?>


    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Detalhes da Ordem de Manutenção</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../styles/style.css">
    </head>

    <body>
        <main>
            <div class="container-fluid p-0">
                <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                    <div class="col-8 welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='manutencao.php'"></i>
                            <p class="mb-0">Detalhes da Ordem de Manutenção</p>
                        </div>
                    </div>

                    <div class="col-3 d-flex justify-content-end align-items-center">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <i class="bi bi-bell fs-4 me-3 text-light" onclick="window.location.href='alertas.php'" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center mt-5">
                    <div class="col-11 col-md-7">
                        <div class="card text-center rounded-4">
                            <div class="card-header cardHeaderAlertas rounded-top-4">
                                <p class=" text-center tituloDark fs-1 fw-medium mb-0">Ordem de Manutenção ID: <?php echo htmlspecialchars($id_ordem); ?></p>
                            </div>
                            <div class="card-body">
                                <?php
                                $sql_trem = "SELECT identificador FROM trem WHERE id_trem = :id_trem";
                                $stmt_trem = $conn->prepare($sql_trem);
                                $stmt_trem->bindValue(':id_trem', (int)$id_trem_fk, PDO::PARAM_INT);
                                $stmt_trem->execute();
                                $trem_row = $stmt_trem->fetch(PDO::FETCH_ASSOC);
                                $nome_trem = $trem_row ? $trem_row['identificador'] : 'Trem não encontrado';
                                ?>
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Trem: </p>
                                    <p><?php echo htmlspecialchars($nome_trem); ?></p>
                                </div>
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Descrição: </p>
                                    <p><?php echo htmlspecialchars($descricao); ?></p>
                                </div>
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Data de Abertura: </p>
                                    <p><?php echo htmlspecialchars($data_abertura); ?></p>
                                </div>
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Data de Fechamento: </p>
                                    <p><?php echo htmlspecialchars($data_fechamento); ?></p>
                                </div>
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Tipo: </p>
                                    <p><?php echo htmlspecialchars($tipo); ?></p>
                                </div>
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Status: </p>
                                    <p><?php echo htmlspecialchars($status_manutencao); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>

    </html>

<?php
} else {


    $sql = "SELECT * FROM ordem_manutencao";

    $resultOrdem = $conn->query($sql);
    $ordens = $resultOrdem->fetchAll(PDO::FETCH_ASSOC);

?>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ordens de Manutenção</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <link rel="stylesheet" href="../styles/style.css">
    </head>

    <body>
        <main>
            <div class="container-fluid p-0">
                <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                    <div class="col-8 welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'"></i>
                            <p class="mb-0">Ordem de Manutenção</p>
                        </div>
                    </div>

                    <div class="col-3 d-flex justify-content-end align-items-center">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <i class="bi bi-bell fs-4 me-3 text-light" onclick="window.location.href='alertas.php'" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <?php
                $ordens = array_filter($ordens, function ($row) {
                    return !empty($row['tipo']) || !empty($row['mensagem']);
                });
                ?>

                <?php if (count($ordens) > 0): ?>
                    <?php foreach ($ordens as $row): ?>
                        <div class="row row-cols-1 border-bottom border-black">
                            <div class="col-12 d-flex align-items-center mt-3 mb-3">
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <img src="../assets/icon/Ellipse 16.svg" alt="">
                                </div>

                                <div class="col-9" onclick="location.href='manutencao.php?id=<?php echo $row['id_ordem']; ?>'" style="cursor: pointer;">
                                    <?php
                                    $sql_trem = "SELECT identificador FROM trem WHERE id_trem = :id_trem";
                                    $stmt_trem = $conn->prepare($sql_trem);
                                    $stmt_trem->bindParam(':id_trem', $row['id_trem_fk'], PDO::PARAM_INT);
                                    $stmt_trem->execute();
                                    $trem_row = $stmt_trem->fetch(PDO::FETCH_ASSOC);
                                    $nome_trem = $trem_row ? $trem_row['identificador'] : 'Trem não encontrado';
                                    ?>
                                    <p class="mb-1"><strong>Trem:</strong> <?php echo htmlspecialchars($nome_trem); ?></p>
                                    <p class="mb-1"><?php echo htmlspecialchars($row['descricao']); ?></p>
                                    <p class="mb-1"><?php echo htmlspecialchars($row['tipo']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center mt-3 mb-3 text-muted">
                        <p>Nenhum alerta disponível.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </body>

    </html>

<?php
}
?>