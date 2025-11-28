<?php
include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['perfil'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['contato'])) {
    $user = new User($conn);

    $user->register($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['perfil'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['contato']);
    echo "<script>alert('Usuário Criado com sucesso.');</script>";
    echo "<script>window.location.href = 'funcionarios.php';</script>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icon/logoSite.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <main>
        <div class="container-fluid p-0">
            <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                <div class="col-8  welcome lh-1">
                    <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                        <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='funcionarios.php'"></i>
                        <p class="mb-0">Cadastro de Usuário</p>
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

            <div class="row justify-content-center p-3">
                <div class="col">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col main p-3 p-md-5 align-items-center rounded-4">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="nome" class="form-label tituloLight fs-5">Nome:</label>
                                    <input required type="text" name="nome" class="form-control" id="nome" placeholder="Insira...">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label tituloLight fs-5">Email:</label>
                                    <input required type="email" class="form-control" id="email" name="email" placeholder="Insira...">
                                </div>
                                <div class="mb-3">
                                    <label for="senha" class="form-label tituloLight fs-5">Senha:</label>
                                    <input required type="password" class="form-control" id="senha" name="senha" placeholder="Insira...">
                                </div>
                                <div class="mb-3">
                                    <label for="perfil" class="form-label tituloLight fs-5">Perfil:</label>
                                    <select class="form-select" name="perfil" id="perfil" required>
                                        <option value="Controlador">Controlador</option>
                                        <option value="Engenheiro">Engenheiro</option>
                                        <option value="Planejador">Planejador</option>
                                        <option value="Maquinista">Maquinista</option>
                                        <option value="Gerente">Gerente</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="cpf" class="form-label tituloLight fs-5">CPF:</label>
                                    <input required type="text" class="form-control" id="cpf" name="cpf" placeholder="Insira..." onblur="">
                                    <div id="cpfResult" class="text-danger mt-1"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="nascimento" class="form-label tituloLight fs-5">Data Nascimento:</label>
                                    <input required type="date" class="form-control" id="nascimento" name="nascimento" placeholder="Insira...">
                                </div>
                                <div class="mb-3">
                                    <label for="endereco" class="form-label tituloLight fs-5">Endereço:</label>
                                    <input required type="text" class="form-control" id="endereco" name="endereco" placeholder="Insira...">
                                </div>
                                <div class="mb-5">
                                    <label for="contato" class="form-label tituloLight fs-5">Contato:</label>
                                    <input required type="text" class="form-control" id="contato" name="contato" placeholder="Insira...">
                                </div>

                                <button type="submit" name="register" value="1" class="btn btn-dark btnLogin fs-5 fw-semibold rounded-4">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>

<?php
$conn = null;
?>