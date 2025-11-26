<?php
include 'db.php';
include "../src/User.php";

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $segmento_rota = $_GET['id'];

    $sql2 = "SELECT * FROM segmento_rota WHERE id_segmento_rota = :id_segmento_rota";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':id_segmento_rota', $segmento_rota, PDO::PARAM_INT);
    $stmt->execute();
    $segmento_rota_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sql2 = "UPDATE segmento_rota SET id_rota_fk = :id_rota_fk, ordem = :ordem, id_estacao_origem = :id_estacao_origem, id_estacao_destino = :id_estacao_destino, distancia_km = :distancia_km WHERE id_segmento_rota = :id_segmento_rota";

        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':id_rota_fk', $_POST['id_rota_fk']);
        $stmt->bindParam(':ordem', $_POST['ordem']);
        $stmt->bindParam(':id_estacao_origem', $_POST['id_estacao_origem']);
        $stmt->bindParam(':id_estacao_destino', $_POST['id_estacao_destino']);
        $stmt->bindParam(':distancia_km', $_POST['distancia_km']);
        $stmt->bindParam(':id_segmento_rota', $segmento_rota, PDO::PARAM_INT);

        if ($stmt !== false) {
            echo "<script>alert('Segmento de Rota Atualizado com sucesso.');</script>";
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
        <title>Atualização de Segmento de Rota</title>
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
                            <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='gestaoDeRotas.php'"></i>
                            <p class="mb-0">Atualização de Segmento de Rota</p>
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
                                <label for="id_rota_fk" class="form-label" selected=''>Rota Pertencente:</label>
                                <?php
                                $rotas = [];
                                try {
                                    $stmtRotas = $conn->query("SELECT id_rota, nome FROM rota");
                                    $rotas = $stmtRotas->fetchAll(PDO::FETCH_ASSOC);
                                } catch (Exception $e) {
                                    echo "Erro ao buscar rotas: " . $e->getMessage();
                                }
                                ?>
                                <select class="form-select" id="id_rota_fk" name="id_rota_fk" required>
                                    <option value="">Selecione a rota</option>
                                    <?php foreach ($rotas as $rota): ?>
                                        <option value="<?= htmlspecialchars($rota['id_rota']) ?>"
                                            <?= (isset($segmento_rota_row['id_rota_fk']) && $segmento_rota_row['id_rota_fk'] == $rota['id_rota']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($rota['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="id_estacao_origem" class="form-label">Estação de Origem:</label>
                                <?php
                                $estacoes = [];
                                try {
                                    $stmtEstacoes = $conn->query("SELECT id_estacao, nome FROM estacao");
                                    $estacoes = $stmtEstacoes->fetchAll(PDO::FETCH_ASSOC);
                                } catch (Exception $e) {
                                    echo "Erro ao buscar estações: " . $e->getMessage();
                                }
                                ?>
                                <select class="form-select" id="id_estacao_origem" name="id_estacao_origem" required>
                                    <option value="">Selecione a estação de origem</option>
                                    <?php foreach ($estacoes as $estacao): ?>
                                        <option value="<?= htmlspecialchars($estacao['id_estacao']) ?>"
                                            <?= (isset($segmento_rota_row['id_estacao_origem']) && $segmento_rota_row['id_estacao_origem'] == $estacao['id_estacao']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estacao['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="id_estacao_destino" class="form-label">Estação de Destino:</label>
                                <?php
                                $estacoes = [];
                                try {
                                    $stmtEstacoes = $conn->query("SELECT id_estacao, nome FROM estacao");
                                    $estacoes = $stmtEstacoes->fetchAll(PDO::FETCH_ASSOC);
                                } catch (Exception $e) {
                                    echo "Erro ao buscar estações: " . $e->getMessage();
                                }
                                ?>
                                <select class="form-select" id="id_estacao_destino" name="id_estacao_destino" required>
                                    <option value="">Selecione a estação de destino</option>
                                    <?php foreach ($estacoes as $estacao): ?>
                                        <option value="<?= htmlspecialchars($estacao['id_estacao']) ?>"
                                            <?= (isset($segmento_rota_row['id_estacao_destino']) && $segmento_rota_row['id_estacao_destino'] == $estacao['id_estacao']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estacao['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="ordem" class="form-label">Ordem:</label>
                                <select class="form-select" id="ordem" name="ordem" required>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>" <?= (isset($segmento_rota_row['ordem']) && $segmento_rota_row['ordem'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div>
                                <label for="distancia_km" class="form-label">Distância (km):</label>
                                <input type="number" class="form-control" id="distancia_km" name="distancia_km" required value="<?php echo isset($segmento_rota_row['distancia_km']) ? htmlspecialchars($segmento_rota_row['distancia_km']) : ''; ?>">
                            </div>

                            <button type="submit" class="btn btn-dark btnLogin mt-5">Atualizar Segmento de Rota</button>
                        </form>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>





<?php
} else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (
            !empty($_POST['id_rota_fk']) &&
            !empty($_POST['ordem']) &&
            !empty($_POST['id_estacao_origem']) &&
            !empty($_POST['id_estacao_destino']) &&
            isset($_POST['distancia_km'])
        ) {
            $sql = "INSERT INTO segmento_rota (id_rota_fk, ordem, id_estacao_origem, id_estacao_destino, distancia_km) VALUES (:id_rota_fk, :ordem, :id_estacao_origem, :id_estacao_destino, :distancia_km)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_rota_fk', $_POST['id_rota_fk']);
            $stmt->bindParam(':ordem', $_POST['ordem']);
            $stmt->bindParam(':id_estacao_origem', $_POST['id_estacao_origem']);
            $stmt->bindParam(':id_estacao_destino', $_POST['id_estacao_destino']);
            $stmt->bindParam(':distancia_km', $_POST['distancia_km']);

            if ($stmt->execute()) {
                echo "<script>alert('Segmento de Rota cadastrado com sucesso.');</script>";
                echo "<script>window.location.href = 'dashboard.php';</script>";
            } else {
                $error = $stmt->errorInfo();
                echo "Erro na consulta: " . $error[2];
            }
        } else {
            echo "<script>alert('Preencha todos os campos obrigatórios.');</script>";
        }
    }

?>


    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Segmento de Rota</title>
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
                            <p class="mb-0">Cadastro de Segmento de Rota</p>
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
                                <label for="id_rota_fk" class="form-label">Rota Pertencente:</label>
                                <?php
                                $rotas = [];
                                try {
                                    $stmtRotas = $conn->query("SELECT id_rota, nome FROM rota");
                                    $rotas = $stmtRotas->fetchAll(PDO::FETCH_ASSOC);
                                } catch (Exception $e) {
                                    echo "Erro ao buscar rotas: " . $e->getMessage();
                                }
                                ?>
                                <select class="form-select" id="id_rota_fk" name="id_rota_fk">
                                    <option value="">Selecione a rota</option>
                                    <?php foreach ($rotas as $rota): ?>
                                        <option value="<?= htmlspecialchars($rota['id_rota']) ?>">
                                            <?= htmlspecialchars($rota['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ordem" class="form-label">Ordem:</label>
                                <select class="form-select" id="ordem" name="ordem">
                                    <option value="">Selecione a ordem</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_estacao_origem" class="form-label">Estação de Origem:</label>
                                <select class="form-select" id="id_estacao_origem" name="id_estacao_origem">
                                    <option value="">Selecione a estação de origem</option>
                                    <?php
                                    $estacoes = [];
                                    try {
                                        $stmtEstacoes = $conn->query("SELECT id_estacao, nome FROM estacao");
                                        $estacoes = $stmtEstacoes->fetchAll(PDO::FETCH_ASSOC);
                                    } catch (Exception $e) {
                                        echo "Erro ao buscar estações: " . $e->getMessage();
                                    }
                                    ?>
                                    <?php foreach ($estacoes as $estacao): ?>
                                        <option value="<?= htmlspecialchars($estacao['id_estacao']) ?>">
                                            <?= htmlspecialchars($estacao['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_estacao_destino" class="form-label">Estação de Destino:</label>
                                <select class="form-select" id="id_estacao_destino" name="id_estacao_destino">
                                    <option value="">Selecione a estação de destino</option>
                                    <?php foreach ($estacoes as $estacao): ?>
                                        <option value="<?= htmlspecialchars($estacao['id_estacao']) ?>">
                                            <?= htmlspecialchars($estacao['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="distancia_km" class="form-label">Distância (km):</label>
                                <input type="number" class="form-control" id="distancia_km" name="distancia_km" placeholder="Insira a distância em km">
                            </div>
                            <button type="submit" class="btn btn-light btnLogin mt-5">Cadastrar Segmento de Rota</button>
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