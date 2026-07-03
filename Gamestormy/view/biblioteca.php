<?php
$title = 'Minha Biblioteca - Gamestormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="container page-section" aria-label="Minha biblioteca">
  <div style="padding:28px 0 8px;">
    <h1 style="font-size:22px;font-weight:700;color:var(--white);margin-bottom:4px;">Minha Biblioteca</h1>
    <p style="font-size:13px;color:rgba(255,255,255,.5);">Jogos salvos na sua conta</p>
  </div>

  <?php $flash = flash('success'); if ($flash): ?><div class="alert alert-success" style="margin:16px 0;"><?php echo $flash; ?></div><?php endif; ?>

  <?php if (empty($jogos)): ?>
    <div class="library-empty-state" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 0;text-align:center;color:rgba(255,255,255,.4);gap:12px;">
      <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" style="opacity:.25;"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3v4M8 3v4M2 11h20"/></svg>
      <p>Sua biblioteca está vazia</p>
      <a href="<?php echo base_url(''); ?>" class="btn-primary" style="margin-top:8px;">Explorar jogos</a>
    </div>
  <?php else: ?>
    <div class="library-grid" style="padding:24px 0 40px;">
      <?php foreach ($jogos as $j): ?>
      <div class="library-card">
        <a href="<?php echo base_url('?page=jogo&id=' . $j['id_jogo']); ?>">
          <div
            class="library-thumb"
            style="<?php
              $capa = $j['capa'] ?? '';
              if (is_string($capa) && strpos($capa, 'assets/') === 0) {
                  echo 'background-image:url(' . base_url($capa) . ');background-size:cover;background-position:center;';
              } else {
                  echo 'background:' . htmlspecialchars($capa ?: '#3d3d3d') . ';';
              }
            ?>"
          ></div>
        </a>
        <div class="library-info">
          <div class="library-name"><?php echo htmlspecialchars($j['titulo']); ?></div>
          <div class="library-genre"><?php echo htmlspecialchars($j['desenvolvedora']); ?></div>
          <span class="library-price">R$ <?php echo number_format($j['preco'], 2, ',', '.'); ?></span>
        </div>
        <form method="POST" action="<?php echo base_url('?page=biblioteca&action=remove&id=' . $j['id_jogo']); ?>" onsubmit="return confirm('Remover este jogo da biblioteca?');">
          <button type="submit" class="library-remove" aria-label="Remover">✕</button>
        </form>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>


<?php require __DIR__ . '/partials/footer.php'; ?>
