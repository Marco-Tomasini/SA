USE SmartCitiesV7;

-- Estações
INSERT INTO estacao (id_estacao, nome, localizacao) VALUES
(1, 'Estação Central', 'Av. Brasil, 1000, Centro'),
(2, 'Estação Norte', 'R. das Flores, 200, Bairro Norte'),
(3, 'Estação Sul', 'Av. das Nações, 450, Bairro Sul'),
(4, 'Estação Leste', 'R. das Palmeiras, 10, Bairro Leste'),
(5, 'Estação Oeste', 'Praça do Comércio, s/n, Bairro Oeste'),
(6, 'Estação Aeroporto', 'Rod. Internacional, Km 3, Aeroporto');

-- Rotas
INSERT INTO rota (id_rota, nome, descricao) VALUES
(1, 'Linha Central', 'Conecta Estação Central a Estação Aeroporto via Norte e Leste'),
(2, 'Linha Sul-Oeste', 'Rota que liga Estação Sul a Estação Oeste, serviço regional'),
(3, 'Linha Circular', 'Trajeto circular com paradas em Central -> Norte -> Sul -> Oeste -> Central');

-- Segmentos de rota (ordem respeita ida na rota)
INSERT INTO segmento_rota (id_segmento_rota, id_rota_fk, ordem, id_estacao_origem, id_estacao_destino, distancia_km) VALUES
(1, 1, 1, 1, 2, 5.20),   -- Central -> Norte
(2, 1, 2, 2, 4, 7.40),   -- Norte -> Leste
(3, 1, 3, 4, 6, 12.50),  -- Leste -> Aeroporto
(4, 2, 1, 3, 5, 9.00),   -- Sul -> Oeste
(5, 2, 2, 5, 1, 11.20),  -- Oeste -> Central
(6, 3, 1, 1, 2, 5.20),   -- Circular segmentos reutilizados
(7, 3, 2, 2, 3, 8.00),
(8, 3, 3, 3, 5, 9.00),
(9, 3, 4, 5, 1, 11.20);

-- Trens
INSERT INTO trem (id_trem, identificador, modelo, capacidade_passageiros, capacidade_carga_kg, status_trem, quilometragem, tempo_uso, ultima_manutencao, consumo_kwh) VALUES
(1, 'TR-1001', 'Xpress-200', 200, 5000, 'Operacional', 12500.75, 3200.50, '2025-10-25 09:30:00', 250.50),
(2, 'TR-1002', 'Xpress-200', 200, 4500, 'Operacional', 9800.00, 2800.25, '2025-09-15 14:00:00', 245.00),
(3, 'TR-2001', 'CargoMax-50', 50, 12000, 'Em manutenção', 45200.10, 7200.00, '2025-10-01 08:00:00', 500.00),
(4, 'TR-3001', 'Regional-Eco', 120, 3000, 'Operacional', 6500.30, 1500.75, '2025-08-20 11:15:00', 180.75);

-- Usuários
INSERT INTO usuario (id_usuario, nome, email, senha, perfil, CPF, data_nascimento, endereco, contato, imagem_usuario) VALUES
(1, 'Ana Costa', 'ana.costa@smartcity.com', 'pbkdf2$10000$exemplohash1', 'Controlador', '123.456.789-09', '1985-03-12', 'Av. Central, 123, Centro', '554799900001', 'default.png'),
(2, 'Bruno Lima', 'bruno.lima@smartcity.com', 'pbkdf2$10000$exemplohash2', 'Engenheiro', '987.654.321-00', '1979-07-22', 'R. das Acácias, 45, Norte', '554799900002', 'default.png'),
(3, 'Carla Souza', 'carla.souza@smartcity.com', 'pbkdf2$10000$exemplohash3', 'Planejador', '111.222.333-44', '1990-01-05', 'Praça Azul, 10, Sul', '554799900003', 'default.png'),
(4, 'Diego Pereira', 'diego.pereira@smartcity.com', 'pbkdf2$10000$exemplohash4', 'Maquinista', '222.333.444-55', '1988-11-30', 'Av. do Trabalho, 210, Oeste', '554799900004', 'default.png'),
(5, 'Elisa Ramos', 'elisa.ramos@smartcity.com', 'pbkdf2$10000$exemplohash5', 'Gerente', '333.444.555-66', '1975-06-15', 'R. Nova, 78, Leste', '554799900005', 'default.png'),
(6, 'Felipe Nunes', 'felipe.nunes@smartcity.com', 'pbkdf2$10000$exemplohash6', 'Engenheiro', '444.555.666-77', '1992-12-02', 'Alameda Verde, 12, Centro', '554799900006', 'default.png');

