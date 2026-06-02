<?php
$title = 'Games Stormy - Explorar';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="container page-section" aria-label="Página inicial">

  <!-- Hero Grid (sem JS) -->
  <div class="hero-grid">
    <?php foreach ($destaques as $jogo): ?>
    <div class="hero-card" style="background: <?php echo htmlspecialchars($jogo['capa']); ?>">
      <span class="hero-tag"><?php echo htmlspecialchars($jogo['tag']); ?></span>
      <h2 class="hero-title"><?php echo htmlspecialchars($jogo['titulo']); ?></h2>
      <p class="hero-desc"><?php echo htmlspecialchars($jogo['descricao']); ?></p>
      <span class="hero-price">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></span>
      <a href="<?php echo base_url('?page=jogo&id=' . $jogo['id_jogo']); ?>" class="hero-btn">Página do jogo →</a>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Categorias -->
  <section class="page-section" aria-labelledby="cat-title">
    <div class="section-header">
      <h2 class="section-title" id="cat-title">Explorar por categoria</h2>
    </div>
    <div class="categories-grid">
      <?php
      $catColors = ['#e8a0c8','#e8a06a','#7ab8e8','#a8e8a0','#c8b8e8','#e8d8a0','#a0e8d8','#e8a0a0','#b8e0a0','#a0b8e8','#d8a0e8','#e8c8a0'];
      $i = 0;
      foreach ($categorias as $cat):
        $bg = $catColors[$i % count($catColors)];
        $i++;
      ?>
      <a href="<?php echo base_url('?page=busca&q=' . urlencode($cat['nome'])); ?>" class="category-card" style="background: <?php echo $bg; ?>">
        <span class="category-card-label"><?php echo htmlspecialchars($cat['nome']); ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Novos Lançamentos -->
  <section class="page-section" aria-labelledby="new-title">
    <div class="section-header">
      <h2 class="section-title" id="new-title">Novos lançamentos</h2>
      <a href="<?php echo base_url('?page=busca'); ?>" class="section-link">Ver todos →</a>
    </div>
    <div class="games-grid">
      <?php foreach ($novos as $jogo): ?>
      <a href="<?php echo base_url('?page=jogo&id=' . $jogo['id_jogo']); ?>" class="game-card">
        <div class="game-card-thumb" style="background: <?php echo htmlspecialchars($jogo['capa']); ?>">
          <?php echo htmlspecialchars($jogo['titulo']); ?>
        </div>
        <div class="game-card-info">
          <div class="game-card-name"><?php echo htmlspecialchars($jogo['titulo']); ?></div>
          <div class="game-card-meta"><?php echo htmlspecialchars($jogo['desenvolvedora']); ?></div>
          <span class="game-card-price">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Jogos para você -->
  <section class="page-section" aria-labelledby="foryou-title">
    <div class="section-header">
      <h2 class="section-title" id="foryou-title">Jogos para você</h2>
    </div>
    <div class="games-grid">
      <?php
      $foryou = array_slice($todos, 0, 10);
      foreach ($foryou as $jogo):
      ?>
      <a href="<?php echo base_url('?page=jogo&id=' . $jogo['id_jogo']); ?>" class="game-card">
        <div class="game-card-thumb" style="background: <?php echo htmlspecialchars($jogo['capa']); ?>">
          <?php echo htmlspecialchars($jogo['titulo']); ?>
        </div>
        <div class="game-card-info">
          <div class="game-card-name"><?php echo htmlspecialchars($jogo['titulo']); ?></div>
          <div class="game-card-meta"><?php echo htmlspecialchars($jogo['tag']); ?></div>
          <span class="game-card-price">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
