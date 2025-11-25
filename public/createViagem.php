<?php

include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_viagem = $_GET['id'];

    $sql2 = "SELECT * FROM viagem WHERE id_viagem='$id_viagem'";
    $result = $conn->query($sql2);
    $viagem_row = $result->fetch(PDO::FETCH_ASSOC);

    $id_trem_fk = $viagem_row['id_trem_fk'];
    $id_rota_fk = $viagem_row['id_rota_fk'];
    $data_partida = $viagem_row['data_partida'];
    $data_chegada_previsao = $viagem_row['data_chegada_previsao'];
    $data_chegada = $viagem_row['data_chegada'];
    $status_viagem = $viagem_row['status_viagem'];
    $nome_viagem = $viagem_row['nome_viagem'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_trem_fk = $_POST['id_trem_fk'];
        $id_rota_fk = $_POST['id_rota_fk'];
        $data_partida = $_POST['data_partida'];
        $data_chegada_previsao = $_POST['data_chegada_previsao'];
        $data_chegada = $_POST['data_chegada'];
        $status_viagem = $_POST['status_viagem'];
        $nome_viagem = $_POST['nome_viagem'];

        $sql2 = "UPDATE viagem SET nome_viagem=:nome_viagem, id_trem_fk=:id_trem_fk, id_rota_fk=:id_rota_fk, data_partida=:data_partida, data_chegada_previsao=:data_chegada_previsao, data_chegada=:data_chegada, status_viagem=:status_viagem WHERE id_viagem=:id_viagem";

        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':nome_viagem', $nome_viagem);
        $stmt->bindParam(':id_trem_fk', $id_trem_fk);
        $stmt->bindParam(':id_rota_fk', $id_rota_fk);
        $stmt->bindParam(':data_partida', $data_partida);
        $stmt->bindParam(':data_chegada_previsao', $data_chegada_previsao);
        $stmt->bindParam(':data_chegada', $data_chegada);
        $stmt->bindParam(':status_viagem', $status_viagem);
        $stmt->bindParam(':id_viagem', $id_viagem);
        $stmt->execute();

        if ($stmt->execute()) {
            echo "<script>alert('Viagem Atualizada com sucesso.');</script>";
            echo "<script>window.location.href = 'dashboard.php';</script>";
        } else {
            $error = $stmt->errorInfo();
            echo "Erro na consulta: " . $error[2];
        }
    }


