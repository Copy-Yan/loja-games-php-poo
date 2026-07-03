<?php
$title = 'Adicionar Jogo - Gamestormy';

// Fallbacks para evitar warnings caso o controller não injete as listas.
// (O AdminController::addJogo() deve preencher $desenvolvedoras, $publicadoras e $categorias.)
$desenvolvedoras = $desenvolvedoras ?? [];
$publicadoras = $publicadoras ?? [];
$categorias = $categorias ?? [];
$plataformas = $plataformas ?? [];


require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/navbar.php';
?>

<main class="container page-section" aria-label="Adicionar Jogo">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 class="page-title">➕ Adicionar Novo Jogo</h1>
    <a href="<?php echo base_url('?page=admin&action=jogos'); ?>" class="btn-secondary">← Voltar</a>
  </div>

  <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
  <?php if (!empty($erro)): ?><div class="alert alert-error"><?php echo $erro; ?></div><?php endif; ?>

  <!-- Exemplo Real: Stardew Valley -->
  <details style="margin-bottom:24px;background:rgba(0,188,94,.1);border:1px solid rgba(0,188,94,.3);border-radius:12px;padding:16px;">
    <summary style="font-weight:700;color:var(--green);cursor:pointer;font-size:14px;">📋 Ver exemplo de jogo real (Stardew Valley)</summary>
    <div style="margin-top:12px;font-size:13px;color:rgba(255,255,255,.8);line-height:1.8;">
      <p><strong>Titulo:</strong> Stardew Valley</p>
      <p><strong>Descricao:</strong> Voce herdou a antiga fazenda do seu avo em Stardew Valley. Armado com ferramentas usadas e algumas moedas, voce parte para iniciar sua nova vida.</p>
      <p><strong>Preco:</strong> 24.99</p>
      <p><strong>Lancamento:</strong> 2016-02-26</p>
      <p><strong>Classificacao:</strong> L</p>
      <p><strong>Tamanho:</strong> 0.5 (500 MB)</p>
      <p><strong>Req. Minimos:</strong> Windows 7+, Intel Core 2 Duo 2GHz, 2GB RAM, 256MB VRAM, 500MB HD</p>
      <p><strong>Req. Recomendados:</strong> Windows 10, Intel Core i3, 4GB RAM, 512MB VRAM</p>
      <p><strong>Tag:</strong> Indie</p>
      <p><strong>Nota:</strong> 9.8</p>
      <p><strong>Categorias:</strong> Simulacao, RPG, Indie</p>
    </div>
  </details>

  <form method="POST" action="<?php echo base_url('?page=admin&action=addJogo'); ?>" enctype="multipart/form-data" style="background:rgba(255,255,255,.04);border-radius:16px;padding:28px;border:1px solid rgba(255,255,255,.08);">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

      <div style="grid-column:1/-1;">
        <label class="support-form-label">Capa do Jogo (imagem)</label>
        <input type="file" name="capa" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" style="background:rgba(255,255,255,.06);border:1px dashed rgba(255,255,255,.2);border-radius:8px;padding:12px;font-size:13px;color:var(--white);width:100%;"/>
        <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:4px;">Formatos: JPG, PNG, GIF, WEBP. Se nao enviar, usara cor padrao.</p>
      </div>

      <div style="grid-column:1/-1;">
        <label class="support-form-label">Titulo *</label>
        <input class="support-form-input" type="text" name="titulo" placeholder="Ex: Stardew Valley" required/>
      </div>

      <div style="grid-column:1/-1;">
        <label class="support-form-label">Descricao *</label>
        <textarea class="support-form-input support-form-textarea" name="descricao" placeholder="Ex: Voce herdou a antiga fazenda do seu avo..." required></textarea>
      </div>

      <!-- Desenvolvedora e Publicadora com dropdown real -->
      <div>
        <label class="support-form-label">Desenvolvedora *</label>
        <select class="support-form-input support-form-select" name="id_desenvolvedora" required style="color:#000;">
          <option value="">-- Selecione --</option>
          <?php foreach ($desenvolvedoras as $d): ?>
          <option value="<?php echo $d['id_desenvolvedora']; ?>"><?php echo htmlspecialchars($d['nome']); ?> (<?php echo htmlspecialchars($d['pais']); ?>)</option>
          <?php endforeach; ?>
        </select>
        <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:4px;">
          <a href="<?php echo base_url('?page=admin&action=addDesenvolvedora'); ?>" style="color:var(--purple-lt);">+ Cadastrar nova desenvolvedora</a>
        </p>
      </div>

      <div>
        <label class="support-form-label">Publicadora *</label>
