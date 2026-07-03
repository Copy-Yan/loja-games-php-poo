
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


Insert into Usuarios (id_usuario, nome_usuario, nickname, email, senha, data_nascimento, status)
Values (1, 'John Doe', 'johndoe', 'johndoe@example.com', '1234', '1990-01-01', 'Ativo');

Insert into Administradores (id_usuario, cargo)
Values (1, super_admin)