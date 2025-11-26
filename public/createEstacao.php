<?php
include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_estacao = $_GET['id'];

    $sql2 = "SELECT * FROM estacao WHERE id_estacao='$id_estacao'";
    $result = $conn->query($sql2);
    $estacao_row = $result->fetch(PDO::FETCH_ASSOC);

    $nome = $estacao_row['nome'];
    $localizacao = $estacao_row['localizacao'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $localizacao = $_POST['localizacao'];

        $sql2 = "UPDATE estacao SET nome='$nome', localizacao='$localizacao' WHERE id_estacao='$id_estacao'";

        if ($stmt !== false) {
            echo "<script>alert('Estação Atualizada com sucesso.');</script>";
            echo "<script>window.location.href = 'dashboard.php';</script>";
        } else {
            $error = $conn->errorInfo();
            echo "Erro na consulta: " . $error[2];
        }
    }
?>

    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Atualização de Estações</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../styles/style.css">

    </head>

    <body>

        <main>
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5">
                            <p class="mb-0">Atualização de Estação</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center p-5">
                    <div class="col">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome da Estação:</label>
                                <input required type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome da estação" value="<?php echo isset($nome) ? $nome : ''; ?>">
                            </div>
                            <div>
                                <label for="localizacao" class="form-label">Localização:</label>
                                <textarea required class="form-control" id="localizacao" name="localizacao" rows="4" placeholder="Insira a localização da estação"><?php echo isset($localizacao) ? $localizacao : ''; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-light btnLogin mt-5">Atualizar Estação</button>
                        </form>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>


<?php
} else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $sql = "INSERT INTO estacao (nome,localizacao) VALUES (:nome,:localizacao)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $_POST['nome']);
        $stmt->bindParam(':localizacao', $_POST['localizacao']);
        $stmt->execute();

        if ($stmt !== false) {
            echo "<script>alert('Estação Criada com sucesso.');</script>";
            echo "<script>window.location.href = 'dashboard.php';</script>";
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
        <title>Cadastro de Estações</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../styles/style.css">

    </head>

    <body>

        <main>
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='listaCadastros.php'"></i>
                            <p class="mb-0">Cadastro de Estação</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center p-5">
                    <div class="col">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome da Estação:</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome da estação" required>
                            </div>
                            <div>
                                <label for="localizacao" class="form-label">Localização:</label>
                                <textarea required class="form-control" id="localizacao" name="localizacao" rows="4" placeholder="Insira a localização da estação"></textarea>
                            </div>
                            <button type="submit" class="btn btn-light btnLogin mt-5">Cadastrar Estação</button>
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