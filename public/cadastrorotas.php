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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];

        $sql2 = "UPDATE rota SET nome='$nome', descricao='$descricao' WHERE id_rota='$id_rota'";

        if ($stmt !== false) {
            echo "<script>alert('Estação Atualizada com sucesso.');</script>";
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
        <title>Atualização de Rotas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../styles/style.css">

    </head>

    <body>

        <main>
            <div class="container-fluid p-0">
                <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='gestaoDeRotas.php'"></i>
                            <p class="mb-0">Atualização de Rotas</p>
                        </div>
                    </div>

                    <div class="col-3 d-flex justify-content-end align-items-center">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <i class="bi bi-bell fs-4 me-3 text-light" onclick="window.location.href='alertas.php'" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center p-3">
                    <div class="col">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col main p-3 p-md-5 align-items-center rounded-4">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="nome" class="form-label tituloLight fs-5">Nome da Rota:</label>
                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome da rota" value="<?php echo isset($nome) ? $nome : ''; ?>" required>
                                    </div>
                                    <div class="mb-5">
                                        <label for="descricao" class="form-label tituloLight fs-5">Descrição:</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Insira a descrição da rota" required><?php echo isset($descricao) ? $descricao : ''; ?>
                                    </div>
                                    <button type="submit" class="btn btn-dark btnLogin fs-5 fw-semibold rounded-4">Atualizar Rota</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>



<?php
} else {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $sql = "INSERT INTO rota (nome,descricao) VALUES (:nome,:descricao)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $_POST['nome']);
        $stmt->bindParam(':descricao', $_POST['descricao']);
        $stmt->execute();

        if ($stmt !== false) {
            echo "<script>alert('Rota Cadastrada com sucesso.');</script>";
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
        <title>Cadastro de Rotas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../styles/style.css">


    </head>

    <body>

        <main>
            <div class="container-fluid p-0">
                <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='listaCadastros.php'"></i>
                            <p class="mb-0">Cadastro de Rotas</p>
                        </div>
                    </div>

                    <div class="col-3 d-flex justify-content-end align-items-center">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <i class="bi bi-bell fs-4 me-3 text-light" onclick="window.location.href='alertas.php'" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center p-3">
                    <div class="col">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col main p-3 p-md-5 align-items-center rounded-4">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="nome" class="form-label tituloLight fs-5">Nome da Rota:</label>
                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome da rota" aria-describedby="Nome da Rota" required>
                                    </div>
                                    <div class="mb-5">
                                        <label for="descricao" class="form-label tituloLight fs-5">Descrição:</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Insira a descrição da rota" required>
                                    </div>
                                    <button type="submit" class="btn btn-dark btnLogin fs-5 fw-semibold rounded-4">Cadastrar Rota</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>

<?php
    $conn = null;
}
?>