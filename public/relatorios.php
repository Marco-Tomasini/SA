<?php

include 'db.php';

$sql = "SELECT nome_viagem FROM viagem";

$resultRelatorios = $conn->query($sql);
$relatorios = $resultRelatorios->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dashboard'])) {
        header('Location: dashboard.php');
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios e Análises</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body class="overflow-y-hidden">
    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" href="../public/dashboard.php" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt=""></button>
                    <p class="mb-0">Relatórios e Análises</p>
                </div>

                <div class="col-4">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="">
                        <?php if ($resultRelatorios->rowCount() > 0): ?>
                            <?php foreach ($relatorios as $row): ?>

                                <div class="row row.cols-1 border-bottom border-black">
                                    <div class="col-12 d-flex align-items-center mt-3 mb-3">
                                        <div class="col-4" onclick="location.href='relatorioDetalhado.php?nome_viagem=<?php echo urlencode($row['nome_viagem']); ?>'">
                                            <p class="mb-0"><?php echo htmlspecialchars($row['nome_viagem']); ?></p>
                                        </div>

                                        <div class="col-2">
                                            <img src="../assets/icon/train 1.svg" alt="" class="ms-3">
                                        </div>

                                        <div class="col-6 d-flex justify-content-center align-items-center">
                                            <p  class="mb-0">Em breve...</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>



    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>