<?php
// Defaults defensivos para evitar notices/fatais quando a controller não popula alguma variável.
$jogo = isset($jogo) ? $jogo : [];

// Garanta tipos esperados para evitar warnings (ex.: implode() em null/string).
$categorias = (isset($categorias) && is_array($categorias)) ? $categorias : [];
$plataformas = (isset($plataformas) && is_array($plataformas)) ? $plataformas : [];
$avaliacoes = (isset($avaliacoes) && is_array($avaliacoes)) ? $avaliacoes : [];

$media = (isset($media) && is_numeric($media)) ? (float)$media : 0;
$possui = isset($possui) ? (bool)$possui : false;



// Helpers podem não estar disponíveis no escopo da view (dependendo do bootstrap).
if (!function_exists('base_url')) {
  function base_url($path = '') {
    // fallback simples para ambientes/boots incompletos
    return $path ? $path : '';
  }
}

// fallback caso authCheck não exista no ambiente de renderização
if (!function_exists('authCheck')) {
  function authCheck() { return false; }
}

$__titulo_jogo = htmlspecialchars($jogo['titulo'] ?? 'Jogo') . ' - Gamestormy';
$title = $__titulo_jogo;
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>


<main class="container page-section" aria-label="Página do jogo">
<a href="<?php echo function_exists('base_url') ? base_url('') : ''; ?>" class="btn-secondary" style="margin-bottom:20px;display:inline-block;">← Voltar</a>

  <div class="game-detail-layout">
    <div class="game-detail-media">
      <div
        class="game-detail-cover"
        style="<?php
          $capa = trim((string)($jogo['capa'] ?? ''));
          $capaUrl = '';

          if ($capa !== '') {
            if (preg_match('/^https?:\/\//i', $capa)) {
              $capaUrl = $capa;
            } else {
              $normalized = trim($capa);
              $normalized = ltrim($normalized, "./\\");
              $normalized = ltrim($normalized, '/');

              if (str_starts_with($normalized, 'assets/')) {
                $capaUrl = function_exists('base_url') ? base_url($normalized) : $normalized;
              } elseif (str_starts_with($normalized, 'uploads/')) {
                $capaUrl = function_exists('base_url') ? base_url('assets/' . $normalized) : ('assets/' . $normalized);
              } else {
                // assume que é algo como capas/arquivo.jpg ou qualquer caminho que termine em nome do arquivo
                $file = basename($normalized);
                $capaUrl = function_exists('base_url') ? base_url('assets/uploads/capas/' . $file) : ('assets/uploads/capas/' . $file);
              }
            }
          }

          if ($capaUrl) {
            echo 'background-image:url(' . htmlspecialchars($capaUrl, ENT_QUOTES, 'UTF-8') . ')
            ;background-size:contain;background-position:center; background-repeat: no-repeat';
          } else {
            echo 'background:#3d3d3d;';
          }
        ?>"
      ></div>
    </div>

    <div class="game-detail-info">
      <div class="game-detail-tag"><?php echo htmlspecialchars($jogo['tag'] ?? ''); ?></div>
      <h1 class="game-detail-title"><?php echo htmlspecialchars($jogo['titulo'] ?? ''); ?></h1>
      <p class="game-detail-desc"><?php echo htmlspecialchars($jogo['descricao'] ?? ''); ?></p>

      <div class="game-detail-meta">
        <div class="game-meta-item"><span class="game-meta-key">Gênero</span><span><?php echo implode(', ', $categorias); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Plataformas</span><span><?php echo implode(', ', $plataformas); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Avaliação</span><span>⭐ <?php echo $media; ?>/5 (<?php echo count($avaliacoes); ?> avaliações)</span></div>
        <div class="game-meta-item"><span class="game-meta-key">Desenvolvedor</span><span><?php echo htmlspecialchars($jogo['desenvolvedora'] ?? ''); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Publicadora</span><span><?php echo htmlspecialchars($jogo['publicadora'] ?? ''); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Lançamento</span><span><?php $dt = $jogo['data_lancamento'] ?? ''; echo $dt && strtotime($dt) ? date('d/m/Y', strtotime($dt)) : '-'; ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Classificação</span><span><?php echo htmlspecialchars($jogo['classificacao_etaria'] ?? ''); ?></span></div>
        <div class="game-meta-item"><span class="game-meta-key">Tamanho</span><span><?php echo htmlspecialchars((string)($jogo['tamanho_download'] ?? '0')); ?> GB</span></div>
      </div>

      <div class="game-detail-price-row">
        <span class="game-detail-price">R$ <?php echo number_format((float)($jogo['preco'] ?? 0), 2, ',', '.'); ?></span>
        <?php if (!empty($jogo['id_jogo']) && function_exists('base_url')): ?>
        <?php endif; ?>
        <?php if ($possui): ?>
          <span class="btn-success" style="border-radius:10px;padding:12px 24px;font-size:14px;font-weight:700;">✓ Na Biblioteca</span>
        <?php else: ?>
          <form method="POST" action="<?php echo function_exists('base_url') ? base_url('?page=carrinho&action=add') : '?page=carrinho&action=add'; ?>" style="display:inline">
            <input type="hidden" name="id_jogo" value="<?php echo htmlspecialchars((string)($jogo['id_jogo'] ?? '')); ?>"/>
            <input type="hidden" name="redirect" value="<?php echo '?page=jogo&id=' . ($jogo['id_jogo'] ?? ''); ?>"/>
            <button type="submit" class="btn-primary">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
              Adicionar ao Carrinho
            </button>
          </form>
          <form method="POST" action="<?php echo function_exists('base_url') ? base_url('?page=biblioteca&action=addDirect') : '?page=biblioteca&action=addDirect'; ?>" style="display:inline">
            <input type="hidden" name="id_jogo" value="<?php echo htmlspecialchars((string)($jogo['id_jogo'] ?? '')); ?>"/>
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
      <div class="avaliacao-item" style="background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06);">
      <p style="color:rgba(255,255,255,.55);font-size:14px;">Nenhuma avaliação ainda. Seja o primeiro!</p>
      </div>
    <?php endif; ?>

      <?php if (function_exists('authCheck') && authCheck() && !$possui): ?>
    <div class="avaliacao-form">
      <h3 style="font-size:16px;margin-bottom:14px;">Deixar avaliação</h3>
      <form method="POST" action="<?php echo function_exists('base_url') ? base_url('?page=jogo&action=avaliar') : '?page=jogo&action=avaliar'; ?>">
        <input type="hidden" name="id_jogo" value="<?php echo htmlspecialchars((string)($jogo['id_jogo'] ?? '')); ?>"/>
        <div class="support-form-grid">
          <div class="support-form-group">
            <label class="support-form-label">Nota (0 a 5)</label>
            <select name="nota" class="support-form-input support-form-select" required>
              <option value= "5" required style="color:#000;">5 - Excelente</option>
              <option value="4" required style="color:#000;">4 - Muito bom</option>
              <option value="3" required style="color:#000;">3 - Bom</option>
              <option value="2" required style="color:#000;">2 - Regular</option>
              <option value="1" required style="color:#000;">1 - Ruim</option>
              <option value="0" required style="color:#000;">0 - Péssimo</option>
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
      <p style="margin-top:16px;color:rgba(255,255,255,.5);font-size:13px;"><a href="<?php echo function_exists('base_url') ? base_url('?page=usuario&action=login') : '?page=usuario&action=login'; ?>" style="color:var(--purple-lt);text-decoration:underline;">Faça login</a> para avaliar.</p>
    <?php endif; ?>
  </section>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
