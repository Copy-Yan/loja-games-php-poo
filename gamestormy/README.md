# Games Stormy - PHP MVC + MySQL

Projeto completo de loja de jogos digitais em PHP puro (sem JavaScript), conectado ao banco de dados MySQL via phpMyAdmin.

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

### Caso Banco de dados não for de imediato
1. PHPMYADMIN **Importar**
2. Arquivo `db/gamestormy.sql`
3. **Executar**