# Descrição

Snippet PHP para receber mensagens de um broker MQTT (cliente leve). Projetado para uso didático: os arquivos `index.php` e `get_messages.php` mostram como configurar e ler mensagens do broker.

---

## Arquivos necessários

- `phpMQTT.php` — classe cliente MQTT (incluir no projeto).
  - Nota: se encontrar `pqpMQTT.php`, trata-se provavelmente de um erro de digitação; o arquivo correto é `phpMQTT.php`.
- `cacert.pem` — bundle de CAs para conexões TLS (colocar na mesma pasta do projeto ou apontar o caminho em `$cafile`).

---

## Exemplo rápido (já incluido no projeto)

1. Coloque `phpMQTT.php` e `cacert.pem` na pasta do projeto (por exemplo, a mesma de `index.php`).
2. Atualize `get_messages.php`:
   - `$server` — endereço do broker (ex.: `hivemq.com`).
   - `$port` — porta TLS (ex.: `8883`).
   - `$topic` — tópico a assinar.
   - `$username` / `$password` — credenciais do dispositivo, se aplicável.
   - `$cafile` — caminho para `cacert.pem` (ex.: `__DIR__ . "/cacert.pem"`).
3. `index.php` faz polling a cada segundo chamando `get_messages.php` e exibe a última mensagem.

---

## Como funciona (resumo)

- `get_messages.php` cria um cliente `phpMQTT`, conecta ao broker (usando TLS quando `cacert.pem` é informado), subscreve o tópico e aguarda ~2 segundos para retornar a última mensagem recebida.
- `index.php` chama `get_messages.php` via fetch e atualiza a interface.

---

## Boas práticas / notas

- Verifique se a porta do broker está acessível (firewall/NAT).
- Para TLS, mantenha `cacert.pem` atualizado e use um hostname válido (verificação de peer habilitada).
- Ajuste o tempo de escuta em `get_messages.php` conforme a necessidade (atualmente 2s).
- Em produção, prefira um worker persistente em vez de abrir uma conexão a cada requisição HTTP.

---
