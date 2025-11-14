<?php
include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_rota = $_GET['id'];

    $sql2 = "SELECT * FROM rota WHERE id_rota='$id_rota'";
    $result = $conn->query($sql2);
    $rota_row = $result->fetch(PDO::FETCH_ASSOC);

    $nome = $rota_row['nome'];
    $descricao = $rota_row['descricao'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];

        $sql2 = "UPDATE rota SET nome='$nome', descricao='$descricao' WHERE id_rota='$id_rota'";

        if ($stmt !== false) {
            echo "<script>alert('Estação Atualizada com sucesso.');</script>";
            header('Location: dashboard.php');
            exit();
        } else {
            $error = $conn->errorInfo();
            echo "Erro na consulta: " . $error[2];
        }
        $conn = null;
    }
    

?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualização de Rotas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                        <p class="mb-0">Atualização de Rotas</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div class="row justify-content-center p-5">
                <div class="col">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Rota:</label>
                            <input required type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome da rota" value="<?php echo isset($nome) ? $nome : ''; ?>">
                        </div>

                        <div>
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea required class="form-control" id="descricao" name="descricao" rows="4" placeholder="Insira a descrição da rota"><?php echo isset($descricao) ? $descricao : ''; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-light btnLogin mt-5">Atualizar Rota</button>
                    </form>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>



<?php
} else {

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $sql = "INSERT INTO rota (nome,descricao) VALUES (:nome,:descricao)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $_POST['nome']);
        $stmt->bindParam(':descricao', $_POST['descricao']);
        $stmt->execute();

    }
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Rotas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p class="mb-0">Cadastro de Rotas</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div class="row justify-content-center p-5">
                <div class="col">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Rota:</label>
                            <input type="text" class="form-control" name="nome" id="nome" placeholder="Insira o nome da rota" aria-describedby="Nome da Rota" required>
                        </div>
                        <div>
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea class="form-control" id="descricao" name="descricao" placeholder="Insira a descrição da rota" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-light btnLogin mt-5">Cadastrar Rota</button>
                    </form>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

<?php
        $conn = null;
}
?>
