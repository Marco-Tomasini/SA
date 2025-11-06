<?php

include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}


    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $sql = "INSERT INTO viagem (id_trem_fk, id_rota_fk, data_partida, data_chegada_previsao, data_chegada, status_viagem, nome_viagem) 
            VALUES (:id_trem_fk, :id_rota_fk, :data_partida, :data_chegada_previsao, :data_chegada, :status_viagem, :nome_viagem)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_trem_fk', $_POST['id_trem_fk']);
        $stmt->bindParam(':id_rota_fk', $_POST['id_rota_fk']);
        $stmt->bindParam(':data_partida', $_POST['data_partida']);
        $stmt->bindParam(':data_chegada_previsao', $_POST['data_chegada_previsao']);
        $stmt->bindParam(':data_chegada', $_POST['data_chegada']);
        $stmt->bindParam(':status_viagem', $_POST['status_viagem']);
        $stmt->bindParam(':nome_viagem', $_POST['nome_viagem']);
        $stmt->execute();

    }

?>


<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Viagem</title>
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
                        <p>Cadastro de Viagem</p>
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