<?php
include 'db.php';
include '../src/User.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}


if (isset($_GET['id'])) {
    $sql = "SELECT * FROM usuario WHERE id_usuario = :id_usuario";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();

    $dadosusuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$dadosusuario) {
        echo "Usuário não encontrado.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $CPF = $_POST['CPF'];
        $contato = $_POST['contato'];
        $data_nascimento = $_POST['data_nascimento'];
        $endereco = $_POST['endereco'];
        $perfil = $_POST['perfil'];

        $sql2 = "UPDATE usuario SET nome=:nome, email=:email, CPF=:CPF, contato=:contato, data_nascimento=:data_nascimento, endereco=:endereco, perfil=:perfil WHERE id_usuario=:id_usuario";
        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':CPF', $CPF);
        $stmt->bindParam(':contato', $contato);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':id_usuario', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt !== false) {
            echo "<script>alert('Dados do usuário atualizados com sucesso.');</script>";
            echo "<script>window.location.href = 'funcionarios.php';</script>";
        } else {
            $error = $conn->errorInfo();
            echo "Erro na consulta: " . $error[2];
        }
    }

?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Atualização de Usuário</title>
        <link rel="icon" type="image/svg+xml" href="../assets/icon/logoSite.svg">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        
        <link rel="stylesheet" href="../styles/style.css">
    </head>

    <body>
        <main>
            <div class="container-fluid p-0">
                <div class="row headerDash d-flex justidy-content-between align-items-center sticky-top">
                    <div class="col-8 welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='funcionarios.php'"></i>
                            <p class="mb-0">Dados do Usuário</p>
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
                                <form action="upload_foto.php?id=<?php echo $dadosusuario['id_usuario']; ?>" method="POST" enctype="multipart/form-data">
                                    <?php
                                    $fotoNome = !empty($dadosusuario['imagem_usuario']) ? htmlspecialchars($dadosusuario['imagem_usuario'], ENT_QUOTES) : 'default.png';
                                    $fotoPath = '../assets/img/' . $fotoNome;
                                    ?>
                                    <div class="col mb-3 d-flex justify-content-start align-items-center gap-4">
                                        <img src="<?php echo $fotoPath; ?>" alt="foto_perfil" class="rounded-circle" width="100vw" height="100vw">
                                        <button  class="btn btn-dark btnDemitir fs-5 fw-semibold rounded-4" onclick="location.href='delete_usuario.php?id=<?php echo $dadosusuario['id_usuario']; ?>'">Excluir</button>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nome" class="form-label tituloLight fs-5">Nome:</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($dadosusuario['nome'], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label tituloLight fs-5">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($dadosusuario['email'], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="cpf" class="form-label tituloLight fs-5">CPF:</label>
                                        <input type="text" class="form-control" id="cpf" name="CPF" value="<?php echo htmlspecialchars($dadosusuario['CPF'], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="contato" class="form-label tituloLight fs-5">Contato:</label>
                                        <input type="text" class="form-control" id="contato" name="contato" value="<?php echo htmlspecialchars($dadosusuario['contato'], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="data_nascimento" class="form-label tituloLight fs-5">Data de Nascimento:</label>
                                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($dadosusuario['data_nascimento'], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="endereco" class="form-label tituloLight fs-5">Endereço:</label>
                                        <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo htmlspecialchars($dadosusuario['endereco'], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="perfil" class="form-label tituloLight fs-5">Perfil:</label>
                                        <select class="form-control" id="perfil" name="perfil">
                                            <option value="Gerente" <?php echo ($dadosusuario['perfil'] === 'Gerente') ? 'selected' : ''; ?>>Gerente</option>
                                            <option value="Controlador" <?php echo ($dadosusuario['perfil'] === 'Controlador') ? 'selected' : ''; ?>>Controlador</option>
                                            <option value="Engenheiro" <?php echo ($dadosusuario['perfil'] === 'Engenheiro') ? 'selected' : ''; ?>>Engenheiro</option>
                                            <option value="Planejador" <?php echo ($dadosusuario['perfil'] === 'Planejador') ? 'selected' : ''; ?>>Planejador</option>
                                            <option value="Maquinista" <?php echo ($dadosusuario['perfil'] === 'Maquinista') ? 'selected' : ''; ?>>Maquinista</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-dark btnLogin fs-5 fw-semibold rounded-4">Salvar</button>
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
} else {
    $user = new User($conn);
    $currentUser = $user->getUserById($_SESSION['id_usuario']);

    $sql = "SELECT * FROM usuario WHERE id_usuario = :id_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
    $stmt->execute();

    $dadosusuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dadosusuario) {
        echo "Usuário não encontrado.";
        exit();
    }

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
        <link rel="icon" type="image/svg+xml" href="../assets/icon/logoSite.svg">
        <link rel="stylesheet" href="../styles/style.css">
    </head>

    <body>
        <main>
            <div class="container-fluid p-0">
                <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                    <div class="col-8 welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'"></i>
                            <p class="mb-0">Dados do Usuário</p>
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
                                <form action="upload_foto.php" method="POST" enctype="multipart/form-data">
                                    <?php
                                    $fotoNome = !empty($dadosusuario['imagem_usuario']) ? htmlspecialchars($dadosusuario['imagem_usuario'], ENT_QUOTES) : 'default.png';
                                    $fotoPath = '../assets/img/' . $fotoNome;
                                    ?>
                                    <div class="mb-3 d-flex justify-content-center align-items-center">
                                        <img src="<?php echo $fotoPath; ?>" alt="foto_perfil" class="rounded-circle" width="100vw" height="100vw">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nome" class="form-label tituloLight fs-5">Nome:</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($dadosusuario['nome'], ENT_QUOTES); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label tituloLight fs-5">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($dadosusuario['email'], ENT_QUOTES); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cpf" class="form-label tituloLight fs-5">CPF:</label>
                                        <input type="text" class="form-control" id="cpf" name="CPF" value="<?php echo htmlspecialchars($dadosusuario['CPF'], ENT_QUOTES); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contato" class="form-label tituloLight fs-5">Contato:</label>
                                        <input type="text" class="form-control" id="contato" name="contato" value="<?php echo htmlspecialchars($dadosusuario['contato'], ENT_QUOTES); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="data_nascimento" class="form-label tituloLight fs-5">Data de Nascimento:</label>
                                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($dadosusuario['data_nascimento'], ENT_QUOTES); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="endereco" class="form-label tituloLight fs-5">Endereço:</label>
                                        <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo htmlspecialchars($dadosusuario['endereco'], ENT_QUOTES); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="perfil" class="form-label tituloLight fs-5">Perfil:</label>
                                        <input type="text" class="form-control" id="perfil" name="perfil" value="<?php echo htmlspecialchars($dadosusuario['perfil'], ENT_QUOTES); ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label tituloLight fs-5">Envie sua foto de perfil abaixo:</label>
                                        <div class="col d-flex gap-2">
                                            <input class="form-control" type="file" name="foto_perfil" id="formFile" accept="image/*" required>
                                            <button type="submit" class="btn btn-dark btnUploadFoto fs-6 fw-semibold rounded-4">Upload</button>
                                        </div>
                                    </div>
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
}
?>