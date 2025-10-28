# Projeto SA

## Descrição

Este projeto consiste no desenvolvimento de um MVP (Produto Mínimo Viável) web em PHP, focado em gestão ferroviária. O objetivo é transformar mockups e um esquema de banco de dados pré-existentes em um sistema navegável e funcional, com autenticação de usuário, proteção de rotas e um dashboard inicial que exibe dados reais do banco de dados. A interface é desenvolvida com uma abordagem Mobile First, adaptada para ser responsiva em diferentes dispositivos.

## Funcionalidades

*   **Autenticação de Usuário:** Tela de login funcional com validação no back-end, criação e encerramento de sessão.
*   **Proteção de Abas:** Páginas internas específicas são protegidas, exigindo cargos maiores para acesso.
*   **Dashboard:** Painel inicial que exibe informações reais do banco de dados relacionadas à gestão ferroviária (ex: quantidade de trens em operação, próximas partidas, alertas de manutenção).
*   **Estrutura Organizada:** Projeto organizado em pastas claras (assets, public, scripts, styles).
*   **Conexão ao Banco de Dados:** Conexão única e reutilizável ao banco de dados, com tratamento de erros.
*   **Navegação:** Fluxo de usuário intuitivo: login -> dashboard -> sidebar -> logout.
*   **Mobile First e Responsividade:** Interface adaptada para dispositivos móveis e será responsiva para outros dispositivos.

## Estrutura do Projeto

A estrutura de diretórios do projeto é organizada da seguinte forma:

```
SA/
├── assets/
│   └── icon/
│       ├── logoSite.svg
│       └── speak.svg
├── public/
│   ├── partials/
│   │   ├── footer.php
│   │   └── header.php
│   ├── create.php
│   ├── sidebar.php
│   ├── dashboard.php
│   └── db.php
├── scripts/
│   ├── script_sidebar.js
│   └── script.js
├── styles/
│   ├── style_sidebar.css
│   └── style.css
├── index.php
├── bd.sql
├── LICENSE
└── README.md
```

*   `assets/`: Contém recursos estáticos como imagens e ícones.
*   `public/`: Contém os arquivos PHP que compõem as páginas da aplicação, incluindo parciais (cabeçalho, rodapé, barra lateral).
*   `scripts/`: Armazena arquivos JavaScript para interatividade no front-end.
*   `styles/`: Contém arquivos CSS para estilização da aplicação.
*   `bd.sql`: Script SQL para criação da estrutura do banco de dados e inserção de dados de teste.
*   `index.php`: Arquivo principal que inicializa a aplicação e gerencia o fluxo inicial do usuário, sendo essa a tela de login.
*   `README.md`: Este arquivo, com informações sobre o projeto.

## Tecnologias Utilizadas

*   **Back-end:** PHP
*   **Front-end:** HTML, CSS, JavaScript
*   **Banco de Dados:** MySQL (via `phpMyAdmin`)
*   **Servidor Local:** XAMPP ou similar

## Instalação e Execução

Para configurar e executar o projeto localmente, siga os passos abaixo:

1.  **Servidor Web:** Certifique-se de ter um ambiente de servidor web local (como XAMPP, WAMP ou MAMP) instalado e configurado com PHP e MySQL.
2.  **Clone o Repositório:**

    ```bash
    git clone https://github.com/Marco-Tomasini/SA.git
    cd SA
    ```

3.  **Configuração do Banco de Dados:**
    *   Crie um novo banco de dados MySQL, a partir do arquivo ```bd.sql```. no ```localhost:/phpmyadmin/``` (ou o caminho correspondente).

4.  **Configuração da Conexão:**
    *   O arquivo `public/db.php` é responsável pela conexão com o banco de dados. Certifique-se de que as credenciais (host, usuário, senha, nome do banco) estejam corretas para o seu ambiente local.

5.  **Acesso à Aplicação:**
    *   Mova a pasta `SA` para o diretório `htdocs` do seu XAMPP (ou equivalente).
    *   Abra seu navegador e acesse `http://localhost/SA/public/index.php` (ou o caminho correspondente à sua configuração).

## CPFHub.io API
A API [CPFHub.io](https://cpfhub.io/) é utilizada para validação e consulta de informações de CPF de forma automatizada. No nosso projeto, ela é integrada para verificar a autenticidade dos CPFs informados pelos usuários durante o cadastro, garantindo maior segurança e confiabilidade dos dados.

### Principais Características

- **Validação de CPF:** Confirma se o número informado é válido e corresponde a um CPF existente.
- **Consulta de Dados:** Permite obter informações básicas associadas ao CPF.

### Exemplo de Uso

```php
// Exemplo de requisição em PHP
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$cpf = "123.456.789-00";
$birthDate = "15/06/1990";
$apiKey = "96e10a4ccfe9d588ec0078ac93b86474cd7b358c57285f96a462a117f6511818";

$client = new Client();
$response = $client->post('https://api.cpfhub.io/api/cpf', [
    'headers' => [
        'Content-Type' => 'application/json',
        'x-api-key' => $apiKey
    ],
    'json' => [
        'cpf' => $cpf,
        'birthDate' => $birthDate
    ]
]);

$result = json_decode($response->getBody(), true);
print_r($result);
```

Consulte a [documentação oficial](https://cpfhub.io/docs) para mais detalhes.


## Contribuidores

*   Marco-Tomasini
*   Carlos-E-Bittencourt
*   caetanoenzo
*   Brayanhgodoy

## Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE).

