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

    $sql2 = "SELECT * FROM estacao WHERE id_estacao = :id_estacao";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':id_estacao', $id_estacao, PDO::PARAM_INT);
    $stmt->execute();
    $estacao_row = $stmt->fetch(PDO::FETCH_ASSOC);

    $nome = $estacao_row['nome'];
    $localizacao = $estacao_row['localizacao'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $localizacao = $_POST['localizacao'];

        $sql2 = "UPDATE estacao SET nome = :nome, localizacao = :localizacao WHERE id_estacao = :id_estacao";
        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':localizacao', $localizacao);
        $stmt->bindParam(':id_estacao', $id_estacao);

        if($stmt->execute()) {
            echo "<script>alert('Estação Atualizada com sucesso.');</script>";
            header('Location: ../index.php');
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Erro: " . $errorInfo[2];
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

        $sql = "INSERT INTO segmento_rota (id_rota_fk, ordem, id_estacao_origem, id_estacao_destino, distancia_km) VALUES (:id_rota_fk, :ordem, :id_estacao_origem, :id_estacao_destino, :distancia_km)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_rota_fk', $_POST['id_rota_fk']);
        $stmt->bindParam(':ordem', $_POST['ordem']);
        $stmt->bindParam(':id_estacao_origem', $_POST['id_estacao_origem']);
        $stmt->bindParam(':id_estacao_destino', $_POST['id_estacao_destino']);
        $stmt->bindParam(':distancia_km', $_POST['distancia_km']);
    }

?>


<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Segmento de Rota</title>
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
                        <p>Cadastro de Segmento de Rota</p>
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
                        <div>
                            <label for="ordem" class="form-label">Ordem:</label>
                            <select class="form-select" id="ordem" name="ordem">
                                <option value="">Selecione a ordem</option>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
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
                        <div>
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
                        <button type="submit" class="btn btn-primary">Cadastrar Segmento de Rota</button>
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