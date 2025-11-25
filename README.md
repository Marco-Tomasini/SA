# Projeto SA

## Descrição
MVP web em PHP para gestão ferroviária (rotas, viagens, trens, manutenção, alertas e usuários). O sistema evoluiu de mockups para um conjunto de telas funcionais com autenticação, gestão de cadastros e painel dinâmico.

## Status (Novembro/2025)
Versão inicial navegável concluída. CRUD básico para principais entidades, autenticação com sessão, hash de senha, upload de foto de perfil e integração de validação de CPF via API externa. Interface em Bootstrap + CSS próprio com abordagem mobile first.

## Funcionalidades Implementadas
- Autenticação e sessão (login/logout) com hash de senha (password_hash / password_verify).
- Controle de acesso simples por perfil (armazenado em sessão).
- Dashboard com listagem de viagens e alertas dinâmicos.
- Gestão de Usuários: cadastro, edição (dados), upload de foto de perfil.
- CRUDs parciais: Estação, Trem, Rota, Segmento de Rota, Viagem, Ordem de Manutenção, Alerta.
- Upload seguro (valida tipo, tamanho e extensão).
- Integração API CPFHub (validação de CPF) via Guzzle + script front (`validar_cpf.js`).
- Estrutura de componentes reutilizáveis (sidebar, header, footer).
- Banco relacional modelado conforme `bd.sql` + popularização opcional via `bdpopular.sql`.

## Estrutura do Projeto
```
SA/
├── assets/
│   ├── icon/ (SVG/PNG)
│   └── img/ (fotos de perfil)
├── public/
│   ├── alertas.php
│   ├── cadastrorotas.php
│   ├── create.php (usuário)
│   ├── createAlerta.php
│   ├── createEstacao.php
│   ├── createOrdemM.php
│   ├── createSegmentoRota.php
│   ├── createTrem.php
│   ├── createViagem.php
│   ├── dashboard.php
│   ├── funcionarios.php
│   ├── gestaoDeRotas.php
│   ├── listaCadastros.php
│   ├── relatorios.php
│   ├── testeAPI.php
│   ├── upload_foto.php
│   ├── db.php (conexão)
│   └── partials/
│       ├── footer.php
│       ├── header.php
│       └── sidebar.php
├── scripts/
│   ├── script.js
│   ├── script_sidebar.js
│   └── validar_cpf.js
├── src/
│   ├── Auth.php
│   ├── User.php
│   └── codigoAPI.php (exemplo de chamada API)
├── styles/
│   ├── style.css
│   └── style_sidebar.css
├── vendor/ (Composer - Guzzle)
├── bd.sql
├── bdpopular.sql
├── composer.json
├── index.php (login)
├── LICENSE
└── README.md
```

## Stack Tecnológica
- PHP 8+ (PDO para MySQL)
- MySQL
- Composer (GuzzleHTTP)
- Bootstrap 5 + CSS
- JavaScript (validações e interações básicas)

## Instalação
1. Clonar repositório:
   ```bash
   git clone https://github.com/Marco-Tomasini/SA.git
   cd SA
   ```
2. Instalar dependências Composer:
   ```bash
   composer install
   ```
3. Criar banco de dados (MySQL). Atenção ao nome: em `db.php` está `smartcitiesv9` (minúsculo). Ajuste para o mesmo padrão usado ao criar o BD.
4. Executar script base:
   - Importar `bd.sql` no phpMyAdmin.
   - Opcional: importar `bdpopular.sql` para dados de demonstração.
5. Configurar credenciais em `public/db.php` (host, usuário, senha, nome do BD).
6. Mover pasta para `htdocs` (XAMPP) ou apontar DocumentRoot equivalente.
7. Acessar: `http://localhost/SA/` (login) ou conforme estrutura local.

## Banco de Dados
Modelo inclui entidades: usuario, trem, estacao, rota, segmento_rota, viagem, sensor (+ especializações), leitura_sensor, ordem_manutencao, alerta, alerta_usuario, relatorios.

## Autenticação e Segurança
- Senhas armazenadas com `password_hash`.
- Sessões PHP (`$_SESSION`) para manter estado do usuário.
- Verificações de acesso nas páginas (`if (!isset($_SESSION['id_usuario']))`).
- Recomendado: adicionar regeneração de sessão e filtros de perfil futuro.

## Integração API CPFHub
Utiliza Guzzle para requisições. Configure a chave via variável de ambiente ou arquivo seguro (não versionado).
Exemplo simplificado:
```php
$client = new \GuzzleHttp\Client();
$response = $client->post('https://api.cpfhub.io/api/cpf', [
  'headers' => [
    'Content-Type' => 'application/json',
    'x-api-key' => getenv('CPFHUB_API_KEY')
  ],
  'json' => [ 'cpf' => $cpf, 'birthDate' => $birthDate ]
]);
$data = json_decode($response->getBody(), true);
```

## Integração MQTT (HiveMQ) – Planejada
- Ingestão em tempo real via broker HiveMQ para eventos de campo.
- Fontes: sensores de presença nos trilhos e atuadores de servomotor nos mesmos.
- Visualização: a aba Relatórios e Análises exibirá indicadores e eventos ao vivo (atualização periódica).
- Segurança e QoS: uso de TLS, usuário/senha do broker, QoS 1 e mensagens retidas quando aplicável.

## Gestão de Entidades (CRUD parcial)
| Entidade              | Tela / Script                | Observações |
|-----------------------|------------------------------|-------------|
| Usuário               | create.php / upload_foto.php | Falta recuperação de senha. |
| Trem                  | createTrem.php               | Completar edição/deleção. |
| Estação               | createEstacao.php            |             |
| Rota / Segmento       | cadastrorotas.php / createSegmentoRota.php | Relacionamento sequencial. |
| Viagem                | createViagem.php / dashboard.php | Status e previsão mostrados. |
| Ordem Manutenção      | createOrdemM.php             | Estados básicos. |
| Alerta                | createAlerta.php / alertas.php | Associação a viagem. |
| Relatórios            | relatorios.php               | Mostra Sensores e Status. |

## Contribuidores
- Marco-Tomasini
- Carlos-E-Bittencourt
- caetanoenzo
- Brayanhgodoy

## Licença
Licenciado sob [MIT](LICENSE).