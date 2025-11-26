<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}


if (isset($_GET['id'])) {
    $id_alerta = $_GET['id'];

    $sql = "SELECT * FROM alerta WHERE id_alerta='$id_alerta'";
    $result = $conn->query($sql);
    $alerta_row = $result->fetch(PDO::FETCH_ASSOC);

    $tipo = $alerta_row['tipo'];
    $mensagem = $alerta_row['mensagem'];
    $criticidade = $alerta_row['criticidade'];
    $data_hora = $alerta_row['data_hora'];

?>


    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Detalhes do Alerta</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../styles/style.css">
    </head>

    <body>
        <main>
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8 welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='alertas.php'"></i>
                            <p class="mb-0">Detalhes do Alerta</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-5">
                    <div class="col-11 col-md-7">
                        <div class="card text-center rounded-4">
                            <div class="card-header cardHeaderAlertas rounded-top-4">
                                <p class=" text-center tituloDark fs-1 fw-medium mb-0">Tipo: <?php echo htmlspecialchars($tipo); ?></p>
                            </div>
                            <div class="card-body">
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Mensagem: </p>
                                    <p><?php echo htmlspecialchars($mensagem); ?></p>
                                </div>
                                <div class="text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Criticidade: </p>
                                    <p><?php echo htmlspecialchars($criticidade); ?></p>
                                </div>
                                <div class="card-footer text-body-secondary">
                                    <p class="tituloLight fs-5 mb-0">Data e Hora: </p>
                                    <p class="mb-0"><?php echo htmlspecialchars($data_hora); ?></p>
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


    $sql = "SELECT * FROM alerta";
    $sql2 = "SELECT * FROM alerta_usuario WHERE id_usuario = " . $_SESSION['id_usuario'];

    $resultAlerta = $conn->query($sql);
    $alertas = $resultAlerta->fetchAll(PDO::FETCH_ASSOC);



?>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alertas e Notificações</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <link rel="stylesheet" href="../styles/style.css">
    </head>

    <body>
        <main>
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'"></i>
                            <p class="mb-0">Alertas e Manutenção</p>
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
                    $alertas = array_filter($alertas, function ($row) {
                        return !empty($row['tipo']) || !empty($row['mensagem']);
                    });
                    ?>

                    <?php if (count($alertas) > 0): ?>
                        <?php foreach ($alertas as $row): ?>
                            <div class="row row-cols-1 border-bottom border-black">
                                <div class="col-12 d-flex align-items-center mt-3 mb-3">
                                    <div class="col-1 d-flex justify-content-center align-items-center">
                                        <img src="../assets/icon/Ellipse 16.svg" alt="">
                                    </div>

                                    <div class="col-9" onclick="location.href='alertas.php?id=<?php echo $row['id_alerta']; ?>'" style="cursor: pointer;">
                                        <p class="mb-1"><?php echo htmlspecialchars($row['tipo']); ?></p>
                                        <p class="mb-1"><?php echo htmlspecialchars($row['mensagem']); ?></p>
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