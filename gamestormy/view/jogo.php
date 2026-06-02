<?php
$title = htmlspecialchars($jogo['titulo']) . ' - Games Stormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="container page-section" aria-label="Página do jogo">
  <a href="<?php echo base_url(''); ?>" class="btn-secondary" style="margin-bottom:20px;display:inline-block;">← Voltar</a>

  <div class="game-detail-layout">
    <div class="game-detail-cover" style="background: <?php echo htmlspecialchars($jogo['capa']); ?>"></div>
    <div class="game-detail-info">
      <div class="game-detail-tag"><?php echo htmlspecialchars($jogo['tag']); ?></div>
      <h1 class="game-detail-title"><?php echo htmlspecialchars($jogo['titulo']); ?></h1>
      <p class="game-detail-desc"><?php echo htmlspecialchars($jogo['descricao']); ?></p>
      <div class="game-detail-meta">
        <div class="game-meta-item"><span class="game-meta-key">Gênero</span><span><?php echo implode(', ', $categorias); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Plataformas</span><span><?php echo implode(', ', $plataformas); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Avaliação</span><span>⭐ <?php echo $media; ?>/5 (<?php echo count($avaliacoes); ?> avaliações)</span></div>
        <div class="game-meta-item"><span class="game-meta-key">Desenvolvedor</span><span><?php echo htmlspecialchars($jogo['desenvolvedora']); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Publicadora</span><span><?php echo htmlspecialchars($jogo['publicadora']); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Lançamento</span><span><?php echo date('d/m/Y', strtotime($jogo['data_lancamento'])); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Classificação</span><span><?php echo htmlspecialchars($jogo['classificacao_etaria']); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Tamanho</span><span><?php echo $jogo['tamanho_download']; ?> GB</span></div>
      </div>
      <div class="game-detail-price-row">
        <span class="game-detail-price">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></span>
        <?php if ($possui): ?>
          <span class="btn-success" style="border-radius:10px;padding:12px 24px;font-size:14px;font-weight:700;">✓ Na Biblioteca</span>
        <?php else: ?>
          <form method="POST" action="<?php echo base_url('?page=carrinho&action=add'); ?>" style="display:inline">
            <input type="hidden" name="id_jogo" value="<?php echo $jogo['id_jogo']; ?>"/>
            <input type="hidden" name="redirect" value="<?php echo '?page=jogo&id=' . $jogo['id_jogo']; ?>"/>
            <button type="submit" class="btn-primary">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
              Adicionar ao Carrinho
            </button>
          </form>
          <form method="POST" action="<?php echo base_url('?page=biblioteca&action=addDirect'); ?>" style="display:inline">
            <input type="hidden" name="id_jogo" value="<?php echo $jogo['id_jogo']; ?>"/>
            <button type="submit" class="btn-secondary">Salvar na Biblioteca</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Avaliações -->
  <section style="margin-top:40px;max-width:800px;">
    <h2 class="section-title">Avaliações</h2>
    <?php if (!empty($avaliacoes)): ?>
    <div class="avaliacoes-list">
      <?php foreach ($avaliacoes as $a): ?>
      <div class="avaliacao-item">
        <div class="avaliacao-header">
          <div class="avaliacao-avatar">
            <?php if (!empty($a['foto_perfil'])): ?>
              <img src="<?php echo base_url($a['foto_perfil']); ?>" alt=""/>
            <?php else: ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="padding:6px"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <?php endif; ?>
          </div>
          <span class="avaliacao-user"><?php echo htmlspecialchars($a['nome_usuario'] ?? $a['nickname']); ?></span>
          <span class="avaliacao-nota"><?php echo $a['nota']; ?>/5 ⭐</span>
        </div>
        <p class="avaliacao-text"><?php echo nl2br(htmlspecialchars($a['comentario'])); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
      <p style="color:rgba(255,255,255,.5);font-size:14px;">Nenhuma avaliação ainda. Seja o primeiro!</p>
    <?php endif; ?>

    <?php if (authCheck() && !$possui): ?>
    <div class="avaliacao-form">
      <h3 style="font-size:16px;margin-bottom:14px;">Deixar avaliação</h3>
      <form method="POST" action="<?php echo base_url('?page=jogo&action=avaliar'); ?>">
        <input type="hidden" name="id_jogo" value="<?php echo $jogo['id_jogo']; ?>"/>
        <div class="support-form-grid">
          <div class="support-form-group">
            <label class="support-form-label">Nota (0 a 5)</label>
            <select name="nota" class="support-form-input support-form-select" required>
              <option value="5">5 - Excelente</option>
              <option value="4">4 - Muito bom</option>
              <option value="3">3 - Bom</option>
              <option value="2">2 - Regular</option>
              <option value="1">1 - Ruim</option>
              <option value="0">0 - Péssimo</option>
            </select>
          </div>
          <div class="support-form-group full">
            <label class="support-form-label">Comentário</label>
            <textarea name="comentario" class="support-form-input support-form-textarea" placeholder="Escreva sua opinião..." required></textarea>
          </div>
        </div>
        <button type="submit" class="btn-primary" style="margin-top:12px;">Enviar Avaliação</button>
      </form>
    </div>
    <?php elseif (!authCheck()): ?>
      <p style="margin-top:16px;color:rgba(255,255,255,.5);font-size:13px;"><a href="<?php echo base_url('?page=usuario&action=login'); ?>" style="color:var(--purple-lt);text-decoration:underline;">Faça login</a> para avaliar.</p>
    <?php endif; ?>
  </section>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
