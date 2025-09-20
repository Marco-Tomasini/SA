<?php

include 'db.php';

session_start();


if (empty($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
};

$register_msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $nome = $_POST['nome'] ?? "";
    $email = $_POST['email'] ?? "";
    $pass = $_POST['senha'] ?? "";
    $perfil = $_POST['perfil'] ?? "";
    $cpf = $_POST['cpf'] ?? "";
    $sangue = $_POST['sangue'] ?? "";
    $nascimento = $_POST['nascimento'] ?? "";
    $endereco = $_POST['endereco'] ?? "";
    $contato = $_POST['contato'] ?? "";
    if ($nome && $pass) {
        $stmt = $mysqli->prepare("INSERT INTO usuario (nome, email, senha, perfil, CPF, tipo_sanguineo, data_nascimento, endereco, contato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $nome, $email, $pass, $perfil, $cpf, $sangue, $nascimento, $endereco, $contato);

        if ($stmt->execute()) {
            $register_msg = "Usuário cadastrado com sucesso!";
        } else {
            $register_msg = "Erro ao cadastrar novo usuário.";
        };
        $stmt->close();
    } else {
        $register = "Preencha todos os campos.";
    };
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <main>
        <div class="container-fluid">
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
                        <option value="controlador">Controlador</option>
                        <option value="engenheiro">Engenheiro</option>
                        <option value="planejador">Planejador</option>
                        <option value="maquinista">Maquinista</option>
                        <option value="gerente">Gerente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF: </label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Insira...">
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