-- CORRECAO: Adicionar colunas faltantes na tabela Jogos
-- Execute este script no phpMyAdmin se ja tiver criado o banco

USE gamestormy;

ALTER TABLE Jogos
    ADD COLUMN IF NOT EXISTS capa VARCHAR(255) DEFAULT NULL AFTER requisitos_recomendados,
    ADD COLUMN IF NOT EXISTS tag VARCHAR(50) DEFAULT 'Jogo' AFTER capa,
    ADD COLUMN IF NOT EXISTS nota DECIMAL(3,1) DEFAULT 0.0 AFTER tag;

-- Atualizar jogos existentes com dados de exemplo se estiverem vazios
UPDATE Jogos SET capa = '#ff85c2', tag = 'Oferta da semana', nota = 9.5 WHERE titulo LIKE '%Storm%' OR id_jogo = 1;
UPDATE Jogos SET capa = '#7c41b1', tag = 'Novo lancamento', nota = 9.3 WHERE titulo LIKE '%Realm%' OR id_jogo = 2;
UPDATE Jogos SET capa = '#00bc5e', tag = 'Promocao', nota = 8.9 WHERE titulo LIKE '%Co-op%' OR id_jogo = 3;
UPDATE Jogos SET capa = '#603018', tag = 'Indie', nota = 9.5 WHERE titulo LIKE '%Pixel%' OR id_jogo = 4;
UPDATE Jogos SET capa = '#183060', tag = 'Acao', nota = 8.4 WHERE titulo LIKE '%NightFire%' OR id_jogo = 5;
UPDATE Jogos SET capa = '#604018', tag = 'Cozy', nota = 9.1 WHERE titulo LIKE '%Farm%' OR id_jogo = 6;
UPDATE Jogos SET capa = '#1a4060', tag = 'Estrategia', nota = 8.7 WHERE titulo LIKE '%Iron%' OR id_jogo = 7;
UPDATE Jogos SET capa = '#502060', tag = 'Plataforma', nota = 9.0 WHERE titulo LIKE '%Jump%' OR id_jogo = 8;
UPDATE Jogos SET capa = '#205050', tag = 'Terror', nota = 8.9 WHERE titulo LIKE '%Dark%' OR id_jogo = 9;
UPDATE Jogos SET capa = '#402050', tag = 'Romance', nota = 9.3 WHERE titulo LIKE '%Heart%' OR id_jogo = 10;
UPDATE Jogos SET capa = '#305020', tag = 'Puzzle', nota = 8.6 WHERE titulo LIKE '%Wood%' OR id_jogo = 11;
UPDATE Jogos SET capa = '#4a1a6a', tag = 'RPG', nota = 9.1 WHERE titulo LIKE '%Violet%' OR id_jogo = 12;
UPDATE Jogos SET capa = '#1a4a2a', tag = 'Esporte', nota = 8.5 WHERE titulo LIKE '%Velocity%' OR id_jogo = 13;
UPDATE Jogos SET capa = '#4a2a1a', tag = 'Estrategia', nota = 8.8 WHERE titulo LIKE '%Terraform%' OR id_jogo = 14;
UPDATE Jogos SET capa = '#1a2a4a', tag = 'MMORPG', nota = 9.4 WHERE titulo LIKE '%Nexus%' OR id_jogo = 15;
UPDATE Jogos SET capa = '#3a1a4a', tag = 'Roguelike', nota = 9.0 WHERE titulo LIKE '%LootBox%' OR id_jogo = 16;
UPDATE Jogos SET capa = '#1a3a4a', tag = 'Card Game', nota = 8.3 WHERE titulo LIKE '%Deck%' OR id_jogo = 17;
UPDATE Jogos SET capa = '#4a3a1a', tag = 'Acao', nota = 8.9 WHERE titulo LIKE '%Blade%' OR id_jogo = 18;
UPDATE Jogos SET capa = '#2a4a3a', tag = 'Cozy', nota = 9.2 WHERE titulo LIKE '%Mushroom%' OR id_jogo = 19;
UPDATE Jogos SET capa = '#4a2a3a', tag = 'Terror', nota = 8.7 WHERE titulo LIKE '%Escape%' OR id_jogo = 20;
UPDATE Jogos SET capa = '#3a4a1a', tag = 'Ritmo', nota = 9.0 WHERE titulo LIKE '%Beat%' OR id_jogo = 21;
