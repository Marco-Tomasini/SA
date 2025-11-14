<?php

include 'db.php';
include "../src/User.php";

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    $sql2 = "SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
    $result = $conn->query($sql2);
    $usuario_row = $result->fetch(PDO::FETCH_ASSOC);

    $nome = $usuario_row['nome'];
    $email = $usuario_row['email'];
    $perfil = $usuario_row['perfil'];
    $CPF = $usuario_row['CPF'];
    $data_nascimento = $usuario_row['data_nascimento'];
    $endereco = $usuario_row['endereco'];
    $contato = $usuario_row['contato'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $perfil = $_POST['perfil'];
        $CPF = $_POST['CPF'];
        $data_nascimento = $_POST['data_nascimento'];
        $endereco = $_POST['endereco'];
        $contato = $_POST['contato'];

        $sql2 = "UPDATE usuario SET nome='$nome', email='$email', perfil='$perfil', CPF='$CPF', data_nascimento='$data_nascimento', endereco='$endereco', contato='$contato' WHERE id_usuario='$id_usuario'";

        $stmt = $conn->prepare($sql2);
        $stmt->execute();

        if ($stmt !== false) {
            echo "<script>alert('Usuário Atualizado com sucesso.');</script>";
            echo "<script>window.location.href = 'dashboard.php';</script>";
        } else {
            $error = $conn->errorInfo();
            echo "Erro na consulta: " . $error[2];
        }
        $conn = null;
    }
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center sticky-top">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <div class="d-flex flex-column">
                        <p>Edição de Usuário</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
            <form method="POST" class="p-5">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome: </label>
                    <input required type="text" name="nome" class="form-control" id="nome" value="<?php echo htmlspecialchars($nome); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input required type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="mb-3">
                    <label for="perfil" class="form-label">Perfil: </label>
                    <select class="form-select" name="perfil" id="perfil" required>
                        <option value="Controlador" <?php echo ($perfil === 'Controlador') ? 'selected' : ''; ?>>Controlador</option>
                        <option value="Engenheiro" <?php echo ($perfil === 'Engenheiro') ? 'selected' : ''; ?>>Engenheiro</option>
                        <option value="Planejador" <?php echo ($perfil === 'Planejador') ? 'selected' : ''; ?>>Planejador</option>
                        <option value="Maquinista" <?php echo ($perfil === 'Maquinista') ? 'selected' : ''; ?>>Maquinista</option>
                        <option value="Gerente" <?php echo ($perfil === 'Gerente') ? 'selected' : ''; ?>>Gerente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="CPF" class="form-label">CPF: </label>
                    <input required type="text" class="form-control" id="CPF" name="CPF" placeholder="Insira..." onblur="" value="<?php echo htmlspecialchars($CPF); ?>">
                </div>

                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">Data Nascimento: </label>
                    <input required type="date" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="Insira..." value="<?php echo htmlspecialchars($data_nascimento); ?>">
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço: </label>
                    <input required type="text" class="form-control" id="endereco" name="endereco" placeholder="Insira..." value="<?php echo htmlspecialchars($endereco); ?>">
                </div>

                <div class="mb-3">
                    <label for="contato" class="form-label">Contato: </label>
                    <input required type="text" class="form-control" id="contato" name="contato" placeholder="Insira..." value="<?php echo htmlspecialchars($contato); ?>">
                </div>

                <button type="submit" name="register" value="1" class="btn botaoCreate">Atualizar</button>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>



<?php
} else {
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['perfil'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['contato'])){
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
            <div class="row navRelat d-flex align-items-center sticky-top">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <div class="d-flex flex-column">
                        <p>Cadastro de Usuário</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
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