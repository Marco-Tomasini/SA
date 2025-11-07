<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['gestao'])) {
        header('Location: gestaoDeRotas.php');
        exit;
    } elseif (isset($_POST['manutencao'])) {
        header('Location: manutencao.php');
        exit;
    } elseif (isset($_POST['relatorios'])) {
        header('Location: relatorios.php');
        exit;
    } elseif (isset($_POST['alertas'])) {
        header('Location: alertas.php');
        exit;
    } elseif (isset($_POST['funcionarios'])) {
        header('Location: funcionarios.php');
        exit;
    } elseif (isset($_POST['sair'])) {
        session_destroy();
        header('Location: ../index.php');
        exit;
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../../styles/style.css">
</head>

<body>
    <main>
        <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-list"></i></button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="col d-flex flex-column gap-5 ms-4 me-4" role="group" aria-label="Vertical button group">
                    <div class="d-flex">
                        <div class="col">
                            <button type="button" class="btn btn-dark custom-height-btn">Gestão de Rotas</button>
                            <button type="button" class="btn btn-dark custom-height-btn">Monit. de Manutenção</button>
                            <button type="button" class="btn btn-dark custom-height-btn">Relatórios e Análises</button>
                            <button type="button" class="btn btn-dark custom-height-btn">Alertas e Notficações</button>

                            <button type="button" class="btn admin-btn btn-dark custom-height-btn">Funcionários</button>
                            <button type="button" class="btn admin-btn btn-dark custom-height-btn">Lista de Cadastros</button>
                        </div>

                        <div class="col">
                            <button type="button" class="btn btn-danger custom-height-btn bottom-0">Sair</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>