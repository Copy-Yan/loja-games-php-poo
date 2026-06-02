
-- Adicionar desenvolvedoras e publicadoras reais se não existirem
INSERT IGNORE INTO Desenvolvedoras (id_desenvolvedora, nome, data_fundacao, pais) VALUES
(11, 'ConcernedApe', '2014-01-01', 'EUA'),
(12, 'FromSoftware', '1986-11-01', 'Japão'),
(13, 'Team Cherry', '2014-01-01', 'Australia');

INSERT IGNORE INTO Publicadoras (id_publicadora, nome, pais) VALUES
(6, 'Chucklefish', 'Reino Unido'),
(7, 'Bandai Namco', 'Japão'),
(8, 'Team Cherry', 'Australia');
