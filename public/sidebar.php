<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['gestao'])) {
        header('Location: gestaoDeRotas.php');
        exit;
    } elseif (isset($_POST['listaCadastros'])) {
        header('Location: listaCadastros.php');
        exit;
    } elseif (isset($_POST['manutencao'])) {
        header('Location: manutencao.php');
        exit;
    } elseif (isset($_POST['relatorios'])) {
        header('Location: relatorios.php');
        exit;
    } elseif (isset($_POST['alertas'])) {
        header('Location: alertas.php');
        exit;
    } elseif (isset($_POST['funcionarios'])) {
        header('Location: funcionarios.php');
        exit;
    } elseif (isset($_POST['sair'])) {
        session_destroy();
        header('Location: ../index.php');
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../styles/style_sidebar.css">
    <script src="../scripts/script_sidebar.js"></script>

    <title>sidebar</title>
</head>

<body>
<button class="open-sidebar-btn" onclick="openSidebar()">☰</button>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="sidebar" id="sidebar">
    <button class="close-btn" onclick="closeSidebar()">✕</button>

    <form method="post">
        <button type="submit" name="gestao">Gestão de Rotas</button>
        <button type="submit" name="manutencao">Monit. de Manutenção</button>
        <button type="submit" name="relatorios">Relatórios e Análises</button>
        <button type="submit" name="alertas">Alertas e Notificações</button>
        <?php if (isset($_SESSION['perfil']) && strcasecmp(trim($_SESSION['perfil']), 'Gerente') === 0): ?>
            <button type="submit" name="listaCadastros" class="func-btn">Lista Cadastros</button>
            <button type="submit" name="funcionarios" class="func-btn">Funcionários</button>
            <button type="submit" name="funcionarios" class="func-btn">Lista de Cadastros</button>
        <?php endif; ?>
        <button type="submit" name="sair" class="bottom-btn">Sair da Conta</button>
    </form>
    
</div>
</body>
</html>