?>


    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Atualização de Viagem</title>
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
                            <p class="mb-0">Atualização de Viagem</p>
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
                                <label for="id_trem_fk" class="form-label">Trem Responsável:</label>
                                <select class="form-control" id="id_trem_fk" name="id_trem_fk" required>
                                    <option value="">Selecione o Trem</option>
                                    <?php
                                    $sql = "SELECT id_trem, identificador FROM trem";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $trens = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($trens as $trem) {
                                        echo "<option value=\"{$trem['id_trem']}\" " . ($trem['id_trem'] == $id_trem_fk ? 'selected' : '') . ">{$trem['identificador']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_rota_fk" class="form-label">Rota Pertencente:</label>
                                <select class="form-control" id="id_rota_fk" name="id_rota_fk" required>
                                    <option value="">Selecione a Rota</option>
                                    <?php
                                    $sql = "SELECT id_rota, nome FROM rota";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($rotas as $rota) {
                                        echo "<option value=\"{$rota['id_rota']}\" " . ($rota['id_rota'] == $id_rota_fk ? 'selected' : '') . ">{$rota['nome']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="data_partida" class="form-label">Data de Partida:</label>
                                <input type="datetime-local" class="form-control" id="data_partida" name="data_partida" value="<?php echo date('Y-m-d\TH:i', strtotime($data_partida)); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="data_chegada_previsao" class="form-label">Data de Chegada Prevista:</label>
                                <input type="datetime-local" class="form-control" id="data_chegada_previsao" name="data_chegada_previsao" value="<?php echo date('Y-m-d\TH:i', strtotime($data_chegada_previsao)); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="data_chegada" class="form-label">Data de Chegada:</label>
                                <input type="datetime-local" class="form-control" id="data_chegada" name="data_chegada" value="<?php echo date('Y-m-d\TH:i', strtotime($data_chegada)); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="status_viagem" class="form-label">Status da Viagem:</label>
                                <select class="form-control" id="status_viagem" name="status_viagem" required>
                                    <option value="Ok" <?php echo $status_viagem == 'Ok' ? 'selected' : ''; ?>>Ok</option>
                                    <option value="Revisão" <?php echo $status_viagem == 'Revisão' ? 'selected' : ''; ?>>Revisão</option>
                                    <option value="Reparo" <?php echo $status_viagem == 'Reparo' ? 'selected' : ''; ?>>Reparo</option>
                                    <option value="Atraso" <?php echo $status_viagem == 'Atraso' ? 'selected' : ''; ?>>Atraso</option>
                                </select>
                            </div>

                            <div>
                                <label for="nome_viagem" class="form-label">Nome da Viagem:</label>
                                <input type="text" class="form-control" id="nome_viagem" name="nome_viagem" value="<?php echo $nome_viagem; ?>" required>
                            </div>

                            <button type="submit" class="btn btn-light btnLogin mt-5">Atualizar Viagem</button>
                        </form>
                    </div>


                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>

<?php
} else {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $sql = "INSERT INTO viagem (id_trem_fk, id_rota_fk, data_partida, data_chegada_previsao, data_chegada, status_viagem, nome_viagem) 
                VALUES (:id_trem_fk, :id_rota_fk, :data_partida, :data_chegada_previsao, :data_chegada, :status_viagem, :nome_viagem)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_trem_fk', $_POST['id_trem_fk']);
        $stmt->bindParam(':id_rota_fk', $_POST['id_rota_fk']);
        $stmt->bindParam(':data_partida', $_POST['data_partida']);
        $stmt->bindParam(':data_chegada_previsao', $_POST['data_chegada_previsao']);

        $data_chegada = !empty($_POST['data_chegada']) ? $_POST['data_chegada'] : null;
        if (is_null($data_chegada)) {
            $stmt->bindValue(':data_chegada', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':data_chegada', $data_chegada);
        }

        $stmt->bindParam(':status_viagem', $_POST['status_viagem']);
        $stmt->bindParam(':nome_viagem', $_POST['nome_viagem']);
        $stmt->execute();

        if ($stmt->execute()) {
            echo "<script>alert('Viagem cadastrada com sucesso.');</script>";
            echo "<script>window.location.href = 'dashboard.php';</script>";
        } else {
            $error = $stmt->errorInfo();
            echo "Erro na consulta: " . $error[2];
        }
    }
?>


    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Viagem</title>
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
                            <p class="mb-0">Cadastro de Viagem</p>
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
                                <label for="id_trem_fk" class="form-label">Trem Responsável:</label>
                                <select class="form-control" id="id_trem_fk" name="id_trem_fk">
                                    <option value="">Selecione o Trem</option>
                                    <?php
                                    $sql = "SELECT id_trem, identificador FROM trem";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $trens = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($trens as $trem) {
                                        echo "<option value=\"{$trem['id_trem']}\">{$trem['identificador']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_rota_fk" class="form-label">Rota Pertencente:</label>
                                <select class="form-control" id="id_rota_fk" name="id_rota_fk">
                                    <option value="">Selecione a Rota</option>
                                    <?php
                                    $sql = "SELECT id_rota, nome FROM rota";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($rotas as $rota) {
                                        echo "<option value=\"{$rota['id_rota']}\">{$rota['nome']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="data_partida" class="form-label">Data de Partida:</label>
                                <input type="datetime-local" class="form-control" id="data_partida" name="data_partida" required>
                            </div>

                            <div class="mb-3">
                                <label for="data_chegada_previsao" class="form-label">Data de Chegada Prevista:</label>
                                <input type="datetime-local" class="form-control" id="data_chegada_previsao" name="data_chegada_previsao" required>
                            </div>

                            <div class="mb-3">
                                <label for="data_chegada" class="form-label">Data de Chegada:</label>
                                <input type="datetime-local" class="form-control" id="data_chegada" name="data_chegada">
                            </div>

                            <div class="mb-3">
                                <label for="status_viagem" class="form-label">Status da Viagem:</label>
                                <select class="form-control" id="status_viagem" name="status_viagem" required>
                                    <option value="Ok">Ok</option>
                                    <option value="Revisão">Revisão</option>
                                    <option value="Reparo">Reparo</option>
                                    <option value="Atraso">Atraso</option>
                                </select>
                            </div>

                            <div>
                                <label for="nome_viagem" class="form-label">Nome da Viagem:</label>
                                <input type="text" class="form-control" id="nome_viagem" name="nome_viagem" required>
                            </div>

                            <button type="submit" class="btn btn-light btnLogin mt-5">Cadastrar Viagem</button>
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