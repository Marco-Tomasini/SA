<?php

include "public/db.php";
include "src/User.php";
include "src/Auth.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user = new User($conn);
    $auth = new Auth();

    $loggedInUser = $user->login($_POST['email'], $_POST['password']);
    if ($loggedInUser) {
        $auth->loginUser($loggedInUser);
        header("Location: public/dashboard.php");
    } else {
        echo "Login Falhou";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="bodyLogin">
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center h-100">

        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container-fluid d-flex justify-content-center">
                <a class="navbar-brand fs-4" href="#"></a>
                <img src="assets/icon/logoSite.svg" width="auto" height="150" class="d-inline-block align-top" alt="">
            </div>
        </nav>


        <div class="row d-flex justify-content-center align-items-center">
            <div class="col main p-3 p-md-5 align-items-center rounded-4">
                <form method="POST">
                    <p class=" text-center tituloLight fs-1 fw-medium mb-5">Login</p>
                    <div class="mb-3">
                        <label for="email" class="form-label tituloLight fs-5 fw-light">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label tituloLight fs-5 fw-light">Senha</label>
                        <input type="password" class="form-control" name="password" id="senha">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn esqueci">Esqueci minha senha</button>
                            <button type="submit" class="btn esqueci" onclick="location.href='public/primeiroAcesso.php'">Primeiro Acesso</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light btnLogin fs-5 fw-semibold rounded-4">Entrar</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>