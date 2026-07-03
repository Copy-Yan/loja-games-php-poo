<?php
// Defensivo: se helpers globais não existirem em algum bootstrap/ambiente, não quebra a renderização.
if (!function_exists('getUsuarioLogado')) {
  function getUsuarioLogado() { return null; }
}
if (!function_exists('getCarrinho')) {
  function getCarrinho() { return []; }
}
if (!function_exists('base_url')) {
  function base_url($path = '') { return $path ? $path : ''; }
}

$usuario = getUsuarioLogado();
$cartCount = 0;
foreach (getCarrinho() as $item) $cartCount += $item['qty'] ?? 0;
?>
<nav class="navbar" role="navigation" aria-label="Navegação principal">
  <a href="<?php echo base_url(''); ?>" class="navbar-logo">
<img
      class="navbar-logo-img"
      src="<?php echo base_url('assets/uploads/avatares/Logo Stormy.png'); ?>?t=<?php echo time(); ?>"
      alt="Stormy"
    />
    Gamestormy
  </a>
  <div class="navbar-links">
    <a href="<?php echo base_url(''); ?>" class="nav-pill <?php echo ($page ?? '') === 'home' ? 'active' : ''; ?>">Explorar</a>
    <a href="<?php echo base_url('?page=biblioteca'); ?>" class="nav-pill <?php echo ($page ?? '') === 'biblioteca' ? 'active' : ''; ?>">Minha Biblioteca</a>
    <a href="<?php echo base_url('?page=sobre'); ?>" class="nav-pill <?php echo ($page ?? '') === 'sobre' ? 'active' : ''; ?>">Sobre</a>
    <a href="<?php echo base_url('?page=suporte'); ?>" class="nav-pill <?php echo ($page ?? '') === 'suporte' ? 'active' : ''; ?>">Suporte</a>
  </div>
  <form action="<?php echo base_url('?page=busca'); ?>" method="GET" class="navbar-search" style="margin-left:auto;">
    <input type="hidden" name="page" value="busca"/>
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    <input type="text" name="q" placeholder="Pesquisar jogos..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" aria-label="Pesquisar jogos"/>
    <button type="submit" style="display:none">Buscar</button>
  </form>
  <div class="navbar-icons">
    <a href="<?php echo base_url('?page=carrinho'); ?>" class="icon-btn" aria-label="Carrinho">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      <?php if ($cartCount > 0): ?><span class="cart-badge"><?php echo $cartCount; ?></span><?php endif; ?>
    </a>
    <?php if ($usuario): ?>
      <a href="<?php echo base_url('?page=usuario&action=perfil'); ?>" class="avatar" aria-label="Meu perfil" title="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>">
        <?php if (!empty($usuario['foto_perfil']) && file_exists(__DIR__ . '/../../' . $usuario['foto_perfil'])): ?>
          <img src="<?php echo base_url($usuario['foto_perfil']) . '?' . time(); ?>" alt="Avatar" style="width:100%;height:100%;object-fit:cover;"/>
        <?php else: ?>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="padding:6px;color:#fff;width:100%;height:100%;"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <?php endif; ?>
      </a>
      <a href="<?php echo base_url('?page=usuario&action=logout'); ?>" class="icon-btn" title="Sair">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      </a>
    <?php else: ?>
      <a href="<?php echo base_url('?page=usuario&action=login'); ?>" class="icon-btn" title="Entrar">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      </a>
    <?php endif; ?>
  </div>
</nav>