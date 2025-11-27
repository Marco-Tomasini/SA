USE SmartCitiesV11;

-- ===========================
-- ESTACOES
-- ===========================
INSERT INTO estacao (nome, localizacao) VALUES
('Estação Central', 'Centro - São Paulo'),
('Estação Leste', 'Zona Leste - São Paulo'),
('Estação Oeste', 'Zona Oeste - São Paulo'),
('Estação Norte', 'Zona Norte - São Paulo'),
('Estação Sul', 'Zona Sul - São Paulo');

-- ===========================
-- TRENS
-- ===========================
INSERT INTO trem (identificador, modelo, capacidade_passageiros, capacidade_carga_kg, status_trem, quilometragem, ultima_manutencao) VALUES
('TREM-001', 'Siemens Vectron', 300, 12000, 'Operacional', 50234.5, '2025-10-20 08:30:00'),
('TREM-002', 'Bombardier TRAXX', 250, 10000, 'Operacional', 40312.8, '2025-09-15 14:00:00'),
('TREM-003', 'GE Evolution', 280, 11000, 'Manutenção', 62200.0, '2025-10-28 09:45:00'),
('TREM-004', 'Alstom Coradia', 220, 8000, 'Operacional', 31210.6, '2025-10-05 11:20:00'),
('TREM-005', 'Stadler FLIRT', 310, 13000, 'Fora de Serviço', 70500.3, '2025-08-12 16:00:00');

-- ===========================
-- USUARIOS
-- ===========================
INSERT INTO usuario (nome, email, senha, perfil, CPF, data_nascimento, endereco, contato, imagem_usuario) VALUES
('Admin', 'admin@admin.admin', 'admin', 'Gerente', '13105311963', '2008-02-19', 'Av. Central, 123, Centro', '554791097470', 'default.png'),
('Icaro Botelho', 'icaro.botelho@edu.sc.senai.br', 'dandomoles', 'Gerente', '13105311963', '2002-05-06', 'Av. Central, 123, Centro', '47992214358', 'default.png'),
('Enzo Caetano', 'enzo_caetano@estudante.sesisenai.org.br', '123', 'Gerente', '13105311963', '1979-07-22', 'R. das Acácias, 45, Norte', '554791097470', 'default.png'),
('Marco Tomasini', 'marco_tomasini@estudante.sesisenai.org.br', '123', 'Gerente', '10486527930', '1990-01-05', 'Praça Azul, 10, Sul', '554799900003', 'default.png'),
('Carlos Bittencourt', 'carlos_bittencourt2@estudante.sesisenai.org.br', '123', 'Gerente', '08564946904', '1988-11-30', 'Av. do Trabalho, 210, Oeste', '554799900004', 'default.png'),
('Brayan Godoy', 'brayan_godoy@estudante.sesisenai.org.br', '123', 'Gerente', '333.444.555-66', '1975-06-15', 'R. Nova, 78, Leste', '554799900005', 'default.png');

-- ===========================
-- ROTAS
-- ===========================
INSERT INTO rota (nome, descricao) VALUES
('Linha Azul', 'Rota principal que conecta as zonas Norte e Sul.'),
('Linha Vermelha', 'Rota que conecta as zonas Leste e Oeste.'),
('Linha Verde', 'Rota expressa ligando a estação Central às zonas Norte e Sul.');

-- ===========================
-- SEGMENTOS DE ROTA
-- ===========================
INSERT INTO segmento_rota (id_rota_fk, ordem, id_estacao_origem, id_estacao_destino, distancia_km) VALUES
(1, 1, 4, 5, 18.5),
(1, 2, 5, 1, 12.7),
(2, 1, 2, 3, 20.4),
(2, 2, 3, 1, 11.9),
(3, 1, 1, 4, 15.0),
(3, 2, 4, 5, 10.2);

-- ===========================
-- VIAGENS
-- ===========================
INSERT INTO viagem (id_trem_fk, id_rota_fk, data_partida, data_chegada_previsao, data_chegada, status_viagem, nome_viagem) VALUES
(1, 1, '2025-11-06 06:00:00', '2025-11-06 06:45:00', '2025-11-06 06:47:00', 'Atraso', 'Viagem Manhã - Linha Azul'),
(2, 2, '2025-11-06 07:15:00', '2025-11-06 07:55:00', '2025-11-06 07:54:00', 'Ok', 'Viagem Matinal - Linha Vermelha'),
(3, 3, '2025-11-05 17:30:00', '2025-11-05 18:10:00', '2025-11-05 18:25:00', 'Revisão', 'Viagem Noite - Linha Verde'),
(4, 1, '2025-11-06 09:00:00', '2025-11-06 09:40:00', NULL, 'Ok', 'Viagem Teste - Linha Azul');

-- ===========================
-- SENSORES
-- ===========================
INSERT INTO sensor (tipo, topico, descricao) VALUES
('S1', 'S1/umidade', 'Sensor de umidade'),
('S1', 'S1/temperatura', 'Sensor de temperatura'),
('S1', 'S1/iluminacao', 'Sensor de iluminação'),

('S2', 'Presenca1', 'Sensor de presença em trilho'),
('S2', 'Presenca2', 'Sensor de presença em trilho'),
('S2', 'ilum', 'Sensor de iluminação'),

('S3', 'Presenca1', 'Sensor de presença em trilho'),
('S3', 'Presenca2', 'Sensor de presença em trilho'),
('S3', 'Presenca3', 'Sensor de presença em trilho'),
('S3', 'Servo1', 'Servomotor para ajuste de trilho'),
('S3', 'Servo2', 'Servomotor para ajuste de trilho'),

('trem', 'trem_Carlos', 'Verifica se trem está para frente/trás ou desligado');

-- ===========================
-- ORDEM DE MANUTENCAO
-- ===========================
INSERT INTO ordem_manutencao (id_trem_fk, data_abertura, data_fechamento, tipo, descricao, status_manutencao) VALUES
(3, '2025-10-28 10:00:00', NULL, 'Corretiva', 'Substituição do sistema de freio.', 'Em andamento'),
(5, '2025-08-12 08:00:00', '2025-08-14 18:00:00', 'Preventiva', 'Inspeção anual do motor.', 'Fechada'),
(1, '2025-10-20 08:00:00', '2025-10-21 18:00:00', 'Preventiva', 'Troca de óleo e revisão geral.', 'Fechada');

-- ===========================
-- ALERTAS
-- ===========================
INSERT INTO alerta (tipo, mensagem, data_hora, criticidade, id_viagem_fk) VALUES
('Atraso', 'Viagem Linha Azul sofreu atraso de 2 minutos devido a alta carga.', '2025-11-06 06:47:00', 'Baixa', 1),
('Falha Técnica', 'Sensor de freio reportou falha intermitente.', '2025-11-06 06:50:00', 'Média', 1),
('Segurança', 'Presença detectada em trilho não autorizado.', '2025-11-06 06:40:00', 'Alta', 1);

-- ===========================
-- RELATORIOS
-- ===========================
INSERT INTO relatorios (data_relatorio, eficiencia_energetica, taxa_pontualidade, causas_atraso, custo_medio_manutencao) VALUES
('2025-11-01', 87.5, 96.2, 'Problemas técnicos e condições climáticas.', 12500.75),
('2025-10-01', 89.2, 98.0, 'Obras de trilho e manutenção preventiva.', 11340.60),
('2025-09-01', 85.0, 92.4, 'Falhas mecânicas e congestionamento.', 13200.90);
