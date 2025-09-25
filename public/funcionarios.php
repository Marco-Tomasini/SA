<?php

session_start();
include 'db.php';

$sql = "SELECT id_usuario,imagem_usuario,nome,data_nascimento,cpf FROM usuario";
$result = $mysqli->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../styles/style.css">


    <title>Funcionários</title>
</head>
<body>
    <main>
        <div class="gridFunc">
            <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="profile">
                <img src="../assets/img/<?php echo ($row['imagem_usuario']); ?>" alt="user-icon">
                <h2><?php echo ($row['nome']); ?></h2>
                <h3><?php echo ($row['data_nascimento']); ?></h3>
                <h3><?php echo ($row['cpf']); ?></h3>
            </div>
            <?php } ?>
        </div>
    </main>

</body>
</html>