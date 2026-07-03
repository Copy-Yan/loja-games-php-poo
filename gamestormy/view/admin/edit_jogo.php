<?php
// Defaults defensivos para evitar notices/fatais quando a controller não popula alguma variável.
$erro = $erro ?? '';
$success = $success ?? '';
$jogo = $jogo ?? [];
$devs = $devs ?? [];
$pubs = $pubs ?? [];
$categorias = $categorias ?? [];
$catsAtuais = $catsAtuais ?? [];
$plataformas = $plataformas ?? [];
$platsAtuais = $platsAtuais ?? [];

// Garante que base_url exista para as partials (header/navbar) não quebrarem.
if (!function_exists('base_url')) {
  function base_url($path = '') {
    return $path ? $path : '';
  }
}

$title = 'Editar Jogo - Admin';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/navbar.php';
?>

<main class="container page-section" style="max-width:900px;">
  <div class="section-header">
    <h1 class="page-title">✏️ Editar Jogo</h1>
    <a href="<?php echo base_url('?page=admin&action=jogos'); ?>" class="btn-secondary">← Voltar</a>
  </div>

  <?php if (!empty($erro)): ?><div class="alert alert-error"><?php echo $erro; ?></div><?php endif; ?>
  <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

    <div style="display:contain;gap:20px;align-items:start;margin-bottom:20px;">
    <?php
      $capa = trim((string)($jogo['capa'] ?? ''));
      $capaUrl = '';

      // Normaliza para sempre conseguir apontar para /assets/uploads/capas/*
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
            if (str_starts_with($normalized, 'capas/')) {
              $capaUrl = function_exists('base_url') ? base_url('assets/uploads/' . $normalized) : ('assets/uploads/' . $normalized);
            } else {
              $capaUrl = function_exists('base_url') ? base_url('assets/uploads/capas/' . basename($normalized)) : ('assets/uploads/capas/' . basename($normalized));
            }
          }
        }
      }
    ?>
    <div style="width:400px;height:170px;border-radius:10px;background:<?php echo $capaUrl ? 'url(' . htmlspecialchars($capaUrl, ENT_QUOTES, 'UTF-8') . ')' : htmlspecialchars($capa ?: '#3d3d3d', ENT_QUOTES, 'UTF-8'); ?>;background-size:contain; background-position:center; background-repeat: no-repeat; flex-shrink:0;"></div>
    <div>
      <h2 style="font-size:18px;font-weight:700;">
      <p style="font-size:12px;color:rgba(255,255,255,.5);">ID: <?php echo htmlspecialchars((string)($jogo['id_jogo'] ?? '')); ?></p>
    </div>
  </div>

  <form method="POST" action="<?php echo function_exists('base_url') ? base_url('?page=admin&action=editJogo&id=' . ($jogo['id_jogo'] ?? '')) : '?page=admin&action=editJogo&id=' . ($jogo['id_jogo'] ?? ''); ?>" enctype="multipart/form-data"

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="support-form-group" style="grid-column:1/-1;">
        <label class="support-form-label">Título do Jogo *</label>
        <input class="support-form-input" type="text" name="titulo" value="<?php echo htmlspecialchars($jogo['titulo']); ?>" required/>
      </div>

      <div class="support-form-group" style="grid-column:1/-1;">
        <label class="support-form-label">Descrição *</label>
        <textarea class="support-form-input support-form-textarea" name="descricao" required><?php echo htmlspecialchars($jogo['descricao']); ?></textarea>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Preço (R$) *</label>
        <input class="support-form-input" type="number" name="preco" step="0.01" value="<?php echo htmlspecialchars((string)($jogo['preco'] ?? 0)); ?>" required/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Data de Lançamento *</label>
        <input class="support-form-input" type="date" name="data_lancamento" value="<?php echo htmlspecialchars((string)($jogo['data_lancamento'] ?? '')); ?>" required/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Classificação Etária</label>
        <select class="support-form-input support-form-select" name="classificacao_etaria">
          <option value="L" required style="color:#000;" <?php echo $jogo['classificacao_etaria']=='L'?'selected':''; ?>>L - Livre</option>
          <option value="10" required style="color:#000;" <?php echo $jogo['classificacao_etaria']=='10'?'selected':''; ?>>10 Anos</option>
          <option value="12" required style="color:#000;" <?php echo $jogo['classificacao_etaria']=='12'?'selected':''; ?>>12 Anos</option>
          <option value="14" required style="color:#000;" <?php echo $jogo['classificacao_etaria']=='14'?'selected':''; ?>>14 Anos</option>
          <option value="16" required style="color:#000;" <?php echo $jogo['classificacao_etaria']=='16'?'selected':''; ?>>16 Anos</option>
          <option value="18" required style="color:#000;" <?php echo $jogo['classificacao_etaria']=='18'?'selected':''; ?>>18 Anos</option>
        </select>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Tamanho do Download (GB)</label>
        <input class="support-form-input" type="number" name="tamanho_download" step="0.1" value="<?php echo htmlspecialchars((string)($jogo['tamanho_download'] ?? 0)); ?>"/>
      </div>

      <div class="support-form-group" style="grid-column:1/-1;">
        <label class="support-form-label">Requisitos Mínimos *</label>
        <input class="support-form-input" type="text" name="requisitos_minimos" value="<?php echo htmlspecialchars($jogo['requisitos_minimos']); ?>" required/>
      </div>

      <div class="support-form-group" style="grid-column:1/-1;">
        <label class="support-form-label">Requisitos Recomendados *</label>
        <input class="support-form-input" type="text" name="requisitos_recomendados" value="<?php echo htmlspecialchars($jogo['requisitos_recomendados']); ?>" required/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Tag / Destaque</label>
        <input class="support-form-input" type="text" name="tag" value="<?php echo htmlspecialchars($jogo['tag']); ?>"/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Nota (0 a 10)</label>
        <input class="support-form-input" type="number" name="nota" step="0.1" min="0" max="10" value="<?php echo htmlspecialchars((string)($jogo['nota'] ?? 0)); ?>"/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Desenvolvedora</label>
        <select class="support-form-input support-form-select" name="id_desenvolvedora" required style="color:#000;">
          <?php foreach ($devs as $d): ?>
          <option value="<?php echo $d['id_desenvolvedora']; ?>" <?php echo $jogo['id_desenvolvedora']==$d['id_desenvolvedora']?'selected':''; ?>><?php echo htmlspecialchars($d['nome']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Publicadora</label>
        <select class="support-form-input support-form-select" name="id_publicadora" required style="color:#000;">
          <?php foreach ($pubs as $p): ?>
          <option value="<?php echo $p['id_publicadora']; ?>" <?php echo $jogo['id_publicadora']==$p['id_publicadora']?'selected':''; ?>><?php echo htmlspecialchars($p['nome']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="support-form-group" style="grid-column:1/-1;">
        <label class="support-form-label">Categorias</label>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <?php foreach ($categorias as $c): ?>
          <label style="display:flex;align-items:center;gap:6px;background:rgba(255,255,255,.06);padding:6px 12px;border-radius:6px;cursor:pointer;">
            <input type="checkbox" name="categorias[]" value="<?php echo $c['id_categoria']; ?>" <?php echo in_array($c['id_categoria'], $catsAtuais)?'checked':''; ?> style="width:16px;height:16px;"/>
            <?php echo htmlspecialchars($c['nome']); ?>
          </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="support-form-group" style="grid-column:1/-1;">
        <label class="support-form-label">Plataformas</label>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <?php foreach ($plataformas as $p): ?>
          <label style="display:flex;align-items:center;gap:6px;background:rgba(255,255,255,.06);padding:6px 12px;border-radius:6px;cursor:pointer;">
            <input type="checkbox" name="plataformas[]" value="<?php echo $p['id_plataforma']; ?>" <?php echo in_array($p['id_plataforma'], $platsAtuais)?'checked':''; ?> style="width:16px;height:16px;"/>
            <?php echo htmlspecialchars($p['nome']); ?>
          </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="support-form-group" style="grid-column:1/-1;">
        <label class="support-form-label">Nova Capa (deixe em branco para manter a atual)</label>
        <input type="file" name="capa" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" style="background:rgba(255,255,255,.06);border:1px dashed rgba(255,255,255,.2);border-radius:8px;padding:12px;font-size:13px;color:var(--white);width:100%;"/>
      </div>
    </div>

    <div style="margin-top:24px;display:flex;gap:10px;">
      <button type="submit" class="btn-primary">💾 Salvar Alterações</button>
    <a href="<?php echo function_exists('base_url') ? base_url('?page=admin&action=jogos') : '?page=admin&action=jogos'; ?>" class="btn-secondary">Cancelar</a>
    </div>
  </form>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>