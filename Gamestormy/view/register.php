<?php
$title = 'Cadastro - Gamestormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="auth-page" aria-label="Cadastro">
  <div class="auth-card auth-card-wide">
    <h2 style="text-align:center;margin-bottom:24px;font-size:22px;">Criar conta</h2>
    <?php $erro = $erro ?? ''; if ($erro): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form method="POST" action="<?php echo base_url('?page=usuario&action=register'); ?>">
      <label class="auth-field-label" for="reg-username">Nome completo</label>
      <input class="auth-input" id="reg-username" name="nome" type="text" placeholder="Ex: João Silva" required autocomplete="name"/>

      <label class="auth-field-label" for="reg-nick">Nickname</label>
      <input class="auth-input" id="reg-nick" name="nickname" type="text" placeholder="Ex: StormyPlayer" required autocomplete="username"/>

      <label class="auth-field-label" for="reg-email">E-mail</label>
      <input class="auth-input" id="reg-email" name="email" type="email" placeholder="email@exemplo.com" required autocomplete="email"/>

      <label class="auth-field-label" for="reg-pw">Senha</label>
      <input class="auth-input" id="reg-pw" name="senha" type="password" placeholder="••••••••" required autocomplete="new-password"/>

      <label class="auth-field-label" for="reg-confirm">Confirme a senha</label>
      <input class="auth-input" id="reg-confirm" name="confirma" type="password" placeholder="••••••••" required autocomplete="new-password"/>

      <label class="auth-field-label">Data de nascimento</label>
      <div class="register-date-row">
        <select class="register-date-select" name="dia" required>
          <option value="">Dia</option>
          <?php for($i=1;$i<=31;$i++) echo "<option value='$i'>$i</option>"; ?>
        </select>
        <select class="register-date-select" name="mes" required>
          <option value="">Mês</option>
          <?php
          $meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
          foreach ($meses as $idx => $m) {
            $v = $idx+1;
            echo "<option value='$v'>$m</option>";
          }
          ?>
        </select>
        <select class="register-date-select" name="ano" required>
          <option value="">Ano</option>
          <?php for($y=2025;$y>=1930;$y--) echo "<option value='$y'>$y</option>"; ?>
        </select>
      </div>

      <div class="auth-submit-row">
        <button type="submit" class="auth-submit">CADASTRAR</button>
      </div>
    </form>
    <div class="auth-footer">
      <span class="auth-footer-text">Já possui uma conta?</span>
      <a href="<?php echo base_url('?page=usuario&action=login'); ?>" class="auth-footer-link">Faça login</a>
    </div>
  </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
