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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" href="../public/dashboard.php" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt=""></button>
                    <p class="mb-0 fs-4 fw-semibold">Upload de Fotos</p>
                </div>

                <div class="col-4">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex flex-column">
                    <form action="upload_foto.php" method="POST" enctype="multipart/form-data" class="p-5">
                        <div class="mb-3 d-flex flex-column">
                            <label for="formFile" class="form-label fs-5">Envie sua foto de perfil abaixo:</label>

                            <div class="col d-lg-flex gap-2">
                                <input class="form-control" type="file" name="foto_perfil" id="formFile" required>

                                <button type="submit" class="btn botaoCreate mt-2 mt-lg-0">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>