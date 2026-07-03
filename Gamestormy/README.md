# Gamestormy - PHP MVC + MySQL



---

## Estrutura de Pastas

```
gamestormy/
├── .htaccess              # Reescrita de URLs
├── index.php              # Roteador principal
├── config/
│   └── database.php       # Conexao PDO com MySQL
├── controller/
│   ├── HomeController.php
│   ├── BuscaController.php
│   ├── JogoController.php
│   ├── UsuarioController.php
│   ├── CarrinhoController.php
│   ├── BibliotecaController.php
│   ├── SuporteController.php
│   └── SobreController.php
├── model/
│   ├── Usuario.php
│   ├── Jogo.php
│   ├── Categoria.php
│   ├── Biblioteca.php
│   ├── Suporte.php
│   ├── Avaliacao.php
│   └── Pedido.php
├── view/
│   ├── home.php
│   ├── busca.php
│   ├── jogo.php
│   ├── login.php
│   ├── register.php
│   ├── perfil.php
│   ├── biblioteca.php
│   ├── carrinho.php
│   ├── checkout.php
│   ├── suporte.php
│   ├── sobre.php
│   └── partials/
│       ├── header.php
│       ├── navbar.php
│       └── footer.php
├── assets/
│   ├── css/styles.css
│   └── uploads/avatares/  (pasta para fotos de perfil)
└── db/
    └── gamestormy.sql     # Script completo do banco
```

## Sobre o Projeto

O **Gamestormy** é uma plataforma de jogos digitais desenvolvida utilizando a arquitetura **MVC (Model-View-Controller)** com **PHP** e **MySQL**. O sistema permite que usuários criem contas, realizem login, pesquisem jogos, visualizem informações detalhadas, adicionem títulos ao carrinho, efetuem compras, gerenciem sua biblioteca pessoal, avaliem jogos e entrem em contato com o suporte. O objetivo do projeto é simular uma loja virtual de jogos, aplicando boas práticas de organização de código, separação de responsabilidades e integração com banco de dados relacional.

##  Pré-requisitos

Antes de executar a aplicação localmente, certifique-se de possuir os seguintes programas instalados:

- PHP 8.0 ou superior;
- MySQL 8.0 ou superior (ou MariaDB compatível);
- Servidor Apache com suporte ao módulo `mod_rewrite`;
- XAMPP, WAMP ou Laragon (recomendado para facilitar a configuração do ambiente);
- Navegador web atualizado;
- Git (opcional, para clonar o repositório).

##  Instalação e Configuração

Siga os passos abaixo para executar o projeto em sua máquina:

git clone https://github.com/Copy-Yan/loja-games-php-poo.git

### Caso Banco de dados não for de imediato
1. Vá no PHPMYADMIN **Importar**
2. Arquivo `db/gamestormy.sql`
3. **Executar**
