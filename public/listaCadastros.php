<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de Cadastros</title>

    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
            /* Impede rolagem na página pai */
        }

        .headerDash {
            /* Se o seu CSS externo definir altura, ok. Senão, defina aqui para o calculo do calc() funcionar bem */
            min-height: 60px;
            background-color: #212529;
            /* Apenas visualização caso falte o CSS */
            color: white;
        }

        /* Container principal abaixo do header */
        .full-height-container {
            height: calc(100vh - 60px);
            /* Altura da tela menos o header */
        }

        /* Coluna de conteúdo vira um flexbox vertical */
        .content-column {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* O iframe cresce para ocupar o espaço que sobra */
        .iframe-container {
            flex-grow: 1;
            width: 100%;
            position: relative;
        }

        #mainFrame {
            width: 100%;
            height: 100%;
            border: none;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Estilo para o item ativo */
        .list-group-item.active {
            z-index: 2;
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">

        <div class="row headerDash d-flex justify-content-between align-items-center sticky-top">
            <div class="col-8 welcome lh-1">
                <div class="col ms-4 fw-bold fs-5 d-flex align-items-center">
                    <i class="bi bi-box-arrow-in-left fs-3 me-3" onclick="window.location.href='dashboard.php'" style="cursor: pointer;"></i>
                    <p class="mb-0">Central de Cadastros</p>
                </div>
            </div>

            <div class="col-4 col-lg-3 d-flex justify-content-end align-items-center">
                <div class="col-5 col-md-3 d-flex justify-content-start align-items-center">
                    <i class="bi bi-bell fs-4 me-2 text-light" onclick="window.location.href='alertas.php'" style="cursor: pointer;"></i>
                </div>
                <div class="col-5 col-md-3 d-flex justify-content-end align-items-center">
                    <?php include 'partials/sidebar.php'; ?>
                </div>
            </div>
        </div>
        <div class="row g-0 full-height-container">

            <div class="col-md-3 col-lg-2 sidebar-menu p-3 border-end d-none d-md-block bg-light">
                <h6 class="text-uppercase text-muted fw-bold small mb-3 mt-2 ms-1">Opções</h6>

                <div id="desktop-menu-list" class="list-group list-group-flush">
                    <button class="list-group-item list-group-item-action d-flex align-items-center"
                        onclick="loadPage('createTrem.php', this)">
                        <i class="bi bi-train-front me-2"></i> Trem
                    </button>

                    <button class="list-group-item list-group-item-action d-flex align-items-center"
                        onclick="loadPage('createAlerta.php', this)">
                        <i class="bi bi-exclamation-triangle me-2"></i> Alerta
                    </button>

                    <button class="list-group-item list-group-item-action d-flex align-items-center"
                        onclick="loadPage('cadastrorotas.php', this)">
                        <i class="bi bi-signpost-split me-2"></i> Rotas
                    </button>

                    <button class="list-group-item list-group-item-action d-flex align-items-center"
                        onclick="loadPage('createViagem.php', this)">
                        <i class="bi bi-calendar-check me-2"></i> Viagem
                    </button>

                    <button class="list-group-item list-group-item-action d-flex align-items-center"
                        onclick="loadPage('createEstacao.php', this)">
                        <i class="bi bi-building me-2"></i> Estações
                    </button>

                    <button class="list-group-item list-group-item-action d-flex align-items-center"
                        onclick="loadPage('createOrdemM.php', this)">
                        <i class="bi bi-wrench-adjustable me-2"></i> Manutenção
                    </button>

                    <button class="list-group-item list-group-item-action d-flex align-items-center"
                        onclick="loadPage('createSegmentoRota.php', this)">
                        <i class="bi bi-bezier2 me-2"></i> Segmento
                    </button>
                </div>
            </div>

            <div class="col-12 col-md-9 col-lg-10 content-column bg-white">

                <div class="d-md-none p-2 border-bottom bg-light d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-muted ps-2">Menu de Opções</span>
                    <button class="btn btn-dark btnMobileCadastros rounded-4 btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <i class="bi bi-list me-1"></i> Selecionar Cadastro
                    </button>
                </div>

                <div class="iframe-container">
                    <iframe src="createTrem.php" id="mainFrame" name="conteudoCadastro"></iframe>
                </div>
            </div>

        </div>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header bg-light">
            <h5 class="offcanvas-title fw-bold">Selecione uma opção</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div id="mobile-menu-content" class="p-3"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Script para copiar os botões do Desktop para o Mobile automaticamente
        // Assim você só edita a lista no HTML principal e o menu mobile atualiza sozinho
        document.addEventListener("DOMContentLoaded", function() {
            const desktopList = document.getElementById('desktop-menu-list');
            const mobileContainer = document.getElementById('mobile-menu-content');

            if (desktopList && mobileContainer) {
                // Clona a lista inteira
                const clonedList = desktopList.cloneNode(true);
                // Remove o ID da cópia para não ter IDs duplicados
                clonedList.removeAttribute('id');
                mobileContainer.appendChild(clonedList);
            }
        });

        // 2. Função de carregamento da página
        function loadPage(url, element) {
            // Carrega o Iframe
            document.getElementById('mainFrame').src = url;

            // Remove classe active de TODOS os botões (desktop e mobile clone)
            const allButtons = document.querySelectorAll('.list-group-item-action');
            allButtons.forEach(btn => btn.classList.remove('active'));

            // Tenta encontrar o botão clicado para ativar. 
            // Nota: Se clicou no mobile, precisamos ativar visualmente o desktop também e vice-versa, 
            // mas para simplificar, vamos ativar apenas o elemento clicado.
            element.classList.add('active');

            // Fecha o menu mobile se estiver aberto
            const offcanvasEl = document.getElementById('mobileMenu');
            const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvasInstance) {
                offcanvasInstance.hide();
            }
        }
    </script>

</body>

</html>