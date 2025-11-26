<?php

session_start();
include 'db.php';

$sql = "SELECT id_usuario,imagem_usuario,nome,data_nascimento,cpf FROM usuario";

$resultFuncionario = $conn->query($sql);
$funcionarios = $resultFuncionario->fetchAll(PDO::FETCH_ASSOC);

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
            <div class="row headerDash d-flex align-items-center">
                <div class="col-8  welcome lh-1">
                    <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                        <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'"></i>
                        <p class="mb-0">Gerenciamento de Funcionários</p>
                    </div>
                </div>

                <div class="col-4">
                    <div class="col d-flex align-items-center justify-content-end">
                        <?php include 'partials/sidebar.php'; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex flex-wrap justify-content-between mt-4 ms-5 me-5 gap-3">
                    <?php foreach ($funcionarios as $row): ?>
                        <div class="profile" onclick="window.location='upload_foto.php?id=<?php echo urlencode($row['id_usuario']); ?>'">
                            <img src="../assets/img/<?php echo ($row['imagem_usuario']); ?>" alt="user-icon">
                            <h2><?php echo ($row['nome']); ?></h2>
                            <h3><?php echo ($row['data_nascimento']); ?></h3>
                            <h3><?php echo ($row['cpf']); ?></h3>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-center fixed-bottom mb-3">
                    <i class="bi bi-person-fill-add botaoAdd" onclick="location.href='create.php'"></i>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>