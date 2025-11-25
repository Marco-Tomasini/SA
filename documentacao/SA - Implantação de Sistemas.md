# Planejamento de Implantação de Sistemas

## **Identificação do Projeto:**

Nome do Sistema: **Smart Cities**

Equipe responsável: **Marco A. Tomasini, Carlos Eduardo, Enzo Caetano, Brayan Godoy**

## **Sobre o Sistema:**

* MVP web em PHP para gestão ferroviária.   
* Funcionalidades: Autenticação de Usuário, Proteção de Abas, Dashboard com dados reais, Estrutura Organizada, Conexão ao Banco de Dados, Navegação intuitiva.   
* Utilização da metodologia Mobile First de forma responsiva. 

## **Tecnologias Utilizadas:** 

* **Back-end:** PHP   
* **Front-end:** HTML, CSS, JavaScript, Bootstrap  
* **Banco de Dados:** MySQL (via phpMyAdmin)   
* **Servidor Local:** XAMPP ou similar 

## **Estrutura:** 

**assets/** : Recursos estáticos (imagens, ícones). 

**public/** : Arquivos PHP (páginas, parciais). 

**scripts/** : Arquivos JavaScript. 

**styles/** : Arquivos CSS. 

**bd.sql** : Script SQL para criação da estrutura do banco de dados e inserção de dados de teste. 

**index.php** : Arquivo principal (tela de login).

## **Instalação e Execução (Somente Local):** 

1\. Servidor Web: XAMPP, WAMP ou MAMP (ou similar) com PHP e MySQL. 

2\. Clone o Repositório: **git clone https://github.com/Marco-Tomasini/SA.git** 

3\. Configuração do Banco de Dados: Criar DB MySQL a partir de **bd.sql** no phpMyAdmin. 

4\. Configuração da Conexão: Ajustar credenciais em **public/db.php** . 

5\. Acesso à Aplicação: Mover SA para htdocs (XAMPP), acessar 

**http://localhost/SA/public/index.php .** 

## **Checklist de Implantação:**

| Etapa  | Descrição  | Status  |
| ----- | :---- | ----- |
| **Pré \- implantação** |  |  |
| 1\. Análise de  Requisitos | Revisar e confirmar todos os requisitos do sistema. |  |
| 2\. Preparação  do Ambiente | Configurar o  servidor e o banco de dados de  acordo com os requisitos mínimos. |  |
| 3\. Backup de Dados  Existentes | Realizar backup completo de dados existentes. |  |
| 4\. Testes de  Integração | Realizar testes para garantir que o sistema se integre corretamente com outros sistemas (como conexão com ESP32 e sensores). |  |
| **Implantação** |  |  |
| 6\. Instalação do Sistema | Instalar o código fonte e as dependências. |  |
| 7\. Configuração do BD | Executar SQL para criação do banco de dados e população  inicial. |  |
| 8\. Configuração de Acesso | Configurar credenciais de acesso ao banco de dados e permissões de cada usuário. |  |
| 9\. Testes  | Realizar testes funcionais e de aceitação. |  |
| **Pós implantação** |  |  |
| 10\. Monitoramento | Monitorar o desempenho do sistema e identificar possíveis problemas. |  |
| 11\. Suporte e Manutenção | Canais de suporte e plano de manutenção contínua devem ser criados. |  |
| 12\. Documentação  | Atualizar toda a documentação com base na implantação e resultados obtidos.  |  |

## **Análise de Riscos e Medidas Preventivas**

| Risco Possível | Impacto Esperado | Medidas de Prevenção | Plano de Ação |
| ----- | ----- | ----- | ----- |
| **Falha na Instalação do Sistema** | Sistema não  operacional, atraso na implantação. | Documentação  detalhada do passo a passo. | Executar o plano de rollback para  restaurar o ambiente anterior. |
| **Problemas de  Conectividade com o Banco de Dados** | Sistema não  consegue acessar dados, funcionalidades comprometidas. | Verificar  configurações de  rede e credenciais antes da  implantação. | Revisar  configurações de  **public/db.php** ;  verificar o status do servidor MySQL. |
| **Perda de Dados** | Dados corrompidos ou inacessíveis. | Backup completo do banco de dados  antes da  implantação; | Restaurar o banco de dados a partir do backup mais recente. |
| **Vulnerabilidades de Segurança** | Acesso não autorizado, vazamento de dados. | Revisão de código; uso de senhas fortes e permissões bem definidas. | Aplicação de patches de segurança. |
| **Erro Humano durante a Implantação** | Configurações incorretas, passos pulados. | Checklist detalhado; dupla checagem de passos; | Executar o plano de rollback; reexecutar a implantação. |

## **Plano de Rollback (Contingência)**

**Objetivo:** Restaurar o ambiente de produção ao seu estado original e funcional. 

**Quando é Ativado:** Qualquer falha que impeça o sistema de operar conforme o esperado após a implantação. 

**Procedimento de Retorno:** 

1\. **Identificação da falha:** A equipe de monitoramento ou de implantação identifica uma falha crítica.

2\. **Comunicação:** Notificar todas as partes sobre a falha e o início do rollback. 

3\. **Desativação do Novo Sistema:** Desativar o acesso ao sistema implantado para evitar mais problemas. 

4\. **Restauração do Banco de Dados:** Restaurar o banco de dados para o estado do backup realizado antes da implantação. 

**Responsável:** Administrador de BD. 

**Ferramentas:** Ferramentas de backup/restauração do MySQL (ex: ***mysqldump , phpMyAdmin***).  
5\. **Remoção dos Arquivos do Novo Sistema:** Excluir os arquivos do sistema recém instalado do diretório de produção.

6\. **Restauração do Ambiente Anterior (se aplicável):** Se houver alterações no ambiente (ex: configurações de servidor), restaurá-las para o estado anterior.

7\. **Testes de Verificação:** Realizar testes rápidos para confirmar que o ambiente anterior está totalmente funcional e acessível. 

8\. **Comunicação Final:** Informar que o rollback foi concluído e o sistema está operacional no estado anterior. 

**Responsável pela Execução:** Gerente de Projeto e Equipe. 

**Tempo Estimado de Recuperação:** 30min \- 1hora (dependendo do tamanho do banco de dados e dependências). 

## **Requisitos do Ambiente de Produção**

| Componente | Requisito Min. | OBS |
| ----- | ----- | ----- |
| **Sistema  Operacional** | Linux ou Windows | Vai por preferência |
| **Servidor Web** | Apache 2.4 ou  Nginx 1.18 (ou similar) | Nginx oferece melhor  desempenho para conteúdo estático e PHP-FPM. Apache é mais popular |
| **PHP**  | PHP 7.4  | Versões mais recentes do PHP oferecem melhor desempenho e segurança. |
| **Banco de Dados**  | MySQL 5.7  | Versões mais recentes do MySQL oferecem melhor desempenho e recursos. |

## **Configurações de Segurança (recomendações)**

| Aspecto de Segurança | Detalhes |
| ----- | ----- |
| **Usuários e Permissões (SO)** | Criar usuários dedicados para o servidor web e banco de dados com privilégios mínimos. |
| **Usuários e Permissões (BD)** | Criar um usuário MySQL específico para a aplicação com permissões apenas para o banco de dados do sistema. |
| **Usuários e Permissões (Programa)** | O programa tem definição de acesso a funções por cargo do usuário, o que garante maior segurança. |
| **Senhas** | Utilizar senhas fortes, e criptografadas pelo sistema (via API), e complexas para todos os usuários (sistema e banco de dados). |
| **Logs** | Habilitar e monitorar logs de acesso e erro do servidor web, PHP e MySQL. |
| **Proteção contra Injeção SQL** | Validação de entrada de dados no código PHP. |
| **Segurança de Arquivo** | Arquivo **db.php** com as credenciais do banco de dados não acessíveis publicamente. |

## **Responsáveis pela Implantação:**

| Atividade | Responsável | Prazo |
| ----- | :---: | :---: |
| **Planejamento** | Marco A. Tomasini |  |
| **Configuração do servidor** | Carlos Eduardo |  |
| **Instalação do sistema** | Marco A. Tomasini & Enzo Caetano |  |
| **Testes em produção** | Enzo Caetano |  |
| **Comunicação aos usuários** | Brayan Godoy |  |

## **Contatos de Suporte:**

| Função | Nome | Contato |
| :---: | :---: | ----- |
| **Desenvolvedor Back-End** | Carlos Eduardo | carlos\_bittencourt2@estudante.sesisenai.org.br |
| **Desenvolvedor Front-End** | Enzo Caetano | enzo\_caetano@estudante.sesisenai.org.br |
| **Administrador de BD** | Marco A. Tomasini  | marco\_tomasini@estudante.sesisenai.org.br |
| **Gerente de Projeto**  |  |  |
| **Suporte Técnico Front-End**  | Brayan Godoy | brayan\_godoy@estudante.sesisenai.org.br |

# 

## **Observações Finais**

A implantação do sistema de gestão ferroviária seria realizada em fases, seguindo o check list detalhado. Inicialmente, seria feita uma **preparação do ambiente**, garantindo que todos os requisitos de hardware e software estivessem instalados e configurados conforme as especificações. Um **backup completo do ambiente existente** seria a primeira medida de segurança. Em seguida, realizaria a **instalação do código-fonte** do sistema a partir do repositório Git, seguida da **configuração do banco de dados MySQL**, incluindo a criação do banco de dados, usuário dedicado e importação dos scripts **bd.sql** e **bdpopular.sql .** 

Após a instalação, a **configuração do acesso ao bd** ( **public/db.php** ) seria ajustada. A **configuração do servidor web XAMPP** seria então aplicada, criando um virtual host. Uma série de **testes pós-implantação** seria executada para validar todas as funcionalidades, desde o login até o dashboard, e a integração com o banco de dados. Finalmente, o sistema seria liberado para uso, com um **monitoramento contínuo** para identificar e resolver rapidamente problemas de desempenho ou segurança. 