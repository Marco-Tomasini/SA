<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            background: #fff;
            font-family: Arial, sans-serif;
        }
        .img-btn {
            position: fixed;
            top: 32px;
            right: 32px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            margin: 0;
            z-index: 2000;
        }
        .img-btn img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }
        #sidebar {
            display: none;
        }
        #sidebar.active {
            display: block;
        }
    </style>
</head>
<body>
    <button class="img-btn" onclick="document.getElementById('sidebar').classList.add('active')">
        <img src="menu.png">
    </button>
    <?php include 'sidebar.php'; ?>
    <script>
        // Sidebar toggle
        document.querySelector('.close-btn').onclick = function() {
            document.getElementById('sidebar').classList.remove('active');
        };
    </script>
</body>
</html>