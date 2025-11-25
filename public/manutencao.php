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
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5">
                            <p class="mb-0">Detalhes da Ordem de Manutenção</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <h3>Ordem de Manutenção ID: <?php echo htmlspecialchars($id_ordem); ?></h3>

                    <?php
                    $sql_trem = "SELECT identificador FROM trem WHERE id_trem = :id_trem";
                    $stmt_trem = $conn->prepare($sql_trem);
                    $stmt_trem->bindValue(':id_trem', (int)$id_trem_fk, PDO::PARAM_INT);
                    $stmt_trem->execute();
                    $trem_row = $stmt_trem->fetch(PDO::FETCH_ASSOC);
                    $nome_trem = $trem_row ? $trem_row['identificador'] : 'Trem não encontrado';
                    ?>

                    <p><strong>Trem:</strong> <?php echo htmlspecialchars($nome_trem); ?></p>
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($descricao); ?></p>
                    <p><strong>Data de Abertura:</strong> <?php echo htmlspecialchars($data_abertura); ?></p>
                    <p><strong>Data de Fechamento:</strong> <?php echo htmlspecialchars($data_fechamento); ?></p>
                    <p><strong>Tipo:</strong> <?php echo htmlspecialchars($tipo); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($status_manutencao); ?></p>
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
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5">
                            <p class="mb-0">Ordem de Manutenção</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="scrollAlertas">
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
            </div>
        </main>
    </body>

    </html>

<?php
}
?>