<?php

include 'db.php';

$sql = "SELECT * FROM viagem";

$result = $mysqli->query($sql);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row headerDash d-flex align-items-center">
                <div class="col-6 mt-4 ms-2 welcome">
                    <p>Bem-vindo(a)</p>
                </div>

                <div class="col-6">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['data_partida']; ?></td>
                                <td><?php echo $row['data_chegada_previsao']; ?></td>
                                <td><?php echo $row['status_viagem']; ?></td>
                                <td><?php echo $row['id_viagem']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Nenhum jogador encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </div>

                <div class="col">

                </div>

                <div class="col">

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>