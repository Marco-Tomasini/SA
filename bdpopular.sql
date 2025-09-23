INSERT INTO rota (nome, chegada) VALUES
('r1 Vila Nova', 'Chega em 16 minutos, chega entre 10:30 e 10:46'),
('r2 Iririú', 'Chega em 16 minutos, chega entre 10:30 e 10:46'),
('r3 Tupy', 'Chega em 16 minutos, chega entre 10:30 e 10:46'),
('r4 Guanabara', 'Chega em 16 minutos, chega entre 10:30 e 10:46'),
('r5 Itinga', 'Chega em 10 minutos, chega entre 10:30 e 10:40'),
('r6 Godoy', 'Chega em 10 minutos, chega entre 10:30 e 10:40'),
('r7 Bala', 'Chega em 10 minutos, chega entre 10:30 e 10:40'),
('r8 Tomasini', 'Chega em 10 minutos, chega entre 10:30 e 10:40');

INSERT INTO alerta (mensagem,alerta) VALUES
('Atraso', 'Tráfego em direção a rota R7-Ronaldo. Estou no meio de trânsito, existe uma grande possibilidade de a linha atrasar.', NOW(), 'Alta', NULL),
('Segurança', 'Trem precisa de limpeza. Um passageiro teve uma situação complicada, o trem vai precisar ser enviado para a limpeza.', NOW(), 'Média', NULL),
('Falha Técnica', 'O Trem da rota R3-tupy está fora de serviço. Em meio ao percurso o trem estragou, e será necessária uma revisão.', NOW(), 'Alta', NULL);
