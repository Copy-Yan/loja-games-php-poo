<?php
$title = 'Busca - Games Stormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="container page-section" aria-label="Resultados da busca">
  <h1 class="page-title">
    <?php if ($q): ?>Resultados para "<?php echo htmlspecialchars($q); ?>"
    <?php else: ?>Buscar jogos<?php endif; ?>
  </h1>

  <?php if ($q && empty($resultados)): ?>
    <div class="alert alert-error">Nenhum jogo encontrado para sua busca.</div>
  <?php endif; ?>

  <?php if (!empty($resultados)): ?>
  <div class="games-grid">
    <?php foreach ($resultados as $jogo): ?>
    <a href="<?php echo base_url('?page=jogo&id=' . $jogo['id_jogo']); ?>" class="game-card">
      <div class="game-card-thumb" style="background: <?php echo htmlspecialchars($jogo['capa']); ?>">
        <?php echo htmlspecialchars($jogo['titulo']); ?>
      </div>
      <div class="game-card-info">
        <div class="game-card-name"><?php echo htmlspecialchars($jogo['titulo']); ?></div>
        <div class="game-card-meta"><?php echo htmlspecialchars($jogo['desenvolvedora']); ?> • <?php echo htmlspecialchars($jogo['tag']); ?></div>
        <span class="game-card-price">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></span>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
