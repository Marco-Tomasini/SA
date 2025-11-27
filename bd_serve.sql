-- ==========================================================
-- SCRIPT CORRIGIDO PARA INFINITYFREE (COM SUPORTE A ACENTOS)
-- ==========================================================

-- 1. Configurações Iniciais
SET NAMES 'utf8mb4';
SET FOREIGN_KEY_CHECKS = 0; -- Desativa verificação para poder recriar as tabelas
SET time_zone = '-03:00';   -- Ajusta fuso horário (opcional)

-- 2. Ajusta o banco de dados atual para aceitar acentos
-- (Substitua o nome do banco abaixo pelo seu nome real do InfinityFree, ex: if0_40538950_smartcitiesv11)
-- ALTER DATABASE nome_do_seu_banco CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 3. Limpeza (Remove tabelas antigas para evitar erros de "Table already exists")
DROP TABLE IF EXISTS alerta_usuario, alerta, ordem_manutencao, sensor_data, sensor, viagem, segmento_rota, rota, usuario, trem, estacao, relatorios;

-- ===========================
-- TABELAS PRINCIPAIS
-- ===========================

CREATE TABLE estacao (
    id_estacao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    localizacao VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE trem (
    id_trem INT AUTO_INCREMENT PRIMARY KEY,
    identificador VARCHAR(50) NOT NULL,
    modelo VARCHAR(50),
    capacidade_passageiros INT,
    capacidade_carga_kg INT,
    status_trem ENUM ('Operacional', 'Manutenção', 'Fora de Serviço') DEFAULT 'Operacional',
    quilometragem DECIMAL(10,2) DEFAULT 0,
    ultima_manutencao DATETIME
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('Controlador', 'Engenheiro', 'Planejador', 'Maquinista', 'Gerente') NOT NULL,
    CPF VARCHAR(14) NOT NULL,
    data_nascimento DATE NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    contato VARCHAR(12) NOT NULL,
    imagem_usuario VARCHAR(255) DEFAULT 'default.png'
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE rota (
    id_rota INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE segmento_rota (
    id_segmento_rota INT AUTO_INCREMENT PRIMARY KEY,
    id_rota_fk INT,
    ordem INT,
    id_estacao_origem INT,
    id_estacao_destino INT,
    distancia_km DECIMAL(6,2),
    FOREIGN KEY (id_rota_fk) REFERENCES rota(id_rota),
    FOREIGN KEY (id_estacao_origem) REFERENCES estacao(id_estacao),
    FOREIGN KEY (id_estacao_destino) REFERENCES estacao(id_estacao)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE viagem (
    id_viagem INT AUTO_INCREMENT PRIMARY KEY,
    id_trem_fk INT,
    id_rota_fk INT,
    data_partida DATETIME,
    data_chegada_previsao DATETIME,
    data_chegada DATETIME,
    status_viagem ENUM('Ok', 'Revisão', 'Reparo', 'Atraso') NOT NULL DEFAULT 'Ok',
    nome_viagem VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_trem_fk) REFERENCES trem(id_trem),
    FOREIGN KEY (id_rota_fk) REFERENCES rota(id_rota)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- SENSORES
-- ===========================

CREATE TABLE sensor (
    id_sensor INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('S1', 'S2', 'S3', 'trem') NOT NULL,
    topico VARCHAR(255) NOT NULL,
    descricao VARCHAR(100)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE sensor_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sensor_id INT,
    sensor_type VARCHAR(50) NOT NULL,
    topico VARCHAR(255) NOT NULL,
    valor INT NOT NULL,
    received_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sensor_id) REFERENCES sensor(id_sensor)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- MANUTENÇÃO
-- ===========================

CREATE TABLE ordem_manutencao (
    id_ordem INT AUTO_INCREMENT PRIMARY KEY,
    id_trem_fk INT,
    data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_fechamento DATETIME DEFAULT NULL,
    tipo ENUM('Preventiva', 'Corretiva'),
    descricao TEXT,
    status_manutencao ENUM('Aberta', 'Em andamento', 'Fechada'),
    FOREIGN KEY (id_trem_fk) REFERENCES trem(id_trem)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- ALERTAS
-- ===========================

CREATE TABLE alerta (
    id_alerta INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('Atraso', 'Falha Técnica', 'Segurança'),
    mensagem TEXT,
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    criticidade ENUM('Baixa', 'Média', 'Alta'),
    id_viagem_fk INT,
    FOREIGN KEY (id_viagem_fk) REFERENCES viagem(id_viagem)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE alerta_usuario (
    id_alerta_fk INT,
    id_usuario_fk INT,
    lido BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (id_alerta_fk, id_usuario_fk),
    FOREIGN KEY (id_alerta_fk) REFERENCES alerta(id_alerta),
    FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- RELATÓRIOS
-- ===========================

CREATE TABLE relatorios (
    id_relatorio INT AUTO_INCREMENT PRIMARY KEY,
    data_relatorio DATE,
    eficiencia_energetica DECIMAL(10,2),
    taxa_pontualidade DECIMAL(5,2),
    causas_atraso TEXT,
    custo_medio_manutencao DECIMAL(10,2)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Reativa a segurança de chaves
SET FOREIGN_KEY_CHECKS = 1;