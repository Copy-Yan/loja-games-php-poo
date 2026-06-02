
-- Adicionar Stardew Valley como exemplo real
-- Execute isto no phpMyAdmin após importar o gamestormy.sql principal

USE gamestormy;

-- Adicionar desenvolvedora e publicadora reais se não existirem
INSERT INTO Desenvolvedoras (nome, data_fundacao, pais) VALUES
('ConcernedApe', '2012-01-01', 'EUA')
ON DUPLICATE KEY UPDATE nome=nome;

INSERT INTO Publicadoras (nome, pais) VALUES
('ConcernedApe', 'EUA'),
('Chucklefish', 'Reino Unido')
ON DUPLICATE KEY UPDATE nome=nome;

-- Pegar os IDs
SET @dev_id = (SELECT id_desenvolvedora FROM Desenvolvedoras WHERE nome = 'ConcernedApe' LIMIT 1);
SET @pub_id = (SELECT id_publicadora FROM Publicadoras WHERE nome = 'ConcernedApe' LIMIT 1);

-- Adicionar Stardew Valley
INSERT INTO Jogos (id_desenvolvedora, id_publicadora, titulo, descricao, preco, data_lancamento, classificacao_etaria, tamanho_download, requisitos_minimos, requisitos_recomendados, capa, tag, nota) 
VALUES (
    COALESCE(@dev_id, 1),
    COALESCE(@pub_id, 1),
    'Stardew Valley',
    'Você herdou a antiga fazenda do seu avô em Stardew Valley. Armado com ferramentas de segunda mão e algumas moedas, você parte para iniciar sua nova vida. Consegue aprender a viver da terra e transformar esses campos abandonados em um lar próspero? Cultive safras, crie animais, pesque, mine, faça amizades com os moradores da cidade e até case-se. Com mais de 50 horas de conteúdo e atualizações constantes, Stardew Valley é uma experiência relaxante e viciante que conquistou mais de 50 milhões de jogadores ao redor do mundo.',
    24.99,
    '2016-02-26',
    'L',
    0.5,
    'Windows 7 ou superior, Processador 2 GHz (Intel Core 2 Duo), 2 GB RAM, Placa de vídeo com 256MB VRAM e Shader Model 3.0+, 500 MB espaço em disco',
    'Windows 10, Processador Intel Core i3 ou superior, 4 GB RAM, Placa de vídeo com 512MB VRAM, SSD recomendado',
    '#5a8c3a',
    'Indie',
    9.8
)
ON DUPLICATE KEY UPDATE 
    titulo=VALUES(titulo), 
    descricao=VALUES(descricao), 
    preco=VALUES(preco),
    capa=VALUES(capa),
    tag=VALUES(tag),
    nota=VALUES(nota);

-- Vincular categorias (Simulação, RPG, Indie)
SET @jogo_id = (SELECT id_jogo FROM Jogos WHERE titulo = 'Stardew Valley' LIMIT 1);
SET @cat_sim = (SELECT id_categoria FROM Categorias WHERE nome = 'Simulação' LIMIT 1);
SET @cat_rpg = (SELECT id_categoria FROM Categorias WHERE nome = 'RPG' LIMIT 1);
SET @cat_indie = (SELECT id_categoria FROM Categorias WHERE nome = 'Indie' LIMIT 1);

INSERT INTO Jogos_categorias (id_jogo, id_categoria) VALUES
(@jogo_id, COALESCE(@cat_sim, 7)),
(@jogo_id, COALESCE(@cat_rpg, 3)),
(@jogo_id, COALESCE(@cat_indie, 10))
ON DUPLICATE KEY UPDATE id_jogo=id_jogo;

-- Vincular plataformas (PC, PlayStation, Xbox, Switch, Mobile)
SET @plat_pc = (SELECT id_plataforma FROM Plataformas WHERE nome = 'PC' LIMIT 1);
SET @plat_ps5 = (SELECT id_plataforma FROM Plataformas WHERE nome = 'PlayStation 5' LIMIT 1);
SET @plat_xbox = (SELECT id_plataforma FROM Plataformas WHERE nome = 'Xbox Series X' LIMIT 1);
SET @plat_switch = (SELECT id_plataforma FROM Plataformas WHERE nome = 'Nintendo Switch' LIMIT 1);
SET @plat_mobile = (SELECT id_plataforma FROM Plataformas WHERE nome = 'Mobile' LIMIT 1);

INSERT INTO Jogos_plataformas (id_jogo, id_plataforma) VALUES
(@jogo_id, COALESCE(@plat_pc, 1)),
(@jogo_id, COALESCE(@plat_ps5, 2)),
(@jogo_id, COALESCE(@plat_xbox, 3)),
(@jogo_id, COALESCE(@plat_switch, 4)),
(@jogo_id, COALESCE(@plat_mobile, 5))
ON DUPLICATE KEY UPDATE id_jogo=id_jogo;
