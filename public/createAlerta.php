<?php
include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_alerta = $_GET['id'];

    $sql2 = "SELECT * FROM alerta WHERE id_alerta = :id_alerta";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':id_alerta', $id_alerta, PDO::PARAM_INT);
    $stmt->execute();
    $alerta = $stmt->fetch(PDO::FETCH_ASSOC);

    $tipo = $alerta['tipo'];
    $mensagem = $alerta['mensagem'];
    $data_hora = $alerta['data_hora'];
    $criticidade = $alerta['criticidade'];
    $id_viagem_fk = $alerta['id_viagem_fk'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tipo = $_POST['tipo'];
        $mensagem = $_POST['mensagem'];
        $criticidade = $_POST['criticidade'];
        $id_viagem_fk = $_POST['id_viagem_fk'];
        $data_hora = date('Y-m-d H:i:s');

        $sql2 = "UPDATE alerta SET tipo=:tipo, mensagem=:mensagem, data_hora=CURRENT_TIMESTAMP, criticidade=:criticidade, id_viagem_fk=:id_viagem_fk WHERE id_alerta=:id_alerta";
        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':criticidade', $criticidade);
        $stmt->bindParam(':id_viagem_fk', $id_viagem_fk);
        $stmt->bindParam(':id_alerta', $id_alerta, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt !== false) {
            echo "<script>alert('Alerta Atualizada com sucesso.');</script>";
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
        <title>Atualização de Alerta</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="../styles/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    </head>

    <body>

        <main>
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5">
                            <p class="mb-0">Atualizações de Alerta</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        <form method="POST">
                            <div>
                                <label for="tipo" class="form-label">Tipo:</label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="Atraso" <?= (isset($tipo) && $tipo == 'Atraso') ? 'selected' : '' ?>>Atraso</option>
                                    <option value="Falha Técnica" <?= (isset($tipo) && $tipo == 'Falha Técnica') ? 'selected' : '' ?>>Falha Técnica</option>
                                    <option value="Segurança" <?= (isset($tipo) && $tipo == 'Segurança') ? 'selected' : '' ?>>Segurança</option>
                                </select>
                            </div>
                            <div>
                                <label for="modelo" class="form-label">Modelo:</label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="4" placeholder="Insira a mensagem do alerta" required><?= htmlspecialchars($mensagem) ?></textarea>
                            </div>

                            <div>
                                <label for="criticidade" class="form-label">Criticidade:</label>
                                <select class="form-control" id="criticidade" name="criticidade" required>
                                    <option value="Baixa" <?= (isset($criticidade) && $criticidade == 'Baixa') ? 'selected' : '' ?>>Baixa</option>
                                    <option value="Média" <?= (isset($criticidade) && $criticidade == 'Média') ? 'selected' : '' ?>>Média</option>
                                    <option value="Alta" <?= (isset($criticidade) && $criticidade == 'Alta') ? 'selected' : '' ?>>Alta</option>
                                </select>
                            </div>
                            <div>
                                <label for="id_viagem_fk" class="form-label">Viagem Referente:</label>
                                <?php
                                $viagens = [];
                                try {
                                    $stmtViagens = $conn->query("SELECT id_viagem, nome_viagem FROM viagem");
                                    $viagens = $stmtViagens->fetchAll(PDO::FETCH_ASSOC);
                                } catch (Exception $e) {
                                    echo "Erro ao buscar viagens: " . $e->getMessage();
                                }
                                ?>
                                <select class="form-select" id="id_viagem_fk" name="id_viagem_fk" required>
                                    <option value="">Selecione a viagem</option>
                                    <?php foreach ($viagens as $viagem): ?>
                                        <option value="<?= htmlspecialchars($viagem['id_viagem']) ?>"
                                            <?= (isset($id_viagem_fk) && $id_viagem_fk == $viagem['id_viagem']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($viagem['nome_viagem']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar Alerta</button>
                        </form>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>


<?php

} else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $sql2 = "INSERT INTO alerta (tipo,mensagem,data_hora,criticidade,id_viagem_fk) VALUES (:tipo,:mensagem,CURRENT_TIMESTAMP,:criticidade,:id_viagem_fk)";

        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':tipo', $_POST['tipo']);
        $stmt->bindParam(':mensagem', $_POST['mensagem']);
        $stmt->bindParam(':criticidade', $_POST['criticidade']);
        $stmt->bindParam(':id_viagem_fk', $_POST['id_viagem_fk']);
        $stmt->execute();

        if ($stmt !== false) {
            echo "<script>alert('Alerta Criado com sucesso.');</script>";
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
        <title>Cadastro de Alerta</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="../styles/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    </head>

    <body>

        <main>
            <div class="container-fluid">
                <div class="row headerDash d-flex align-items-center">
                    <div class="col-8  welcome lh-1">
                        <div class="col ms-4 fw-bold fs-5">
                            <p class="mb-0">Cadastro de Alerta</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col d-flex align-items-center justify-content-end">
                            <?php include 'partials/sidebar.php'; ?>
                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        <form method="POST">

                            <div>
                                <label for="tipo" class="form-label">Tipo:</label>
                                <select type="text" class="form-control" id="tipo" name="tipo" placeholder="Insira o tipo do alerta" required>
                                    <option value="Atraso">Atraso</option>
                                    <option value="Falha Técnica">Falha Técnica</option>
                                    <option value="Segurança">Segurança</option>
                                </select>
                            </div>

                            <div>
                                <label for="mensagem" class="form-label">Mensagem:</label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="4" placeholder="Insira a mensagem do alerta" required></textarea>
                            </div>

                            <div>
                                <label for="criticidade" class="form-label">Criticidade:</label>
                                <select class="form-control" id="criticidade" name="criticidade" placeholder="Insira a criticidade" required>
                                    <option value="Baixa">Baixa</option>
                                    <option value="Média">Média</option>
                                    <option value="Alta">Alta</option>
                                </select>
                            </div>

                            <div>
                                <label for="id_viagem_fk" class="form-label">Viagem Referente:</label>
                                <?php
                                $viagens = [];
                                try {
                                    $stmtViagens = $conn->query("SELECT id_viagem, nome_viagem FROM viagem");
                                    $viagens = $stmtViagens->fetchAll(PDO::FETCH_ASSOC);
                                } catch (Exception $e) {
                                    echo "Erro ao buscar viagens: " . $e->getMessage();
                                }
                                ?>
                                <select class="form-select" id="id_viagem_fk" name="id_viagem_fk" required>
                                    <option value="">Selecione a viagem</option>
                                    <?php foreach ($viagens as $viagem): ?>
                                        <option value="<?= htmlspecialchars($viagem['id_viagem']) ?>"
                                            <?= (isset($id_viagem_fk) && $id_viagem_fk == $viagem['id_viagem']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($viagem['nome_viagem']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary">Cadastrar Alerta</button>
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