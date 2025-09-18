<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sidebar</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            height: 100%;
            background: #fff;
            border-left: 2px solid #000;
            padding: 16px 16px 0 16px;
            display: flex;
            flex-direction: column;
        }
        .sidebar form {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .close-btn {
            align-self: flex-end;
            background: none;
            border: none;
            font-size: 22px;
            color: #000;
            cursor: pointer;
            margin-bottom: 24px;
        }
        .sidebar button {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #000;
            background: #fff;
            color: #000;
            font-size: 15px;
            border-radius: 0;
            cursor: pointer;
        }
        .sidebar button:hover {
            background: #000;
            color: #fff;
        }
        .sidebar .bottom-btn {
            margin-top: auto;
            margin-bottom: 30px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <button class="close-btn" onclick="document.getElementById('sidebar').classList.add('hidden')">X</button>
        <form method="post">
            <button type="submit" name="gestao">Gestão de Rotas</button>
            <button type="submit" name="manutencao">Monit. de Manutenção</button>
            <button type="submit" name="relatorios">Relatórios e Análise</button>
            <button type="submit" name="alertas">Alertas e Notificações</button>
            <button type="submit" name="funcionarios">Funcionários</button>
            <button type="submit" name="sair" class="bottom-btn">Sair</button>
        </form>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['gestao'])) {
            echo "<script>alert('Gestão de Rotas clicado');</script>";
        } elseif (isset($_POST['manutencao'])) {
            echo "<script>alert('Monit. de Manutenção clicado');</script>";
        } elseif (isset($_POST['relatorios'])) {
            echo "<script>alert('Relatórios e Análise clicado');</script>";
        } elseif (isset($_POST['alertas'])) {
            echo "<script>alert('Alertas e Notificações clicado');</script>";
        } elseif (isset($_POST['funcionarios'])) {
            echo "<script>alert('Funcionários clicado');</script>";
        } elseif (isset($_POST['sair'])) {
            echo "<script>alert('Saindo...');</script>";
        }
    }
    ?>
</body>
</html>