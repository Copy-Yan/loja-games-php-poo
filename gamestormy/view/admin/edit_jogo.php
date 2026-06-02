<?php
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

  <div style="display:flex;gap:20px;align-items:start;margin-bottom:20px;">
    <div style="width:120px;height:140px;border-radius:10px;background:<?php echo htmlspecialchars($jogo['capa'] ?? '#3d3d3d'); ?>;background-size:cover;background-position:center;flex-shrink:0;"></div>
    <div>
      <h2 style="font-size:18px;font-weight:700;"><?php echo htmlspecialchars($jogo['titulo']); ?></h2>
      <p style="font-size:12px;color:rgba(255,255,255,.5);">ID: <?php echo $jogo['id_jogo']; ?></p>
    </div>
  </div>

  <form method="POST" action="<?php echo base_url('?page=admin&action=editJogo&id=' . $jogo['id_jogo']); ?>" enctype="multipart/form-data" style="background:rgba(255,255,255,.04);border-radius:16px;padding:28px;border:1px solid rgba(255,255,255,.08);">

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
        <input class="support-form-input" type="number" name="preco" step="0.01" value="<?php echo $jogo['preco']; ?>" required/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Data de Lançamento *</label>
        <input class="support-form-input" type="date" name="data_lancamento" value="<?php echo $jogo['data_lancamento']; ?>" required/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Classificação Etária</label>
        <select class="support-form-input support-form-select" name="classificacao_etaria">
          <option value="L" <?php echo $jogo['classificacao_etaria']=='L'?'selected':''; ?>>L - Livre</option>
          <option value="10" <?php echo $jogo['classificacao_etaria']=='10'?'selected':''; ?>>10</option>
          <option value="12" <?php echo $jogo['classificacao_etaria']=='12'?'selected':''; ?>>12</option>
          <option value="14" <?php echo $jogo['classificacao_etaria']=='14'?'selected':''; ?>>14</option>
          <option value="16" <?php echo $jogo['classificacao_etaria']=='16'?'selected':''; ?>>16</option>
          <option value="18" <?php echo $jogo['classificacao_etaria']=='18'?'selected':''; ?>>18</option>
        </select>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Tamanho do Download (GB)</label>
        <input class="support-form-input" type="number" name="tamanho_download" step="0.1" value="<?php echo $jogo['tamanho_download']; ?>"/>
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
        <input class="support-form-input" type="number" name="nota" step="0.1" min="0" max="10" value="<?php echo $jogo['nota']; ?>"/>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Desenvolvedora</label>
        <select class="support-form-input support-form-select" name="id_desenvolvedora">
          <?php foreach ($devs as $d): ?>
          <option value="<?php echo $d['id_desenvolvedora']; ?>" <?php echo $jogo['id_desenvolvedora']==$d['id_desenvolvedora']?'selected':''; ?>><?php echo htmlspecialchars($d['nome']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="support-form-group">
        <label class="support-form-label">Publicadora</label>
        <select class="support-form-input support-form-select" name="id_publicadora">
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
      <a href="<?php echo base_url('?page=admin&action=jogos'); ?>" class="btn-secondary">Cancelar</a>
    </div>
  </form>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>