<?php
include __DIR__ . '/public/db.php';

session_start();

$msg = '';
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $email = $_POST['email'] ?? "";
    $pass = $_POST['password'] ?? "";

    $stmt = $mysqli->prepare("SELECT id_usuario, nome, email, senha FROM usuario WHERE email=? AND senha=?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();
    $stmt->close();

    if ($dados) {
        $_SESSION['user_id'] = $dados['id_usuario'];
        $_SESSION['email'] = $dados['email'];
        $_SESSION['usuario'] = $dados['nome'];
        header('Location: public/dashboard.php');
        exit;
    } else {
        $msg = "Usuário ou senha incorretos!";
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <div class="container-fluid d-flex justify-content-center">
                            <a class="navbar-brand fs-4" href="#"></a>
                            <img src="assets/icon/logoSite.svg" width="auto" height="150" class="d-inline-block align-top" alt="">
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row main">
                <div class="col d-flex align-items-center justify-content-center">
                    <form class="loginForm" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control loginInput" name="email" id="email" placeholder="Email" aria-describedby="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control loginInput" name="password" id="senha" placeholder="Senha">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn">Esqueci minha senha</button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-light btnLogin mt-5">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>