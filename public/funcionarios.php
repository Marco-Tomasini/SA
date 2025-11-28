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
    <link rel="icon" type="image/svg+xml" href="../assets/icon/logoSite.svg">
    <link rel="stylesheet" href="../styles/style.css">

    <title>Funcionários</title>
</head>

<body>
    <main>
        <div class="container-fluid p-0">
            <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                <div class="col-8 welcome lh-1">
                    <div class="col ms-4 fw-bold fs-5 d-flex align-items-center sticky-top">
                        <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'"></i>
                        <p class="mb-0">Gerenciamento de Funcionários</p>
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
            <div class="row d-flex justify-content-center">
                <div class="col-10 col-md-6 col-lg-4">
                    <p type="submit" class="btn btn-dark btnLogin fs-5 mt-5 fw-semibold rounded-4 d-flex align-items-center justify-content-center mb-0" onclick="location.href='create.php'">Adicionar Funcionários</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-4 d-flex flex-wrap justify-content-center align-items-center gy-4 mt-5 mb-5">
                <?php foreach ($funcionarios as $row): ?>
                    <div class="col d-flex justify-content-center">
                        <div class="col-10 card cardFuncionario" onclick="window.location='upload_foto.php?id=<?php echo urlencode($row['id_usuario']); ?>'">
                            <div class="row g-0">
                                <img src="../assets/img/<?php echo ($row['imagem_usuario']); ?>" class="img-fluid rounded-start" alt="user-icon">
                                <div class="col d-flex flex-column justify-content-center">
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <div class="col d-flex justify-content-center">
                                            <p class="card-title tituloLight fs-4 mb-0 text-center"><?php echo ($row['nome']); ?></p>
                                        </div>
                                        <div class="col d-flex flex-column align-items-start justify-content-end mt-4">
                                            <div class="col">
                                                <p class="tituloLight fs-6 mb-0">Data de Nascimento: </p>
                                                <p class=" fs-6 mb-0"><?php echo ($row['data_nascimento']); ?></p>
                                            </div>
                                            <div class="col">
                                                <p class="tituloLight fs-6 mb-0">CPF: </p>
                                                <p class=" fs-6 mb-0"><?php echo ($row['cpf']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>