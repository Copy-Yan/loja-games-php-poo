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

---

## Requisitos

- PHP 7.4+
- MySQL / MariaDB
- phpMyAdmin (XAMPP, WAMP, Laragon, etc.)
- Extensao PDO MySQL habilitada no PHP

---

## Instalacao

### 1. Copiar para o servidor
Copie a pasta `gamestormy` inteira para:
- **XAMPP**: `C:\xampp\htdocs\gamestormy`
- **WAMP**: `C:\wamp64\www\gamestormy`
- **Linux**: `/var/www/html/gamestormy`

### 2. Criar o banco de dados
1. Abra o **phpMyAdmin** (`http://localhost/phpmyadmin`)
2. Clique em **Importar**
3. Selecione o arquivo `db/gamestormy.sql`
4. Clique em **Executar**

Isso criara automaticamente:
- O banco `gamestormy`
- Todas as tabelas
- Dados de exemplo (20 jogos, categorias, plataformas, desenvolvedoras, publicadoras)

### 3. Configurar conexao (se necessario)
Edite `config/database.php` se seu MySQL usar senha:
```php
define('DB_USER', 'root');
define('DB_PASS', '');     // coloque sua senha aqui se houver
```

### 4. Permissoes da pasta uploads
Certifique-se de que a pasta `assets/uploads/avatares/` tenha permissao de escrita.

### 5. Acessar o site
Abra no navegador: `http://localhost/gamestormy/`

---

## Funcionalidades

| Funcionalidade | Descricao |
|----------------|-----------|
| **Pesquisa** | Busca funcional por titulo, descricao ou desenvolvedora (sem JS) |
| **Login/Cadastro** | Sistema completo com hash de senha (bcrypt) |
| **Perfil editavel** | Alterar nome, nickname, email, data de nascimento e **foto de perfil** |
| **Carrinho** | Adicionar/remover itens via sessao PHP |
| **Checkout** | Finalizar compra com PIX, Cartao ou Boleto |
| **Biblioteca** | Jogos comprados salvos no banco, com opcao de remover |
| **Avaliacoes** | Nota de 0-5 e comentarios por jogo |
| **Suporte** | Formulario de contato com historico de tickets |
| **100% Sem JS** | Toda interacao via PHP e formularios HTML |

---

## Banco de Dados

O script SQL inclui todas as tabelas originais do seu projeto:
- `Usuarios` (com campo `foto_perfil` adicionado)
- `Endereco`
- `Desenvolvedoras`
- `Publicadoras`
- `Jogos` (com capa, tag e nota para exibicao)
- `Categorias` / `Jogos_categorias`
- `Biblioteca`
- `Pedidos` / `Pedido_itens`
- `Pagamentos`
- `Avaliacoes`
- `Plataformas` / `Jogos_plataformas`
- `Suporte` / `Suporte_mensagens`
- `Administradores`

---


## 🛠️ Painel Administrativo

O site possui um painel admin para gerenciar jogos. Para acessar:

### 1. Tornar-se Administrador

No phpMyAdmin, execute:
```sql
INSERT INTO Administradores (id_usuario, cargo) 
VALUES (1, 'super_admin');
```
> Substitua `1` pelo seu `id_usuario`.

### 2. Acessar o Painel

Faça login e acesse: `http://localhost/gamestormy/?page=admin`

### 3. Funcionalidades do Painel

- **📊 Dashboard** — Visão geral com estatísticas
- **🎮 Gerenciar Jogos** — Lista todos os jogos com opção de remover
- **➕ Adicionar Jogo** — Formulário completo com:
  - Upload de capa (imagem)
  - Título, descrição, preço
  - Data de lançamento, classificação etária
  - Requisitos mínimos e recomendados
  - Tag, nota, categorias
  - Desenvolvedora e publicadora

### 4. Exemplo Real Incluído

O banco já vem com **Stardew Valley** como exemplo:
- **Título:** Stardew Valley
- **Preço:** R$ 24,99
- **Desenvolvedora:** ConcernedApe
- **Lançamento:** 26/02/2016
- **Nota:** 9.8/10
- **Categorias:** Simulação, RPG, Indie
- **Plataformas:** PC, PS5, Xbox, Switch, Mobile


## Notas

- O carrinho funciona via **sessao PHP**, nao usa banco.
- Ao finalizar a compra, os jogos vao automaticamente para a `Biblioteca` e um `Pedido` e registrado.
- A pesquisa busca em **titulo, descricao e nome da desenvolvedora**.
- Upload de avatar aceita: JPG, PNG, GIF, WEBP.
- Layout responsivo para mobile.