<select class="support-form-input support-form-select" name="id_publicadora" required style="color:#000;">
          <option value="">-- Selecione --</option>
          <?php foreach ($publicadoras as $p): ?>
          <option value="<?php echo $p['id_publicadora']; ?>"><?php echo htmlspecialchars($p['nome']); ?> (<?php echo htmlspecialchars($p['pais']); ?>)</option>
          <?php endforeach; ?>
        </select>
        <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:4px;">
          <a href="<?php echo base_url('?page=admin&action=addPublicadora'); ?>" style="color:var(--purple-lt);">+ Cadastrar nova publicadora</a>
        </p>
      </div>

      <div>
        <label class="support-form-label">Preco (R$) *</label>
        <input class="support-form-input" type="number" name="preco" step="0.01" min="0" placeholder="24.99" required/>
      </div>

      <div>
        <label class="support-form-label">Data de Lancamento *</label>
        <input class="support-form-input" type="date" name="data_lancamento" required/>
      </div>

      <div>
        <label class="support-form-label">Classificacao Etaria</label>
        <select class="support-form-input support-form-select" name="classificacao_etaria">
          <option value="L" required style="color:#000;">L - Livre </option> 
          <option value="10" required style="color:#000;">10 anos</option>
          <option value="12" required style="color:#000;">12 anos</option>
          <option value="14" required style="color:#000;">14 anos</option>
          <option value="16" required style="color:#000;">16 anos</option>
          <option value="18" required style="color:#000;">18 anos</option>
        </select>
      </div>

      <div>
        <label class="support-form-label">Tamanho Download (GB)</label>
        <input class="support-form-input" type="number" name="tamanho_download" step="0.1" min="0" placeholder="0.5"/>
      </div>

      <div style="grid-column:1/-1;">
        <label class="support-form-label">Requisitos Minimos</label>
        <input class="support-form-input" type="text" name="requisitos_minimos" placeholder="Ex: Windows 7+, Intel Core 2 Duo 2GHz, 2GB RAM, 256MB VRAM, 500MB HD"/>
      </div>

      <div style="grid-column:1/-1;">
        <label class="support-form-label">Requisitos Recomendados</label>
        <input class="support-form-input" type="text" name="requisitos_recomendados" placeholder="Ex: Windows 10, Intel Core i3, 4GB RAM, 512MB VRAM"/>
      </div>

      <div>
        <label class="support-form-label">Tag</label>
        <select class="support-form-input support-form-select" name="tag">
          <option value="Jogo" required style="color:#000;">Jogo</option>
          <option value="Oferta da semana" required style="color:#000;">Oferta da semana</option>
          <option value="Novo lancamento" required style="color:#000;">Novo lancamento</option>
          <option value="Promocao" required style="color:#000;">Promocao</option>
          <option value="Destaque" required style="color:#000;">Destaque</option>
          <option value="Aventura" required style="color:#000;">Aventura</option>
          <option value="Acao" required style="color:#000;">Acao</option>
          <option value="Indie" required style="color:#000;">Indie</option>
          <option value="Cozy" required style="color:#000;">Cozy</option>
          <option value="Terror" required style="color:#000;">Terror</option>
          <option value="RPG" required style="color:#000;">RPG</option>
          <option value="Estrategia" required style="color:#000;">Estrategia</option>
          <option value="Simulacao" required style="color:#000;">Simulacao</option>
          <option value="Premium" required style="color:#000;">Premium</option>
        </select>
      </div>

      <div>
        <label class="support-form-label">Nota (0-10)</label>
        <input class="support-form-input" type="number" name="nota" step="0.1" min="0" max="10" placeholder="9.5"/>
      </div>

      <div style="grid-column:1/-1;">
        <label class="support-form-label">Categorias</label>
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:8px;">
          <?php foreach ($categorias as $cat): ?>
          <label style="display:flex;align-items:center;gap:6px;background:rgba(255,255,255,.06);padding:6px 12px;border-radius:6px;cursor:pointer;font-size:13px;">
            <input type="checkbox" name="categorias[]" value="<?php echo $cat['id_categoria']; ?>" style="width:16px;height:16px;"/>
            <?php echo htmlspecialchars($cat['nome']); ?>
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

    </div>

    <div style="margin-top:24px;display:flex;gap:10px;">
      <button type="submit" class="btn-primary">💾 Salvar Jogo</button>
      <a href="<?php echo base_url('?page=admin&action=jogos'); ?>" class="btn-secondary">Cancelar</a>
    </div>
  </form>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>