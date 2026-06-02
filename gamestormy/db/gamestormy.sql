-- Banco de dados: gamestormy
-- Charset: utf8mb4

CREATE DATABASE IF NOT EXISTS gamestormy 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE gamestormy;

-- Tabela: Usuarios
CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome_usuario VARCHAR(100) NOT NULL,
    nickname VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(250) NOT NULL,
    data_nascimento DATE NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT NULL,
    status ENUM('ativo','inativo','banido') NOT NULL DEFAULT 'ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabela: Endereco
CREATE TABLE Endereco (
    id_endereco INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    rua VARCHAR(100) NOT NULL,
    numero INT NOT NULL,
    cidade VARCHAR(50) NOT NULL,
    cep VARCHAR(8) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    complemento VARCHAR(55) NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Desenvolvedoras
CREATE TABLE Desenvolvedoras (
    id_desenvolvedora INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    data_fundacao DATE NOT NULL,
    pais VARCHAR(45) NOT NULL
) ENGINE=InnoDB;

-- Tabela: Publicadoras
CREATE TABLE Publicadoras (
    id_publicadora INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    pais VARCHAR(45) NOT NULL
) ENGINE=InnoDB;

-- Tabela: Jogos
CREATE TABLE Jogos (
    id_jogo INT PRIMARY KEY AUTO_INCREMENT,
    id_desenvolvedora INT NOT NULL,
    id_publicadora INT NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    data_lancamento DATE NOT NULL,
    classificacao_etaria VARCHAR(3) NOT NULL,
    tamanho_download DECIMAL(10,2) NOT NULL,
    requisitos_minimos VARCHAR(250) NOT NULL,
    requisitos_recomendados VARCHAR(250) NOT NULL,
    capa VARCHAR(255) DEFAULT NULL,
    tag VARCHAR(50) DEFAULT 'Jogo',
    nota DECIMAL(3,1) DEFAULT 0.0,
    FOREIGN KEY (id_desenvolvedora) REFERENCES Desenvolvedoras(id_desenvolvedora),
    FOREIGN KEY (id_publicadora) REFERENCES Publicadoras(id_publicadora)
) ENGINE=InnoDB;

-- Tabela: Categorias
CREATE TABLE Categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabela: Jogos_categorias
CREATE TABLE Jogos_categorias (
    id_JogoCategoria INT PRIMARY KEY AUTO_INCREMENT,
    id_jogo INT NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Biblioteca
CREATE TABLE Biblioteca (
    id_biblioteca INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_jogo INT NOT NULL,
    data_compra DATE NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo) ON DELETE CASCADE,
    UNIQUE(id_usuario, id_jogo)
) ENGINE=InnoDB;

-- Tabela: Pedidos
CREATE TABLE Pedidos (
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    data_pedido DATE NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    status ENUM('pendente','pago','cancelado') DEFAULT 'pendente',
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Pedido_itens
CREATE TABLE Pedido_itens (
    id_item INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_jogo INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Pagamentos
CREATE TABLE Pagamentos (
    id_pagamento INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    data_pagamento DATE NOT NULL,
    metodo ENUM('cartao','pix','boleto') NOT NULL,
    status ENUM('pendente','aprovado','recusado') DEFAULT 'pendente',
    FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Avaliacoes
CREATE TABLE Avaliacoes (
    id_avaliacao INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_jogo INT NOT NULL,
    nota INT NOT NULL,
    comentario VARCHAR(500) NOT NULL,
    data_avaliacao DATE NOT NULL,
    UNIQUE (id_usuario, id_jogo),
    CHECK (nota >= 0 AND nota <= 5),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Plataformas
CREATE TABLE Plataformas (
    id_plataforma INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL
) ENGINE=InnoDB;

-- Tabela: Jogos_plataformas
CREATE TABLE Jogos_plataformas (
    id_jogo_plataformas INT PRIMARY KEY AUTO_INCREMENT,
    id_jogo INT NOT NULL,
    id_plataforma INT NOT NULL,
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo) ON DELETE CASCADE,
    FOREIGN KEY (id_plataforma) REFERENCES Plataformas(id_plataforma) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Suporte
CREATE TABLE Suporte (
    id_suporte INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    assunto VARCHAR(150) NOT NULL,
    descricao TEXT NOT NULL,
    categoria ENUM('Pagamento','Conta','Produto') NOT NULL,
    status ENUM('Aberto','Pendente','Resolvido','Fechado') NOT NULL DEFAULT 'Aberto',
    data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_fechamento DATETIME NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Suporte_mensagens
CREATE TABLE Suporte_mensagens (
    id_mensagem INT PRIMARY KEY AUTO_INCREMENT,
    id_suporte INT NOT NULL,
    id_usuario INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_suporte) REFERENCES Suporte(id_suporte) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela: Administradores
CREATE TABLE Administradores (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL UNIQUE,
    cargo ENUM('moderador','suporte','gerente','desenvolvedor','super_admin') NOT NULL DEFAULT 'moderador',
    permissao_banir BOOLEAN DEFAULT TRUE,
    permissao_editar_jogos BOOLEAN DEFAULT FALSE,
    permissao_suporte BOOLEAN DEFAULT TRUE,
    permissao_gerenciar_usuarios BOOLEAN DEFAULT FALSE,
    permissao_gerenciar_pagamentos BOOLEAN DEFAULT FALSE,
    deletar_avaliacoes BOOLEAN DEFAULT FALSE,
    gerenciar_admins BOOLEAN DEFAULT FALSE,
    ativo BOOLEAN DEFAULT TRUE,
    ultimo_login DATETIME NULL,
    criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================
-- DADOS DE EXEMPLO
-- ============================================

INSERT INTO Desenvolvedoras (nome, data_fundacao, pais) VALUES
('Storm Studios', '2010-03-15', 'Brasil'),
('Purple Realm', '2015-07-22', 'Canadá'),
('Green Game Co', '2018-01-10', 'Alemanha'),
('Tiny Craft', '2012-11-05', 'Japão'),
('NightFire Studios', '2014-09-18', 'EUA'),
('CozyDev', '2019-04-30', 'Nova Zelândia'),
('Iron Map', '2011-06-25', 'Reino Unido'),
('Purple Jump', '2016-02-14', 'Brasil'),
('DarkMind Games', '2013-08-08', 'Suécia'),
('HeartCode', '2017-12-01', 'Coreia do Sul');

INSERT INTO Publicadoras (nome, pais) VALUES
('Stormy Publishing', 'Brasil'),
('Global Games', 'EUA'),
('Indie House', 'Alemanha'),
('Pixel Arts', 'Japão'),
('NightFire Pub', 'Canadá');

INSERT INTO Categorias (nome) VALUES
('Ação'), ('Aventura'), ('RPG'), ('Tiro'), ('Terror'), ('Estratégia'),
('Simulação'), ('Esporte'), ('Cozy'), ('Indie'), ('Romance'), ('Puzzle'),
('Plataforma'), ('Visual Novel'), ('MMORPG'), ('Roguelike'), ('Card Game'), ('Ritmo');

INSERT INTO Plataformas (nome) VALUES
('PC'), ('PlayStation 5'), ('Xbox Series X'), ('Nintendo Switch'), ('Mobile');

INSERT INTO Jogos (id_desenvolvedora, id_publicadora, titulo, descricao, preco, data_lancamento, classificacao_etaria, tamanho_download, requisitos_minimos, requisitos_recomendados, capa, tag, nota) VALUES
(1, 1, 'Aventura Épica Storm', 'Uma aventura épica com gráficos incríveis e história envolvente. Explore mundos fantásticos e descubra segredos ancestrais.', 49.90, '2025-11-20', '12', 15.5, 'Intel i3, 4GB RAM, GTX 750', 'Intel i5, 8GB RAM, GTX 1060', '#ff85c2', 'Oferta da semana', 9.5),
(2, 2, 'Realm of Legends', 'Explore mundos abertos e batalhe contra inimigos desafiadores. Sistema de combate revolucionário e gráficos de última geração.', 89.90, '2026-01-15', '16', 45.2, 'Intel i5, 8GB RAM, GTX 1050', 'Intel i7, 16GB RAM, RTX 3060', '#7c41b1', 'Novo lançamento', 9.3),
(3, 3, 'Co-op Adventures', 'Multiplayer cooperativo para curtir com os amigos. Missões, raids e eventos sazonais todo mês.', 29.90, '2024-08-10', 'L', 8.3, 'Intel i3, 4GB RAM, Intel HD', 'Intel i5, 8GB RAM, GTX 1050', '#00bc5e', 'Promoção', 8.9),
(4, 4, 'Pixel Charm', 'Um indie charmoso com pixel art deslumbrante e trilha sonora relaxante.', 29.90, '2025-05-22', 'L', 2.1, 'Dual Core, 2GB RAM', 'Quad Core, 4GB RAM', '#603018', 'Indie', 9.5),
(5, 5, 'Tactical NightFire', 'Shooter tático com mapas procedurais e modo cooperativo para até 4 jogadores.', 59.90, '2025-09-01', '18', 22.0, 'Intel i5, 8GB RAM, GTX 1060', 'Intel i7, 16GB RAM, RTX 2070', '#183060', 'Ação', 8.4),
(6, 1, 'Magic Farm Cozy', 'Gerencie sua própria fazenda mágica em um mundo cheio de segredos e personagens adoráveis.', 39.90, '2025-03-12', 'L', 5.5, 'Intel i3, 4GB RAM', 'Intel i5, 8GB RAM', '#604018', 'Cozy', 9.1),
(7, 2, 'Iron Strategy', 'Estratégia em tempo real com campanhas históricas e multiplayer online.', 69.90, '2024-11-05', '12', 18.7, 'Intel i3, 4GB RAM, GTX 750', 'Intel i5, 8GB RAM, GTX 1060', '#1a4060', 'Estratégia', 8.7),
(8, 3, 'Purple Jump 2D', 'Plataforma 2D com mecânicas inovadoras e uma narrativa emocionante sobre perda e recomeço.', 44.90, '2025-07-18', 'L', 3.2, 'Dual Core, 2GB RAM', 'Quad Core, 4GB RAM', '#502060', 'Plataforma', 9.0),
(9, 4, 'Dark Victorian', 'Horror psicológico ambientado em uma mansão vitoriana cheia de mistérios e entidades sobrenaturais.', 54.90, '2025-10-31', '18', 12.4, 'Intel i5, 8GB RAM, GTX 1060', 'Intel i7, 16GB RAM, RTX 3060', '#205050', 'Terror', 8.9),
(10, 5, 'Heart Visual Novel', 'Visual novel com múltiplos finais, personagens carismáticos e decisões que mudam tudo.', 34.90, '2025-02-14', '14', 4.8, 'Dual Core, 2GB RAM', 'Quad Core, 4GB RAM', '#402050', 'Romance', 9.3),
(1, 1, 'WoodBlock Puzzle', 'Puzzle atmosférico com mecânicas de tempo e uma arte única inspirada em gravuras japonesas.', 24.90, '2024-12-01', 'L', 1.5, 'Dual Core, 2GB RAM', 'Quad Core, 4GB RAM', '#305020', 'Puzzle', 8.6),
(2, 2, 'Violet Arc RPG', 'RPG de ação com combate fluido e um mundo aberto repleto de segredos e masmorras.', 34.90, '2025-04-20', '14', 35.0, 'Intel i5, 8GB RAM, GTX 1050', 'Intel i7, 16GB RAM, RTX 3060', '#4a1a6a', 'RPG', 9.1),
(3, 3, 'Velocity Sport', 'Esporte futurista onde gravidade é opcional. Corridas em pistas suspensas no ar.', 54.90, '2025-06-15', 'L', 20.1, 'Intel i5, 8GB RAM, GTX 1060', 'Intel i7, 16GB RAM, RTX 2070', '#1a4a2a', 'Esporte', 8.5),
(7, 2, 'Terraform Strategy', 'Construa civilizações em planetas alienígenas e negocie com facções espaciais.', 24.90, '2024-09-10', '12', 8.5, 'Intel i3, 4GB RAM, GTX 750', 'Intel i5, 8GB RAM, GTX 1060', '#4a2a1a', 'Estratégia', 8.8),
(2, 2, 'Nexus Online', 'MMORPG massivo com gráficos de última geração e um mundo persistente em constante evolução.', 74.90, '2026-02-01', '16', 85.5, 'Intel i7, 16GB RAM, RTX 3060', 'Intel i9, 32GB RAM, RTX 4080', '#1a2a4a', 'MMORPG', 9.4),
(6, 1, 'LootBox Dungeon', 'Dungeon crawler cooperativo para até 4 jogadores com itens aleatórios e infinitas combinações.', 44.90, '2025-08-22', '14', 6.3, 'Intel i3, 4GB RAM, GTX 750', 'Intel i5, 8GB RAM, GTX 1060', '#3a1a4a', 'Roguelike', 9.0),
(4, 4, 'Deck Masters', 'Jogo de cartas estratégico com mais de 500 cartas únicas e torneios semanais.', 19.90, '2024-06-18', 'L', 3.5, 'Dual Core, 2GB RAM', 'Quad Core, 4GB RAM', '#1a3a4a', 'Card Game', 8.3),
(5, 5, 'BladeStorm Action', 'Hack and slash frenético com sistema de combo profundo e um arsenal de armas absurdas.', 64.90, '2025-05-05', '18', 28.0, 'Intel i5, 8GB RAM, GTX 1060', 'Intel i7, 16GB RAM, RTX 3060', '#4a3a1a', 'Ação', 8.9),
(6, 1, 'Mushroom Village', 'Viva em uma vila mágica, faça amizades com animais falantes e resolva puzzles encantadores.', 49.90, '2025-01-30', 'L', 4.2, 'Dual Core, 2GB RAM', 'Quad Core, 4GB RAM', '#2a4a3a', 'Cozy', 9.2),
(9, 4, 'Escape Horror', 'Fuga de salas de horror com IA adaptativa que aprende seus padrões de jogo.', 39.90, '2025-11-11', '18', 9.8, 'Intel i5, 8GB RAM, GTX 1060', 'Intel i7, 16GB RAM, RTX 3060', '#4a2a3a', 'Terror', 8.7),
(8, 3, 'BeatPlatform', 'Plataforma rítmica onde o nível é gerado pela música que você escolhe.', 29.90, '2025-03-25', 'L', 2.8, 'Dual Core, 2GB RAM', 'Quad Core, 4GB RAM', '#3a4a1a', 'Ritmo', 9.0);

INSERT INTO Jogos_categorias (id_jogo, id_categoria) VALUES
(1, 2), (1, 3), (2, 3), (2, 1), (3, 10), (3, 2), (4, 10), (5, 4), (5, 1), (6, 9), (6, 7),
(7, 6), (8, 13), (9, 5), (10, 11), (10, 12), (11, 12), (12, 3), (12, 1), (13, 8), (14, 6),
(15, 15), (16, 16), (17, 17), (18, 1), (19, 9), (20, 5), (21, 13), (21, 18);

INSERT INTO Jogos_plataformas (id_jogo, id_plataforma) VALUES
(1, 1), (1, 2), (2, 1), (2, 2), (2, 3), (3, 1), (3, 4), (4, 1), (4, 4), (5, 1), (5, 2), (5, 3),
(6, 1), (6, 4), (7, 1), (8, 1), (8, 4), (9, 1), (9, 2), (9, 3), (10, 1), (11, 1), (11, 4),
(12, 1), (12, 2), (12, 3), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (17, 4), (18, 1),
(18, 2), (18, 3), (19, 1), (19, 4), (20, 1), (20, 2), (21, 1), (21, 4);


-- ============================================
-- JOGO REAL DE EXEMPLO: Stardew Valley
-- ============================================
INSERT INTO Desenvolvedoras (nome, data_fundacao, pais) VALUES
('ConcernedApe', '2012-01-01', 'EUA');

INSERT INTO Publicadoras (nome, pais) VALUES
('ConcernedApe', 'EUA'),
('Chucklefish', 'Reino Unido');

INSERT INTO Jogos (id_desenvolvedora, id_publicadora, titulo, descricao, preco, data_lancamento, classificacao_etaria, tamanho_download, requisitos_minimos, requisitos_recomendados, capa, tag, nota) VALUES
(11, 6, 'Stardew Valley', 'Você herdou a antiga fazenda do seu avô em Stardew Valley. Armado com ferramentas de segunda mão e algumas moedas, você parte para iniciar sua nova vida. Consegue aprender a viver da terra e transformar esses campos abandonados em um lar próspero? Cultive safras, crie animais, pesque, mine, faça amizades com os moradores da cidade e até case-se. Com mais de 50 horas de conteúdo e atualizações constantes, Stardew Valley é uma experiência relaxante e viciante que conquistou mais de 50 milhões de jogadores ao redor do mundo.', 24.99, '2016-02-26', 'L', 0.5, 'Windows 7+, Intel Core 2 Duo 2GHz, 2GB RAM, 256MB VRAM, 500MB HD', 'Windows 10, Intel Core i3, 4GB RAM, 512MB VRAM', '#5a8c3a', 'Indie', 9.8);

INSERT INTO Jogos_categorias (id_jogo, id_categoria) VALUES (22, 7), (22, 3), (22, 10);
INSERT INTO Jogos_plataformas (id_jogo, id_plataforma) VALUES (22, 1), (22, 2), (22, 3), (22, 4), (22, 5);

-- Usuário de teste: senha = 123456 (hash bcrypt será gerado pelo PHP)
-- INSERT será feito via PHP para gerar hash correto
