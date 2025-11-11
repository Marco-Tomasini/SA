<?php

include 'db.php';
include "../src/User.php";

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}


    if($_SERVER['REQUEST_METHOD']){
        $user = new User($conn);

        $user -> register($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['perfil'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['contato']);
        header("Location: dashboard.php");
        exit();
    }



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center sticky-top">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <div class="d-flex flex-column">
                        <p>Cadastro de Trens</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
            <form method="POST" class="p-5">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome: </label>
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Insira...">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Insira...">
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha: </label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Insira...">
                </div>
                <div class="mb-3">
                    <label for="perfil" class="form-label">Perfil: </label>
                    <select class="form-select" name="perfil" id="perfil">
                        <option value="Controlador">Controlador</option>
                        <option value="Engenheiro">Engenheiro</option>
                        <option value="Planejador">Planejador</option>
                        <option value="Maquinista">Maquinista</option>
                        <option value="Gerente">Gerente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF: </label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Insira..." onblur="">
                    <div id="cpfResult" class="text-danger mt-1"></div>
                </div>

                <div class="mb-3">
                    <label for="nascimento" class="form-label">Data Nascimento: </label>
                    <input type="date" class="form-control" id="nascimento" name="nascimento" placeholder="Insira...">
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço: </label>
                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Insira...">  
                </div>

                <div class="mb-3">
                    <label for="contato" class="form-label">Contato: </label>
                    <input type="text" class="form-control" id="contato" name="contato" placeholder="Insira...">
                </div>

                <button type="submit" name="register" value="1" class="btn botaoCreate">Cadastrar</button>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>