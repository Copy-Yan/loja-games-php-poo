<?php
$title = 'Pedido Confirmado - Games Stormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="page-section" aria-label="Confirmação do pedido">

  <!-- Checkout stepper -->
  <div class="checkout-header">
    <div class="checkout-logo">
      <svg width="36" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
    </div>
    <div class="checkout-steps">
      <div class="step done"><div class="step-dot"></div><span>Carrinho</span></div>
      <div class="step-line done-line"></div>
      <div class="step done"><div class="step-dot"></div><span>Pagamento</span></div>
      <div class="step-line done-line"></div>
      <div class="step active cyan"><div class="step-dot"></div><span>Confirmação</span></div>
    </div>
  </div>

  <div class="confirmation-wrap">
    <!-- Check icon -->
    <div class="confirm-check-wrap">
      <div class="confirm-check">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
    </div>

    <h1 class="confirm-title">PEDIDO REALIZADO<br/>COM SUCESSO!</h1>
    <p class="confirm-sub">Obrigado por comprar na GameStormy.<br/>Seu pedido foi registrado com sucesso.</p>

    <!-- Order number -->
    <div class="confirm-order-num">
      <div class="confirm-order-label">Número do Pedido</div>
      <div class="confirm-order-id">#<?php echo str_pad($pedido['id_pedido'] ?? '00000', 5, '0', STR_PAD_LEFT); ?></div>
    </div>

    <!-- Order summary table -->
    <div class="confirm-table-wrap">
      <div class="confirm-table-title">Resumo do Pedido</div>
      <table class="confirm-table">
        <thead>
          <tr><th>Produto</th><th>Quantidade</th><th>TOTAL</th></tr>
        </thead>
        <tbody>
          <?php foreach (($pedido['itens'] ?? []) as $item): ?>
          <tr>
            <td class="confirm-product-cell">
              <div class="confirm-thumb" style="background:<?php echo htmlspecialchars($item['capa'] ?? '#555'); ?>;background-size:cover;background-position:center;">
                <?php echo empty($item['capa']) || strpos($item['capa'], 'assets/') !== 0 ? 'Capa' : ''; ?>
              </div>
              <span><?php echo htmlspecialchars($item['titulo']); ?></span>
            </td>
            <td class="confirm-qty"><?php echo $item['qty']; ?></td>
            <td class="confirm-total">R$ <?php echo number_format($item['preco'] * $item['qty'], 2, ',', '.'); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr class="confirm-total-row">
            <td colspan="2" style="text-align:right;padding-right:16px;color:var(--purple-lt);font-weight:700">TOTAL PAGO</td>
            <td>R$ <?php echo number_format($pedido['total'] ?? 0, 2, ',', '.'); ?></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-bottom:20px;">
      <div style="background:rgba(255,255,255,.06);border-radius:8px;padding:12px 20px;text-align:center;">
        <div style="font-size:11px;color:rgba(255,255,255,.5);margin-bottom:4px;">Método de Pagamento</div>
        <div style="font-size:14px;font-weight:700;color:var(--white);">
          <?php 
          $metodos = ['cartao' => 'Cartão de Crédito', 'pix' => 'PIX', 'boleto' => 'Boleto'];
          echo $metodos[$pedido['metodo'] ?? 'pix'] ?? 'PIX';
          ?>
        </div>
      </div>
      <div style="background:rgba(255,255,255,.06);border-radius:8px;padding:12px 20px;text-align:center;">
        <div style="font-size:11px;color:rgba(255,255,255,.5);margin-bottom:4px;">Data</div>
        <div style="font-size:14px;font-weight:700;color:var(--white);"><?php echo $pedido['data'] ?? date('d/m/Y H:i'); ?></div>
      </div>
    </div>

    <a href="<?php echo base_url(''); ?>" class="confirm-home-btn">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      IR PARA O INÍCIO
    </a>
    <a href="<?php echo base_url('?page=biblioteca'); ?>" class="btn-primary" style="margin-top:12px;display:inline-flex;">
      📚 Ver Minha Biblioteca
    </a>
  </div>
</main>

