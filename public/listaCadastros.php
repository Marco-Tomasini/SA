<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Cadastros</title>

    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body>

    <div class="container-fluid">
        <div class="row headerDash d-flex align-items-center">
            <div class="col-8  welcome lh-1">
                <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                    <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'"></i>
                    <p class="mb-0">Lista de Cadastros</p>
                </div>
            </div>

            <div class="col-4">
                <div class="col d-flex align-items-center justify-content-end">
                    <?php include 'partials/sidebar.php'; ?>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 d-flex flex-column align-items-center justify-content-center gap-4 mt-5">
            <div class="col-sm-12 col-md-9 col-lg-7 col-xl-6 d-flex justify-content-between">
                <Button class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="location.href='createTrem.php'">Cadastro de Trem</Button>
                <Button class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="location.href='createAlerta.php'">Cadastro de Alerta</Button>
                <Button class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="location.href='cadastrorotas.php'">Cadastro de Rotas</Button>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-7 col-xl-6 d-flex justify-content-between">
                <Button class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="location.href='createViagem.php'">Cadastro de Viagem</Button>
                <Button class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="location.href='createEstacao.php'">Cadastro de Estações</Button>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-7 col-xl-6 d-flex justify-content-between">
                <Button class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="location.href='createOrdemM.php'">Cadastro de Ordem de Manutenção</Button>
                <Button class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="location.href='createSegmentoRota.php'">Cadastro de Segmento de Rota</Button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>