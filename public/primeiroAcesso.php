<?php
include 'db.php';
include "../src/User.php";
session_start();

$sql = "SELECT COUNT(*) as user_count FROM usuario";
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);


if ($row['user_count'] > 0) {
    header('Location: ../index.php');
    exit();
} else {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['perfil'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['contato'])) {
        $user = new User($conn);

        $user->register($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['perfil'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['contato']);
        echo "<script>alert('Usuário Criado com sucesso.');</script>";
        echo "<script>window.location.href = 'dashboard.php';</script>";
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
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5">
                            <p class="mb-0">Cadastro de Usuário</p>
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='../index.php'"></i>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>
                <form method="POST" class="p-5">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome: </label>
                        <input required type="text" name="nome" class="form-control" id="nome" placeholder="Insira...">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input required type="email" class="form-control" id="email" name="email" placeholder="Insira...">
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha: </label>
                        <input required type="password" class="form-control" id="senha" name="senha" placeholder="Insira...">
                    </div>
                    <div class="mb-3">
                        <label for="perfil" class="form-label">Perfil: </label>
                        <select class="form-select" name="perfil" id="perfil" required>
                            <option value="Controlador">Controlador</option>
                            <option value="Engenheiro">Engenheiro</option>
                            <option value="Planejador">Planejador</option>
                            <option value="Maquinista">Maquinista</option>
                            <option value="Gerente">Gerente</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF: </label>
                        <input required type="text" class="form-control" id="cpf" name="cpf" placeholder="Insira..." onblur="">
                        <div id="cpfResult" class="text-danger mt-1"></div>
                    </div>

                    <div class="mb-3">
                        <label for="nascimento" class="form-label">Data Nascimento: </label>
                        <input required type="date" class="form-control" id="nascimento" name="nascimento" placeholder="Insira...">
                    </div>

                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço: </label>
                        <input required type="text" class="form-control" id="endereco" name="endereco" placeholder="Insira...">
                    </div>

                    <div class="mb-3">
                        <label for="contato" class="form-label">Contato: </label>
                        <input required type="text" class="form-control" id="contato" name="contato" placeholder="Insira...">
                    </div>

                    <button type="submit" name="register" value="1" class="btn botaoCreate">Cadastrar</button>
                </form>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>

<?php
    $conn = null;
}
?>