<style>
.checkout-header {
  background: var(--purple);
  display: flex;
  align-items: center;
  padding: 0 28px;
  height: 64px;
  gap: 0;
}
.checkout-logo { 
  width: 36px; 
  height: 44px; 
  flex-shrink: 0; 
  color: var(--white);
  display: flex;
  align-items: center;
}
.checkout-logo svg { width: 100%; height: 100%; }

.checkout-steps {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
}
.step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}
.step-dot {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: rgba(255,255,255,.3);
  border: 2px solid rgba(255,255,255,.5);
  transition: background .2s, border-color .2s;
}
.step span {
  font-size: 12px;
  font-weight: 600;
  color: rgba(255,255,255,.6);
  white-space: nowrap;
}
.step.active .step-dot {
  background: var(--pink);
  border-color: var(--pink);
}
.step.active span { color: var(--white); }
.step.active.cyan .step-dot {
  background: #00e5ff;
  border-color: #00e5ff;
}
.step.done .step-dot {
  background: var(--purple-lt);
  border-color: var(--purple-lt);
}
.step.done span { color: rgba(255,255,255,.85); }
.step-line {
  width: 80px;
  height: 2px;
  background: rgba(255,255,255,.2);
  margin-bottom: 16px;
  flex-shrink: 0;
}
.step-line.done-line { background: var(--purple-lt); }

.confirmation-wrap {
  max-width: 640px;
  margin: 0 auto;
  padding: 40px 24px;
  text-align: center;
}
.confirm-check-wrap {
  display: flex;
  justify-content: center;
  margin-bottom: 24px;
}
.confirm-check {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  border: 4px solid var(--white);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--white);
}
.confirm-title {
  font-size: 26px;
  font-weight: 700;
  color: var(--purple-lt);
  line-height: 1.25;
  margin-bottom: 12px;
  text-transform: uppercase;
}
.confirm-sub {
  font-size: 14px;
  color: var(--purple-lt);
  line-height: 1.6;
  margin-bottom: 28px;
}
.confirm-order-num {
  background: var(--cyan);
  border-radius: 8px;
  padding: 14px 24px;
  margin-bottom: 20px;
  display: inline-block;
}
.confirm-order-label {
  font-size: 13px;
  font-weight: 600;
  color: var(--purple);
  margin-bottom: 4px;
}
.confirm-order-id {
  font-size: 28px;
  font-weight: 700;
  color: #d63384;
}
.confirm-table-wrap {
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 28px;
  border: 1px solid rgba(255,255,255,.1);
}
.confirm-table-title {
  background: var(--blue-lt);
  padding: 12px 18px;
  font-size: 14px;
  font-weight: 700;
  color: var(--purple);
  text-align: center;
}
.confirm-table {
  width: 100%;
  border-collapse: collapse;
  background: #3a3a3a;
}
.confirm-table thead tr { background: #444; }
.confirm-table thead th {
  padding: 12px 16px;
  font-size: 13px;
  font-weight: 700;
  color: var(--white);
  text-align: center;
}
.confirm-table thead th:first-child { text-align: left; }
.confirm-table tbody tr { border-bottom: 1px solid rgba(255,255,255,.06); }
.confirm-table tbody td { padding: 14px 16px; }
.confirm-product-cell { display: flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 600; color: var(--white); text-align: left; }
.confirm-thumb {
  width: 56px;
  height: 44px;
  background: #555;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 9px;
  color: #aaa;
  text-align: center;
  flex-shrink: 0;
  border: 1px solid rgba(255,255,255,.15);
}
.confirm-qty, .confirm-total { text-align: center; font-size: 13px; font-weight: 600; color: var(--white); }
.confirm-total-row td {
  padding: 12px 16px;
  font-size: 13px;
  font-weight: 700;
  color: var(--white);
  background: rgba(255,255,255,.05);
}
.confirm-home-btn {
  background: var(--pink);
  color: #1a1a1a;
  border: none;
  border-radius: 8px;
  padding: 14px 40px;
  font-size: 15px;
  font-weight: 700;
  letter-spacing: .05em;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  transition: background .15s;
  text-decoration: none;
}
.confirm-home-btn:hover { background: #f090cc; }

@media (max-width: 600px) {
  .checkout-steps { gap: 2px; }
  .step-line { width: 30px; }
  .confirmation-wrap { padding: 24px 16px; }
}
</style>

<?php require __DIR__ . '/partials/footer.php'; ?>