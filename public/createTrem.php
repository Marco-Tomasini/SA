<?php

include 'db.php';
include "../src/User.php";

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $sql = "INSERT INTO trem (identificador,modelo,capacidade_passageiros,capacidade_carga_kg,status_trem,quilometragem,ultima_manutencao) VALUES (:identificador,:modelo,:capacidade_passageiros,:capacidade_carga_kg,:status_trem,:quilometragem,:ultima_manutencao)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':identificador', $_POST['identificador']);
        $stmt->bindParam(':modelo', $_POST['modelo']);
        $stmt->bindParam(':capacidade_passageiros', $_POST['capacidade_passageiros']);
        $stmt->bindParam(':capacidade_carga_kg', $_POST['capacidade_carga_kg']);
        $stmt->bindParam(':status_trem', $_POST['status_trem']);
        $stmt->bindParam(':quilometragem', $_POST['quilometragem']);
        $stmt->bindParam(':ultima_manutencao', $_POST['ultima_manutencao']);
        $stmt->execute();

    }

?>


<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Trem</title>
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
                        <p class="mb-0">Cadastro de Trens</p>
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
                            <label for="identificador" class="form-label">Identificador:</label>
                            <input type="text" class="form-control" id="identificador" name="identificador" placeholder="Insira o identificador do trem">
                        </div>
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo:</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" rows="4" placeholder="Insira o modelo do trem"></input>
                        </div>
                        <div class="mb-3">
                            <label for="capacidade_passageiros" class="form-label">Capacidade de Passageiros:</label>
                            <input type="number" class="form-control" id="capacidade_passageiros" name="capacidade_passageiros" placeholder="Insira a capacidade de passageiros">
                        </div>
                        <div class="mb-3">
                            <label for="capacidade_carga_kg" class="form-label">Capacidade de Carga (kg):</label>
                            <input type="number" class="form-control" id="capacidade_carga_kg" name="capacidade_carga_kg" placeholder="Insira a capacidade de carga em kg">
                        </div>
                        <div>
                            <label for="status_trem" class="form-label">Status do Trem:</label>
                            <select class="form-control" id="status_trem" name="status_trem">
                                <option value="Operacional">Operacional</option>
                                <option value="Manutenção">Manutenção</option>
                                <option value="Fora de Serviço">Fora de Serviço</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-light btnLogin mt-5">Cadastrar Trem</button>
                    </form>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>