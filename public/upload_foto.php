<?php
include 'db.php';
include '../src/User.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

$user = new User($conn);
$currentUser = $user->getUserById($_SESSION['id_usuario']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_perfil'])) {
    $target_dir = '../assets/img/';
    $filename = basename($_FILES['foto_perfil']['name']);
    $target_file = $target_dir . $filename;

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['foto_perfil']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo 'O arquivo não é uma imagem.';
        $uploadOk = 0;
    }

    if ($_FILES['foto_perfil']['size'] > 50000000) {
        echo ' Imagem muito pesada para o sistema.';
        $uploadOk = 0;
    }

    if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
        echo ' Desculpe, só aceitamos JPG, JPEG e PNG.';
        $uploadOk = 0;
    }

    if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $target_file)) {
            $user->updateProfilePic($_SESSION['id_usuario'], $filename);
            header('Location: dashboard.php');
            exit();
        } else {
            echo 'Desculpa, houve algum erro no envio.';
        }
    } else {
        echo 'Desculpe seu arquivo não foi enviado.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Foto de Perfil</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<main>
    <div class="container-fluid">
        <form action="upload_foto.php" method="POST" enctype="multipart/form-data" class="p-5">
            <h2>Upload de Foto:</h2>
            <input type="file" name="foto_perfil" required class="form-control mb-3">
            <button type="submit" class="btn btn-primary">Upload</button>
            <br>
            <a href="dashboard.php">Voltar ao Dashboard</a>
        </form>
    </div>
</main>
</body>
</html>