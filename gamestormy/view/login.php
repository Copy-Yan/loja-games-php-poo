<?php
$title = 'Login - Games Stormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="auth-page" aria-label="Login">
  <div class="auth-card">
    <h2 style="text-align:center;margin-bottom:24px;font-size:22px;">Entrar na Games Stormy</h2>
    <?php if ($erro): ?><div class="alert alert-error"><?php echo $erro; ?></div><?php endif; ?>
    <?php $flash = flash('success'); if ($flash): ?><div class="alert alert-success"><?php echo $flash; ?></div><?php endif; ?>
    <form method="POST" action="<?php echo base_url('?page=usuario&action=login'); ?>">
      <label class="auth-field-label" for="login-email">E-mail</label>
      <input class="auth-input" id="login-email" name="email" type="email" placeholder="email@exemplo.com" required autocomplete="email"/>

      <label class="auth-field-label" for="login-pw">Senha</label>
      <input class="auth-input" id="login-pw" name="senha" type="password" placeholder="••••••••" required autocomplete="current-password"/>

      <div class="auth-submit-row">
        <button type="submit" class="auth-submit">ENTRAR</button>
      </div>
    </form>
    <div class="auth-footer">
      <span class="auth-footer-text">Não tem uma conta?</span>
      <a href="<?php echo base_url('?page=usuario&action=register'); ?>" class="auth-footer-link">Registre-se</a>
    </div>
  </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
