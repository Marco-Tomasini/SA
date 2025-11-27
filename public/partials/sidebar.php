<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../../styles/style.css">
</head>

<body class="bodyDashboard">
    <div class="container-fluid p-0">
        <div class="row d-flex justify-content-end m-0">
            <div class="col-1 d-flex align-items-between justify-content-end p-0 me-md-4 me-1 me-md-3">
                <i class="btn bi bi-list mb-0 fs-3" type="button" data-bs-theme="dark" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"></i>

                <div class="col d-flex flex-column offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="col d-flex align-items-center justify-content-between ms-5 mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="col d-flex flex-column gap-3 ms-5 me-5">
                        <button type="button" class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="window.location.href='dashboard.php'">Dashboard</button>
                        <button type="button" class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="window.location.href='gestaoDeRotas.php'">Gestão de Rotas</button>
                        <button type="button" class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="window.location.href='manutencao.php'">Monit. de Manutenção</button>
                        <button type="button" class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="window.location.href='relatorios.php'">Relatórios e Análises</button>
                        <button type="button" class="btn btn-dark btnSidebar custom-height-btn fw-semibold" onclick="window.location.href='alertas.php'">Alertas e Notficações</button>

                        <?php if (isset($_SESSION['perfil']) && strcasecmp(trim($_SESSION['perfil']), 'Gerente') === 0): ?>
                            <button type="button" class="btn btnAdminSidebar btn-dark custom-height-btn fw-semibold" onclick="window.location.href='funcionarios.php'">Funcionários</button>
                            <button type="button" class="btn btnAdminSidebar btn-dark custom-height-btn mb-5 fw-semibold" onclick="window.location.href='listaCadastros.php'">Lista de Cadastros</button>
                        <?php endif; ?>
                    </div>

                    <div class="col d-flex flex-column p-5 mt-3">
                        <button type="button" class="btn btn-danger custom-height-btn fw-semibold" onclick="window.location.href='../src/logout.php?logout'">Sair</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>