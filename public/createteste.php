<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Validarcpf.php';
use App\Validarcpf;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'validar_cpf') {
    $cpf = $_POST['cpf'] ?? '';
    $nascimento = $_POST['nascimento'] ?? '';

    $validator = new Validarcpf();
    $result = $validator->validar($cpf, $nascimento);

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Validação de CPF com API</title>
  <script src="../scripts/validar_cpf.js"></script>
</head>
<body>
  <h2>Validação de CPF via API</h2>
  <label>CPF:</label>
  <input type="text" id="cpf" placeholder="123.456.789-09"><br><br>
  <label>Data de nascimento:</label>
  <input type="date" id="nascimento"><br><br>
  <button onclick="validarCPF()">Validar</button>
  <p id="resultado"></p>
</body>
</html>
