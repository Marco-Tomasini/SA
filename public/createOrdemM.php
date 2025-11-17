<?php
include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_ordem = $_GET['id'];
    $sql2 = "SELECT * FROM ordem_manutencao WHERE id_ordem = :id_ordem";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':id_ordem', $id_ordem);
    $stmt->execute();
    $ordem = $stmt->fetch(PDO::FETCH_ASSOC);

    $id_trem_fk = $ordem['id_trem_fk'];
    $data_fechamento = $ordem['data_fechamento'];
    $tipo = $ordem['tipo'];
    $descricao = $ordem['descricao'];
    $status_manutencao = $ordem['status_manutencao'];


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_trem_fk = $_POST['id_trem_fk'];
        $data_fechamento = $_POST['data_fechamento'];
        $tipo = $_POST['tipo'];
        $descricao = $_POST['descricao'];
        $status_manutencao = $_POST['status_manutencao'];

        $sql2 = "UPDATE ordem_manutencao SET id_trem_fk=:id_trem_fk, data_fechamento=:data_fechamento, tipo=:tipo, descricao=:descricao, status_manutencao=:status_manutencao WHERE id_ordem=:id_ordem";
        
        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':id_trem_fk', $id_trem_fk);
        $stmt->bindParam(':data_fechamento', $data_fechamento);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status_manutencao', $status_manutencao);
        $stmt->bindParam(':id_ordem', $id_ordem);

        if (!empty($data_fechamento)) {
        $data_fechamento = date('Y-m-d', strtotime(str_replace('/', '-', $data_fechamento)));
        } else {
            $data_fechamento = null;
        }
        if ($stmt->execute() !== false) {
            echo "<script>alert('Ordem de Manutenção Atualizada com sucesso.');</script>";
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
    <title>Atualização de Ordem de Manutenção</title>
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
                        <p>Atualização de Ordens de Manutenção</p>
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
                            <label for="id_trem_fk" class="form-label">Trem:</label>
                            <select class="form-control" id="id_trem_fk" name="id_trem_fk">
                                <option value="">Selecione o trem</option>
                                <?php
                                $stmtTrem = $conn->query("SELECT id_trem, identificador FROM trem");
                                $trens = $stmtTrem->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($trens as $trem) {
                                    echo "<option value=\"" . htmlspecialchars($trem['id_trem']) . "\"" . (($trem['id_trem'] == $id_trem_fk) ? " selected" : "") . ">" . htmlspecialchars($trem['identificador']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="data_fechamento" class="form-label">Data de Fechamento:</label>
                            <input type="date" class="form-control" id="data_fechamento" name="data_fechamento" value="<?= htmlspecialchars($data_fechamento) ?>">
                        </div>

                        <div>
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="Preventiva" <?= (isset($tipo) && $tipo == 'Preventiva') ? 'selected' : '' ?>>Preventiva</option>
                                <option value="Corretiva" <?= (isset($tipo) && $tipo == 'Corretiva') ? 'selected' : '' ?>>Corretiva</option>
                            </select>
                        </div>

                        <div>
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea class="form-control" id="descricao" name="descricao"><?= htmlspecialchars($descricao) ?></textarea>
                        </div>

                        <div>
                            <label for="status_manutencao" class="form-label">Status:</label>
                            <select class="form-control" id="status_manutencao" name="status_manutencao">
                                <option value="Aberta" <?= (isset($status_manutencao) && $status_manutencao == 'Aberta') ? 'selected' : '' ?>>Aberta</option>
                                <option value="Em Andamento" <?= (isset($status_manutencao) && $status_manutencao == 'Em Andamento') ? 'selected' : '' ?>>Em Andamento</option>
                                <option value="Fechada" <?= (isset($status_manutencao) && $status_manutencao == 'Fechada') ? 'selected' : '' ?>>Fechada</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Atualizar Trem</button>
                    </form>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


<?php

}else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $sql = "INSERT INTO ordem_manutencao (id_trem_fk,data_abertura,data_fechamento,tipo,descricao,status_manutencao) VALUES (:id_trem_fk,:data_abertura,:data_fechamento,:tipo,:descricao,:status_manutencao)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_trem_fk', $_POST['id_trem_fk']);
        $stmt->bindParam(':data_abertura', $_POST['data_abertura']);
        $stmt->bindParam(':data_fechamento', $_POST['data_fechamento']);
        $stmt->bindParam(':tipo', $_POST['tipo']);
        $stmt->bindParam(':descricao', $_POST['descricao']);
        $stmt->bindParam(':status_manutencao', $_POST['status_manutencao']);
        $stmt->execute();

        $stmt = $conn->query($sql);
        if ($stmt !== false) {
            echo "<script>alert('Ordem de Manutenção Criada com sucesso.');</script>";
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
    <title>Cadastro de Ordens de Manutenção</title>
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
                        <p class="mb-0">Cadastro de Ordens de Manutenção</p>
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
                            <label for="id_trem_fk" class="form-label">Trem da Ordem:</label>
                            <select class="form-control" id="id_trem_fk" name="id_trem_fk">
                                <option value="">Selecione o trem</option>
                                <?php
                                $stmtTrens = $conn->query("SELECT id_trem, identificador FROM trem");
                                $trens = $stmtTrens->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($trens as $trem): ?>
                                    <option value="<?= htmlspecialchars($trem['id_trem']) ?>">
                                        <?= htmlspecialchars($trem['identificador']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="data_abertura" class="form-label">Data Abertura:</label>
                            <input type="date" class="form-control" id="data_abertura" name="data_abertura" placeholder="Insira a data de abertura">
                        </div>

                        <div class="mb-3">
                            <label for="data_fechamento" class="form-label">Data de Fechamento:</label>
                            <input type="date" class="form-control" id="data_fechamento" name="data_fechamento" placeholder="Insira a data de fechamento">
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="Preventiva">Preventiva</option>
                                <option value="Corretiva">Corretiva</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Insira a descrição da ordem de manutenção"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status_manutencao" class="form-label">Status:</label>
                            <select class="form-control" id="status_manutencao" name="status_manutencao">
                                <option value="Aberta">Aberta</option>
                                <option value="Em Andamento">Em Andamento</option>
                                <option value="Fechada">Fechada</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-light btnLogin mt-5">Cadastrar Ordem</button>
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