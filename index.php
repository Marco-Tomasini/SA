<?php
include __DIR__ . '/public/db.php';

session_start();

$msg = '';
if($_SERVER["REQUEST_METHOD"] === 'POST'){
    $email = $_POST['email'] ?? "";
    $pass = $_POST['password'] ?? "";

    $stmt = $mysqli->prepare("SELECT id_usuario, nome, email, senha FROM usuario WHERE email=? AND senha=?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();
    $stmt->close();

    if ($dados){
        $_SESSION['user_id'] = $dados['id_usuario'];
        $_SESSION['email'] = $dados['email'];
        header('Location: dashboard.php');
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
</head>
<body>
    
    <h3>Login</h3>
    <form method="POST">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

</body>
</html>