<?php
$title = 'Meu Perfil - Games Stormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="perfil-wrapper" aria-label="Perfil do usuário">
  <h1 class="page-title">Meu Perfil</h1>

  <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
  <?php if (!empty($erro)): ?><div class="alert alert-error"><?php echo $erro; ?></div><?php endif; ?>

  <!-- Preview da foto atual -->
  <div class="perfil-avatar-section">
    <div class="perfil-avatar">
      <?php if (!empty($usuario['foto_perfil'])): ?>
        <img src="<?php echo base_url($usuario['foto_perfil']) . '?' . time(); ?>" alt="Foto de perfil" onerror="this.style.display='none';this.parentNode.innerHTML='<svg viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.5\' style=\'padding:20px;color:#fff\'><path d=\'M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2\'/><circle cx=\'12\' cy=\'7\' r=\'4\'/></svg>';"/>
      <?php else: ?>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="padding:20px;color:#fff"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <?php endif; ?>
    </div>
    <div class="perfil-avatar-info">
      <h2><?php echo htmlspecialchars($usuario['nome_usuario']); ?></h2>
      <p>@<?php echo htmlspecialchars($usuario['nickname']); ?> • <?php echo htmlspecialchars($usuario['email']); ?></p>
      <?php if (!empty($usuario['foto_perfil'])): ?>
        <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:4px;">Foto salva em: <?php echo htmlspecialchars($usuario['foto_perfil']); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <form method="POST" action="<?php echo base_url('?page=usuario&action=perfil'); ?>" enctype="multipart/form-data">

    <!-- Upload de foto -->
    <div style="background:rgba(255,255,255,.04);border-radius:12px;padding:20px;margin-bottom:24px;border:1px solid rgba(255,255,255,.08);">
      <h3 style="font-size:14px;font-weight:700;margin-bottom:12px;color:var(--cyan);">📷 Alterar foto de perfil</h3>
      <div class="file-input-wrapper">
        <input type="file" name="foto" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" style="background:rgba(255,255,255,.06);border:1px dashed rgba(255,255,255,.2);border-radius:8px;padding:12px;font-size:13px;color:var(--white);width:100%;max-width:400px;"/>
      </div>
      <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:6px;">Formatos aceitos: JPG, PNG, GIF, WEBP. Tamanho máximo: 2MB.</p>
    </div>

    <label class="auth-field-label">Nome completo</label>
    <input class="auth-input" type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" required/>

    <label class="auth-field-label">Nickname</label>
    <input class="auth-input" type="text" name="nickname" value="<?php echo htmlspecialchars($usuario['nickname']); ?>" required/>

    <label class="auth-field-label">E-mail</label>
    <input class="auth-input" type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required/>

    <label class="auth-field-label">Data de nascimento</label>
    <input class="auth-input" type="date" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>" required/>

    <label class="auth-field-label">Nova senha (deixe em branco para não alterar)</label>
    <input class="auth-input" type="password" name="nova_senha" placeholder="••••••••" autocomplete="new-password"/>

    <div class="auth-submit-row">
      <button type="submit" class="auth-submit">SALVAR ALTERAÇÕES</button>
    </div>
  </form>

  <?php if (!empty($debug)): ?>
  <details style="margin-top:20px;">
    <summary style="font-size:12px;color:rgba(255,255,255,.4);cursor:pointer;">🔧 Informações de debug</summary>
    <pre style="background:#1a1a1a;border-radius:8px;padding:12px;font-size:11px;color:rgba(255,255,255,.6);margin-top:8px;overflow:auto;"><?php echo htmlspecialchars($debug); ?></pre>
  </details>
  <?php endif; ?>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>