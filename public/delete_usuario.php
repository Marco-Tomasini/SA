<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'Gerente') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    if (!isset($_GET['confirm'])) {
        echo '<script>
            if (confirm("Deseja realmente deletar este usuário?")) {
                window.location.href = "?id=' . rawurlencode($id_usuario) . '&confirm=1";
            } else {
                window.location.href = "funcionarios.php";
            }
        </script>';
        exit();
    }

    if ($stmt->execute()) {
        header("Location: funcionarios.php?msg=Usuário demitido com sucesso.");
        exit();
    } else {
        echo "Erro ao demitir usuário.";
    }
} else {
    echo "ID do usuário não fornecido.";
}

?>