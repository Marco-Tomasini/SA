<?php

session_start();
include 'db.php';

$sql = "SELECT id_usuario,imagem_usuario,nome,data_nascimento,cpf FROM usuario";
$result = $mysqli->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dashboard'])) {
        header('Location: dashboard.php');
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../styles/style.css">

    <title>Funcionários</title>
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center sticky-top">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" name="dashboard" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt=""></button>
                    <div class="d-flex flex-column">
                        <p class="mb-0">Gerenciamento de</p>
                        <p class="mb-0 fs-3 fw-bold">Funcionários</p>
                    </div>
                </div>

                <div class="col-4">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex flex-wrap justify-content-between mt-4 ms-5 me-5 gap-3">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="profile">
                            <img src="../assets/img/<?php echo ($row['imagem_usuario']); ?>" alt="user-icon">
                            <h2><?php echo ($row['nome']); ?></h2>
                            <h3><?php echo ($row['data_nascimento']); ?></h3>
                            <h3><?php echo ($row['cpf']); ?></h3>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-center fixed-bottom mb-3">
                    <i class="bi bi-person-fill-add botaoAdd"></i>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>