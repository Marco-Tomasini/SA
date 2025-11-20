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
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        <title>Visualizar e Atualizar Dados do Usuário</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
        <main>
            <div class="container-fluid">
                <div class="row navRelat d-flex align-items-center">
                    <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                        <button type="button" href="../public/dashboard.php" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                        <p class="mb-0 fs-4 fw-semibold">Dados do Usuário</p>
                    </div>

                    <div class="col-4">
                        <?php include 'sidebar.php'; ?>
                    </div>
                </div>
                <div class="row">
                        <form action="upload_foto.php?id=<?php echo urlencode($_GET['id']); ?>" method="POST" enctype="multipart/form-data" class="p-5">
                            <?php
                            $fotoNome = !empty($dadosusuario['imagem_usuario']) ? htmlspecialchars($dadosusuario['imagem_usuario'], ENT_QUOTES) : 'default.png';
                            $fotoPath = '../assets/img/' . $fotoNome;
                            ?>
                            <img src="<?php echo $fotoPath; ?>" alt="foto_perfil" class="mb-3" style="width: 150px; height: 150px; border-radius: 50%;">
                            <div class="mb-3 d-flex flex-column">

                                <label for="nome" class="form-label fs-5">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($dadosusuario['nome'], ENT_QUOTES); ?>" >

                                <label for="email" class="form-label fs-5">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($dadosusuario['email'], ENT_QUOTES); ?>" >

                                <label for="cpf" class="form-label fs-5">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="CPF" value="<?php echo htmlspecialchars($dadosusuario['CPF'], ENT_QUOTES); ?>" >

                                <label for="contato" class="form-label fs-5">Contato:</label>
                                <input type="text" class="form-control" id="contato" name="contato" value="<?php echo htmlspecialchars($dadosusuario['contato'], ENT_QUOTES); ?>" >

                                <label for="data_nascimento" class="form-label fs-5">Data de Nascimento:</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($dadosusuario['data_nascimento'], ENT_QUOTES); ?>">

                                <label for="endereco" class="form-label fs-5">Endereço:</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo htmlspecialchars($dadosusuario['endereco'], ENT_QUOTES); ?>" >

                                <label for="perfil" class="form-label fs-5">Perfil:</label>
                                <select class="form-control" id="perfil" name="perfil">
                                    <option value="Gerente" <?php if ($dadosusuario['perfil'] === 'Gerente') echo 'selected'; ?>>Gerente</option>
                                    <option value="controlador" <?php if ($dadosusuario['perfil'] === 'Controlador') echo 'selected'; ?>>Controlador</option>
                                    <option value="engenheiro" <?php if ($dadosusuario['perfil'] === 'Engenheiro') echo 'selected'; ?>>Engenheiro</option>
                                    <option value="planejador" <?php if ($dadosusuario['perfil'] === 'Planejador') echo 'selected'; ?>>Planejador</option>
                                    <option value="maquinista" <?php if ($dadosusuario['perfil'] === 'Maquinista') echo 'selected'; ?>>Maquinista</option>
                                </select>

                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                            </div>
                        </form>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>





<?php
}else{
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

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" href="../public/dashboard.php" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <p class="mb-0 fs-4 fw-semibold">Dados do Usuário</p>
                </div>

                <div class="col-4">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex flex-column">
                    <form action="upload_foto.php" method="POST" enctype="multipart/form-data" class="p-5">
                        <?php
                        $fotoNome = !empty($dadosusuario['imagem_usuario']) ? htmlspecialchars($dadosusuario['imagem_usuario'], ENT_QUOTES) : 'default.png';
                        $fotoPath = '../assets/img/' . $fotoNome;
                        ?>
                        <img src="<?php echo $fotoPath; ?>" alt="foto_perfil" class="mb-3" style="width: 150px; height: 150px; border-radius: 50%;">
                        <div class="mb-3 d-flex flex-column">

                            <label for="nome" class="form-label fs-5">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($dadosusuario['nome'], ENT_QUOTES); ?>" disabled>

                            <label for="email" class="form-label fs-5">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($dadosusuario['email'], ENT_QUOTES); ?>" disabled>

                            <label for="cpf" class="form-label fs-5">CPF:</label>
                            <input type="text" class="form-control" id="cpf" name="CPF" value="<?php echo htmlspecialchars($dadosusuario['CPF'], ENT_QUOTES); ?>" disabled>

                            <label for="contato" class="form-label fs-5">Contato:</label>
                            <input type="text" class="form-control" id="contato" name="contato" value="<?php echo htmlspecialchars($dadosusuario['contato'], ENT_QUOTES); ?>" disabled>

                            <label for="data_nascimento" class="form-label fs-5">Data de Nascimento:</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($dadosusuario['data_nascimento'], ENT_QUOTES); ?>" disabled>

                            <label for="endereco" class="form-label fs-5">Endereço:</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo htmlspecialchars($dadosusuario['endereco'], ENT_QUOTES); ?>" disabled>

                            <label for="perfil" class="form-label fs-5">Perfil:</label>
                            <input type="text" class="form-control" id="perfil" name="perfil" value="<?php echo htmlspecialchars($dadosusuario['perfil'], ENT_QUOTES); ?>" disabled>

                            <label for="formFile" class="form-label fs-5">Envie sua foto de perfil abaixo:</label>
                            <div class="col d-lg-flex gap-2">
                                <input class="form-control" type="file" name="foto_perfil" id="formFile" accept="image/*" required>
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

<?php
}
?>