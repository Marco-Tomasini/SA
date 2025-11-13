<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Rotas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body class="overflow-y-hidden">
    <main>
        <div class="container-fluid">
            <div class="row navGestaoRotas">
                <div class="col-8 welcome d-flex flex-column justify-content-center align-items-start ms-4">
                    <button type="button" href="../public/dashboard.php" class="btn btnNav p-0 mb-2"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <p class="fs-5 fw-semibold">Gestão de Rotas</p>
                </div>

                <div class="col d-flex flex-column justify-content-center align-items-end me-4">
                    <div class="col d-flex flex-column justify-content-center align-items-center">
                        <p class="welcome">67%</p>

                        <img src="../assets/icon/train 1.svg" alt="" class=" " width="70vw">
                    </div>
                </div>
            </div>

            <div class="row row-cols-1">
                <div class="col d-flex justify-content-center align-items-center status">
                    <p class=" mb-0 fs-2 p-1">Status</p>
                </div>

                <div class="col d-flex mt-3">
                    <div class="col d-flex flex-column justify-content-center align-items-center">
                        <img src="../assets/icon/bolaVerde.png" alt="">

                        <p>Ok</p>
                    </div>

                    <div class="col d-flex flex-column justify-content-center align-items-center">
                        <img src="../assets/icon/bolaAmarela.png" alt="">

                        <p>Revisão</p>
                    </div>

                    <div class="col d-flex flex-column justify-content-center align-items-center">
                        <img src="../assets/icon/bolaVermelha.png" alt="">

                        <p>Reparo</p>
                    </div>
                </div>
            </div>

            <div class="row emergencyMessage fixed-bottom">
                <div class="col welcome btn d-flex align-items-center justify-content-end p-3 me-3">
                        <p class="mb-0">Emergency Message</p>
                        <i class="bi bi-arrow-right-square-fill ms-3 mb-0 h2"></i>
                </div>
            </div>
        </div>



    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>