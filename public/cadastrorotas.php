<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestão das Rotas</title>
    <style>
        body {
            margin: 0;
            background: #ddd;
            font-family: Arial, sans-serif;
        }
        .header {
            width: 100%;
            background: #6c437c;
            color: #fff;
            display: flex;
            align-items: center;
            padding: 0;
            height: 48px;
            position: relative;
        }
        .header .back-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 28px;
            margin-left: 10px;
            cursor: pointer;
            position: absolute;
            left: 0;
            top: 0;
            height: 48px;
            width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header-title {
            width: 100%;
            text-align: center;
            font-size: 20px;
            line-height: 48px;
            font-weight: 500;
        }
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 80vh;
            padding: 0;
        }
        .map-container {
            background: none;
            border-radius: 0;
            border: none;
            margin: 32px 0 0 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: none;
        }
        .footer {
            width: 100%;
            background: #888;
            color: #fff;
            text-align: center;
            padding: 12px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px 8px;
            text-align: left;
        }
        th {
            background: #fff;
            color: #000;
        }
        tr:nth-child(even) {
            background: #f5f5f5;
        }
        .btn {
            background: #000;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn:hover {
            background: #444;
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-btn" onclick="window.location.href='Dashboard.php'">
            &#8592;
        </button>
        <div class="header-title">Gestão das Rotas</div>
    </div>
    <div class="main-content">
        <div class="map-container">
            
            <img src="../assets/icon/map.png" alt="Mapa das Rotas" style="width:90%;max-width:350px;display:block;margin:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Rotas</th>
                    </tr>
                </thead>
                <tbody>
                   <?php include 'db.php'?>
                </tbody>
            </table>
            <form method="post" style="margin-top:16px;width:100%;max-width:350px;display:flex;flex-direction:column;align-items:center;gap:12px;">
                <input type="text" name="nova_rota" placeholder="Digite o nome da rota" style="width:80%;padding:8px;font-size:1rem;border:1px solid #aaa;border-radius:4px;">
                <button type="submit" class="btn" style="width:80%;background:#6c437c;color:#fff;border:none;padding:10px 0;border-radius:6px;cursor:pointer;font-size:1.1rem;box-shadow:0 2px 8px #0002;transition:background 0.2s;">Ir para rota</button>
            </form>
            <style>
                .btn {
                    display: block;
                    margin: 0 auto;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                }
                .btn:hover {
                    background: #4e2c5a;
                    box-shadow: 0 4px 12px #0003;
                }
            </style>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $rota = '';
                if (!empty($_POST['nova_rota'])) {
                    $rota = $_POST['nova_rota'];
                }
                if ($rota !== '') {
                    $conn = @new mysqli('localhost', 'root', '', 'SmartCitiesV7');
                    if (!$conn->connect_error) {
                        $nome = $conn->real_escape_string($rota);
                        $sql = "INSERT INTO rota (nome) VALUES ('$nome')";
                        if ($conn->query($sql)) {
                            echo '<script>location.reload();</script>';
                        } else {
                            echo '<div style="color:red;margin-top:8px;">Erro ao cadastrar rota.</div>';
                        }
                        $conn->close();
                    } else {
                        echo '<div style="color:red;margin-top:8px;">Erro ao conectar ao banco.</div>';
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="footer">
        Para editar rota/info clique na estação
    </div>
</body>
</html>