-- Sensores (tipo = 'Trilho' ou 'Trem')
INSERT INTO sensor (id_sensor, tipo, descricao) VALUES
(1, 'Trilho', 'Sensor de peso - segmento 1'),
(2, 'Trilho', 'Sensor temperatura - segmento 2'),
(3, 'Trilho', 'Sensor presença - segmento 3'),
(4, 'Trem', 'Sensor motor - TR-1001'),
(5, 'Trem', 'Sensor freio - TR-2001'),
(6, 'Trilho', 'Sensor temperatura - segmento 4');

-- Sensores ligados a segmentos de trilho
INSERT INTO sensor_trilho (id_sensor_trilho, id_sensor_fk, id_segmento_fk, tipo_sensor) VALUES
(1, 1, 1, 'Peso'),
(2, 2, 2, 'Temperatura'),
(3, 3, 3, 'Presenca'),
(4, 6, 4, 'Temperatura');

-- Sensores instalados em trens
INSERT INTO sensor_trem (id_sensor_trem, id_sensor_fk, id_trem_fk, tipo_sensor) VALUES
(1, 4, 1, 'Motor'),
(2, 5, 3, 'Freio');

-- Viagens (note o campo nome_viagem e status_viagem)
INSERT INTO viagem (id_viagem, id_trem_fk, id_rota_fk, data_partida, data_chegada_previsao, data_chegada, status_viagem, nome_viagem) VALUES
(1, 1, 1, '2025-11-01 06:00:00', '2025-11-01 07:30:00', '2025-11-01 07:28:00', 'Ok', 'Viagem Matinal TR-1001'),
(2, 2, 3, '2025-11-02 09:00:00', '2025-11-02 10:45:00', NULL, 'Atraso', 'Serviço Circular TR-1002'),
(3, 3, 2, '2025-10-30 14:00:00', '2025-10-30 16:00:00', '2025-10-30 16:00:00', 'Reparo', 'Fretamento Carga TR-2001'),
(4, 4, 2, '2025-11-03 12:30:00', '2025-11-03 14:00:00', '2025-11-03 13:59:00', 'Ok', 'Regional TR-3001');

-- Leituras de sensores
INSERT INTO leitura_sensor (id_leitura, id_sensor_fk, data_hora, valor, unidade) VALUES
(1, 1, '2025-11-01 06:05:00', 12000.00, 'kg'),
(2, 2, '2025-11-01 06:10:00', 36.50, 'Celsius'),
(3, 3, '2025-11-01 06:12:00', 1.00, 'presenca'), -- 1 = detectado
(4, 4, '2025-11-01 06:20:00', 75.20, 'kW'),
(5, 5, '2025-10-30 14:30:00', 0.00, 'kW'),
(6, 6, '2025-11-03 12:35:00', 34.10, 'Celsius');

-- Ordens de manutenção
INSERT INTO ordem_manutencao (id_ordem, id_trem_fk, data_abertura, data_fechamento, tipo, descricao, status_manutencao) VALUES
(1, 3, '2025-10-01 09:00:00', '2025-10-10 17:30:00', 'Corretiva', 'Substituição de conjunto de freio traseiro', 'Fechada'),
(2, 1, '2025-10-25 10:00:00', NULL, 'Preventiva', 'Revisão preventiva programada - motor e controles', 'Em andamento'),
(3, 2, '2025-09-12 08:00:00', '2025-09-13 12:00:00', 'Preventiva', 'Verificação de portas e sistemas de segurança', 'Fechada');

-- Alertas
INSERT INTO alerta (id_alerta, tipo, mensagem, data_hora, criticidade, id_viagem_fk) VALUES
(1, 'Atraso', 'Viagem TR-1002 acumulando 15 min de atraso devido a tráfego na via', '2025-11-02 09:20:00', 'Média', 2),
(2, 'Falha Técnica', 'Possível falha no sistema de freios do TR-2001 durante viagem de carga', '2025-10-30 15:10:00', 'Alta', 3),
(3, 'Segurança', 'Detector de presença detectou obstrução no segmento 3', '2025-11-01 06:12:00', 'Alta', 1);

-- Alertas por usuário (lido = false por padrão)
INSERT INTO alerta_usuario (id_alerta_fk, id_usuario_fk, lido) VALUES
(1, 1, FALSE),
(1, 5, FALSE),
(2, 2, FALSE),
(3, 1, TRUE),
(3, 4, FALSE);

-- Relatórios
INSERT INTO relatorios (id_relatorio, data_relatorio, eficiencia_energetica, taxa_pontualidade, causas_atraso, custo_medio_manutencao) VALUES
(1, '2025-10-31', 82.50, 91.20, 'Tráfego na via, pequenas falhas elétricas', 12500.00),
(2, '2025-09-30', 79.40, 88.75, 'Manutenção corretiva em vagões de carga', 15800.00);

