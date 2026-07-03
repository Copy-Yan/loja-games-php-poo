<?php
$title = 'Suporte - Gamestormy';
$success = $success ?? '';
$tickets = $tickets ?? [];

require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="support-wrapper" aria-label="Suporte">
  <h1 class="page-title">Suporte</h1>
  <p class="about-text">Caso necessite reembolso ou tenha algum problema técnico, contate nosso suporte.</p>

  <div class="support-stats">
    <div class="support-stat">
      <div class="support-stat-title">Para solicitar reembolso:</div>
      <div class="support-stat-value">reembolso@gamestormy.com</div>
    </div>
    <div class="support-stat">
      <div class="support-stat-title">Para relatar problemas:</div>
      <div class="support-stat-value">problemas@gamestormy.com</div>
    </div>
  </div>

  <?php if ($success): ?>
    <div class="checkout-success" style="padding:40px 0;">
      <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="var(--green)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <h3>Mensagem enviada!</h3>
      <p>Obrigado pelo contato. Responderemos em até 48 horas no e-mail informado.</p>
      <a href="<?php echo base_url('?page=suporte'); ?>" class="btn-primary" style="max-width:220px;">Nova mensagem</a>
    </div>
  <?php else: ?>
    <div class="support-form">
      <h2 style="font-size:20px;font-weight:700;margin-bottom:6px;">Enviar mensagem</h2>
      <p style="font-size:13px;color:rgba(255,255,255,.5);margin-bottom:24px;">Preencha os campos abaixo e entraremos em contato em até 48 horas.</p>

      <form method="POST" action="<?php echo base_url('?page=suporte'); ?>">
        <div class="support-form-grid">
          <div class="support-form-group">
            <label class="support-form-label" for="support-name">Nome</label>
            <input class="support-form-input" id="support-name" name="nome" type="text" placeholder="Seu nome completo" required/>
          </div>
          <div class="support-form-group">
            <label class="support-form-label" for="support-email">E-mail</label>
            <input class="support-form-input" id="support-email" name="email" type="email" placeholder="seu@email.com" required/>
          </div>
          <div class="support-form-group">
            <label class="support-form-label" for="support-subject">Assunto</label>
            <select class="support-form-input support-form-select" id="support-subject" name="assunto" required>
              <option value="">Selecione um assunto</option>
              <option value="Reembolso">Reembolso</option>
              <option value="Problema técnico">Problema técnico</option>
              <option value="Minha conta">Minha conta</option>
              <option value="Pagamento">Pagamento</option>
              <option value="Outro">Outro</option>
            </select>
          </div>
          <div class="support-form-group full">
            <label class="support-form-label" for="support-message">Mensagem</label>
            <textarea class="support-form-input support-form-textarea" id="support-message" name="mensagem" placeholder="Descreva seu problema ou dúvida em detalhes..." required></textarea>
          </div>
        </div>
        <button type="submit" class="btn-primary" style="margin-top:16px;">Enviar Mensagem</button>
      </form>
    </div>
  <?php endif; ?>

  <?php if (!empty($tickets)): ?>
  <section style="margin-top:40px;">
    <h2 class="section-title">Seus chamados</h2>
    <div style="display:flex;flex-direction:column;gap:10px;">
      <?php foreach ($tickets as $t): ?>
      <div style="background:rgba(255,255,255,.04);border-radius:10px;padding:14px 18px;border-left:3px solid var(--purple);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
          <span style="font-weight:700;font-size:14px;"><?php echo htmlspecialchars($t['assunto']); ?></span>
          <span style="font-size:11px;padding:2px 8px;border-radius:4px;background:rgba(255,255,255,.1);"><?php echo $t['status']; ?></span>
        </div>
        <div style="font-size:12px;color:rgba(255,255,255,.5);"><?php echo $t['categoria']; ?> • <?php echo date('d/m/Y H:i', strtotime($t['data_abertura'])); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
