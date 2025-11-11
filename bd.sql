CREATE DATABASE SmartCitiesV9;

USE SmartCitiesV9;

-- ===========================
-- TABELAS PRINCIPAIS
-- ===========================

CREATE TABLE estacao (
    id_estacao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    localizacao VARCHAR(255) NOT NULL
);

CREATE TABLE trem (
    id_trem INT AUTO_INCREMENT PRIMARY KEY,
    identificador VARCHAR(50) NOT NULL,
    modelo VARCHAR(50),
    capacidade_passageiros INT,
    capacidade_carga_kg INT,
    status_trem ENUM ('Operacional', 'Manutenção', 'Fora de Serviço') DEFAULT 'Operacional',
    quilometragem DECIMAL(10,2) DEFAULT 0,
    ultima_manutencao DATETIME
);

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
);

CREATE TABLE rota (
    id_rota INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

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
);

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
);

-- ===========================
-- SENSORES
-- ===========================

CREATE TABLE sensor (
    id_sensor INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('Trilho', 'Trem'),
    descricao VARCHAR(100)
);

CREATE TABLE sensor_trilho (
    id_sensor_trilho INT AUTO_INCREMENT PRIMARY KEY,
    id_sensor_fk INT,
    id_segmento_fk INT,
    tipo_sensor ENUM('Peso', 'Temperatura', 'Presenca'),
    FOREIGN KEY (id_sensor_fk) REFERENCES sensor(id_sensor),
    FOREIGN KEY (id_segmento_fk) REFERENCES segmento_rota(id_segmento_rota)
);

CREATE TABLE sensor_trem (
    id_sensor_trem INT AUTO_INCREMENT PRIMARY KEY,
    id_sensor_fk INT,
    id_trem_fk INT,
    tipo_sensor ENUM('Motor', 'Freio'),
    FOREIGN KEY (id_sensor_fk) REFERENCES sensor(id_sensor),
    FOREIGN KEY (id_trem_fk) REFERENCES trem(id_trem)
);

CREATE TABLE leitura_sensor (
    id_leitura INT AUTO_INCREMENT PRIMARY KEY,
    id_sensor_fk INT,
    data_hora DATETIME,
    valor DECIMAL(10,2),
    unidade VARCHAR(20),
    FOREIGN KEY (id_sensor_fk) REFERENCES sensor(id_sensor)
);

-- ===========================
-- MANUTENÇÃO
-- ===========================

CREATE TABLE ordem_manutencao (
    id_ordem INT AUTO_INCREMENT PRIMARY KEY,
    id_trem_fk INT,
    data_abertura DATETIME,
    data_fechamento DATETIME,
    tipo ENUM('Preventiva', 'Corretiva'),
    descricao TEXT,
    status_manutencao ENUM('Aberta', 'Em andamento', 'Fechada'),
    FOREIGN KEY (id_trem_fk) REFERENCES trem(id_trem)
);

-- ===========================
-- ALERTAS
-- ===========================

CREATE TABLE alerta (
    id_alerta INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('Atraso', 'Falha Técnica', 'Segurança'),
    mensagem TEXT,
    data_hora DATETIME,
    criticidade ENUM('Baixa', 'Média', 'Alta'),
    id_viagem_fk INT,
    FOREIGN KEY (id_viagem_fk) REFERENCES viagem(id_viagem)
);

CREATE TABLE alerta_usuario (
    id_alerta_fk INT,
    id_usuario_fk INT,
    lido BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (id_alerta_fk, id_usuario_fk),
    FOREIGN KEY (id_alerta_fk) REFERENCES alerta(id_alerta),
    FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
);

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
);

ALTER TABLE alerta modify data_hora DATETIME DEFAULT CURRENT_TIMESTAMP;