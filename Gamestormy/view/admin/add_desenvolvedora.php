<?php
$title = 'Cadastrar Desenvolvedora - Gamestormy';
$erro = $erro ?? '';
$success = $success ?? '';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/navbar.php';
?>

<main class="container page-section" aria-label="Cadastrar Desenvolvedora">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 class="page-title">➕ Cadastrar Desenvolvedora</h1>
    <a href="<?php echo base_url('?page=admin&action=addJogo'); ?>" class="btn-secondary">← Voltar</a>
  </div>

  <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
  <?php if (!empty($erro)): ?><div class="alert alert-error"><?php echo $erro; ?></div><?php endif; ?>

  <form method="POST" action="<?php echo base_url('?page=admin&action=addDesenvolvedora'); ?>" style="background:rgba(255,255,255,.04);border-radius:16px;padding:28px;border:1px solid rgba(255,255,255,.08);">

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div style="grid-column:1/-1;">
        <label class="support-form-label">Nome *</label>
        <input class="support-form-input" type="text" name="nome" placeholder="Ex: Storm Studios" required value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>"/>
      </div>

      <div>
        <label class="support-form-label">Data de Fundação *</label>
        <input class="support-form-input" type="date" name="data_fundacao" required value="<?php echo htmlspecialchars($_POST['data_fundacao'] ?? ''); ?>"/>
      </div>

      <div>
        <label class="support-form-label">País *</label>
        <input class="support-form-input" type="text" name="pais" placeholder="Ex: Brasil" required value="<?php echo htmlspecialchars($_POST['pais'] ?? ''); ?>"/>
      </div>
    </div>

    <div style="margin-top:24px;display:flex;gap:10px;">
      <button type="submit" class="btn-primary">💾 Salvar Desenvolvedora</button>
      <a href="<?php echo base_url('?page=admin&action=addJogo'); ?>" class="btn-secondary">Cancelar</a>
    </div>
  </form>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

