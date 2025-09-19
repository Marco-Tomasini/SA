<?php

include 'db.php';

session_start();


if(empty($_SESSION["user_id"])){
    header("Location: ../index.php");
    exit;
};

$register_msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])){
    $nome = $_POST['nome'] ?? "";
    $email = $_POST['email'] ?? "";
    $pass = $_POST['senha'] ?? "";
    $perfil = $_POST['perfil'] ?? "";
    $cpf = $_POST['cpf'] ?? "";
    $sangue = $_POST['sangue'] ?? "";
    $nascimento = $_POST['nascimento'] ?? "";
    $endereco = $_POST['endereco'] ?? "";
    $contato = $_POST['contato'] ?? "";
    if($nome && $pass){
        $stmt = $mysqli -> prepare("INSERT INTO usuario (nome, email, senha, perfil, CPF, tipo_sanguineo, data_nascimento, endereco, contato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("sssssssss", $nome, $email, $pass, $perfil, $cpf, $sangue, $nascimento, $endereco, $contato);

        if($stmt->execute()){
            $register_msg = "Usuário cadastrado com sucesso!";
        }else{
            $register_msg = "Erro ao cadastrar novo usuário.";
        };
        $stmt->close();
    }else{
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
</head>
<body>
    
    <form method="POST">
        <label for="nome">Nome: </label>
        <input type="text" name="nome" placeholder="Insira...">

        <label for="email">Email: </label>
        <input type="text" name="email" placeholder="Insira...">

        <label for="senha">Senha: </label>
        <input type="password" name="senha" placeholder="Insira...">

        <label for="perfil">Perfil: </label>
        <select name="perfil" id="perfil">
            <option value="controlador">Controlador</option>
            <option value="engenheiro">Engenheiro</option>
            <option value="planejador">Planejador</option>
            <option value="maquinista">Maquinista</option>
            <option value="gerente">Gerente</option>
        </select>

        <label for="cpf">CPF: </label>
        <input type="text" name="cpf" placeholder="Insira...">

        <label for="sangue">Tipo Sanguineo: </label>
        <select name="sangue" id="sangue">
            <option value="#" selected disabled>Escolha</option>
            <option value="a+">A+</option>
            <option value="a-">A-</option>
            <option value="b+">B+</option>
            <option value="b-">B-</option>
            <option value="ab+">AB+</option>
            <option value="ab-">AB-</option>
            <option value="o+">O+</option>
            <option value="o-">O-</option>
            <option value="vermelinho">Vermelinho</option>
        </select>

        <label for="nascimento">Data Nascimento: </label>
        <input type="date" name="nascimento" placeholder="Insira...">

        <label for="endereco">Endereço: </label>
        <input type="text" name="endereco" placeholder="Insira...">

        <label for="contato">Contato: </label>
        <input type="text" name="contato" placeholder="Insira...">

        <button type="submit" name="register" value="1">Cadastrar</button>
    </form>

</body>
</html>