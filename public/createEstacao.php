<?php
include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: public/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_estacao = $_GET['id'];

    $sql2 = "SELECT * FROM estacao WHERE id_estacao='$id_estacao'";
    $result = $conn->query($sql2);
    $estacao_row = $result->fetch(PDO::FETCH_ASSOC);

    $nome = $estacao_row['nome'];
    $localizacao = $estacao_row['localizacao'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $localizacao = $_POST['localizacao'];

        $sql2 = "UPDATE estacao SET nome='$nome', localizacao='$localizacao' WHERE id_estacao='$id_estacao'";

        if($conn->query($sql2) === true) {
            echo "<script>alert('Estação Atualizada com sucesso.');</script>";
            header('Location: ../index.php');
            exit();
        } else {
            $errorInfo = $conn->errorInfo();
            echo "Erro " . $sql2 . '<br>' . $errorInfo[2];
        }
        $conn = null;
    
}
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualização de Estações</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


</head>
<body>

    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center sticky-top">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <div class="d-flex flex-column">
                        <p>Atualização de Estações</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div >
                <div>
                    <form method="POST">
                        <div>
                            <label for="nome" class="form-label">Nome da Estação:</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome da estação" value="<?php echo isset($nome) ? $nome : ''; ?>">
                        </div>
                        <div>
                            <label for="localizacao" class="form-label">Localização:</label>
                            <textarea class="form-control" id="localizacao" name="localizacao" rows="4" placeholder="Insira a localização da estação"><?php echo isset($localizacao) ? $localizacao : ''; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Estação</button>
                    </form>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


<?php
}else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $sql = "INSERT INTO estacao (nome,localizacao) VALUES (:nome,:localizacao)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $_POST['nome']);
        $stmt->bindParam(':localizacao', $_POST['localizacao']);
        $stmt->execute();

    }

?>


<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Estações</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


</head>
<body>

    <main>
        <div class="container-fluid">
            <div class="row navRelat d-flex align-items-center sticky-top">
                <div class="col-8 d-flex align-items-center mt-4 ms-2 welcome lh-1">
                    <button type="button" class="btn me-4"><img src="../assets/icon/seta-curva-esquerda 1.png" alt="" onclick="location.href='dashboard.php'"></button>
                    <div class="d-flex flex-column">
                        <p>Cadastro de Estações</p>
                    </div>
                </div>

                <div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div >
                <div>
                    <form method="POST">
                        <div>
                            <label for="nome" class="form-label">Nome da Estação:</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome da estação">
                        </div>
                        <div>
                            <label for="localizacao" class="form-label">Localização:</label>
                            <textarea class="form-control" id="localizacao" name="localizacao" rows="4" placeholder="Insira a localização da estação"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar Estação</button>
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