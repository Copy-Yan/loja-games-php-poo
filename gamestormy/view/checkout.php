<?php
$title = 'Pagamento - Games Stormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main class="page-section" aria-label="Pagamento">

  <!-- Checkout stepper -->
  <div class="checkout-header">
    <div class="checkout-logo">
      <svg width="36" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
    </div>
    <div class="checkout-steps">
      <div class="step done"><div class="step-dot"></div><span>Carrinho</span></div>
      <div class="step-line done-line"></div>
      <div class="step active"><div class="step-dot"></div><span>Pagamento</span></div>
      <div class="step-line"></div>
      <div class="step"><div class="step-dot"></div><span>Confirmação</span></div>
    </div>
  </div>

  <?php if (!empty($erro)): ?>
    <div class="alert alert-error" style="max-width:1200px;margin:20px auto;padding:0 40px;"><?php echo $erro; ?></div>
  <?php endif; ?>

  <form method="POST" action="<?php echo base_url('?page=carrinho&action=checkout'); ?>" class="payment-layout">

    <!-- Left: buyer + payment method -->
    <div class="payment-left">
      <h2 class="payment-section-title">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        PAGAMENTO
      </h2>

      <!-- Buyer info -->
      <div class="payment-block">
        <div class="payment-block-title">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Dados do Comprador
        </div>
        <label class="pay-label">Nome Completo</label>
        <input class="pay-input" type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome_usuario'] ?? ''); ?>" placeholder="Seu nome completo" required/>
        <label class="pay-label">E-mail</label>
        <input class="pay-input" type="email" name="email" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" placeholder="email@exemplo.com" required/>
        <label class="pay-label">Telefone</label>
        <input class="pay-input" type="tel" name="telefone" placeholder="(00) 00000-0000" />
      </div>

      <!-- Payment method -->
      <div class="payment-block">
        <div class="payment-block-title">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          Forma de Pagamento
        </div>
        <div class="pay-methods">
          <label class="pay-method-opt">
            <input type="radio" name="metodo" value="cartao" checked/>
            <div class="pay-method-card">
              <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
              <span>Cartão de Crédito</span>
            </div>
          </label>
          <label class="pay-method-opt">
            <input type="radio" name="metodo" value="pix"/>
            <div class="pay-method-card">
              <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M4 12l4-4 4 4-4 4z"/><path d="M12 4l4 4-4 4-4-4z"/><path d="M12 12l4 4-4 4-4-4z"/><path d="M20 12l-4-4-4 4 4 4z"/></svg>
              <span>PIX</span>
            </div>
          </label>
          <label class="pay-method-opt">
            <input type="radio" name="metodo" value="boleto"/>
            <div class="pay-method-card">
              <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              <span>BOLETO</span>
            </div>
          </label>
        </div>
      </div>

      <!-- Card fields -->
      <div class="payment-block" id="pay-card-fields">
        <div class="payment-block-title">Informações do Cartão</div>
        <label class="pay-label">Número do cartão</label>
        <input class="pay-input pay-input-mono" type="text" placeholder="---- ---- ---- ----" maxlength="19"/>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px">
          <div>
            <label class="pay-label">Nome no Cartão</label>
            <input class="pay-input" type="text" placeholder="Como no cartão"/>
          </div>
          <div>
            <label class="pay-label">Validade</label>
            <input class="pay-input pay-input-mono" type="text" placeholder="MM/AA" maxlength="5"/>
          </div>
          <div>
            <label class="pay-label">CVV</label>
            <input class="pay-input pay-input-mono" type="text" placeholder="---" maxlength="4"/>
          </div>
        </div>
      </div>

      <!-- PIX fields -->
      <div class="payment-block" id="pay-pix-fields" style="display:none">
        <div class="payment-block-title">Pagamento via PIX</div>
        <p style="font-size:13px;color:#2a2a2a;margin-bottom:12px;">Ao finalizar, você receberá um QR Code para pagamento instantâneo.</p>
        <div class="pix-qr-block">
          <div class="pix-qr-code" aria-label="QR Code PIX">
            <svg viewBox="0 0 100 100" width="80" height="80" fill="currentColor">
              <rect x="5" y="5" width="35" height="35" rx="3" fill="none" stroke="currentColor" stroke-width="4"/>
              <rect x="14" y="14" width="17" height="17" rx="1"/>
              <rect x="60" y="5" width="35" height="35" rx="3" fill="none" stroke="currentColor" stroke-width="4"/>
              <rect x="69" y="14" width="17" height="17" rx="1"/>
              <rect x="5" y="60" width="35" height="35" rx="3" fill="none" stroke="currentColor" stroke-width="4"/>
              <rect x="14" y="69" width="17" height="17" rx="1"/>
              <rect x="60" y="60" width="8" height="8"/><rect x="72" y="60" width="8" height="8"/><rect x="84" y="60" width="8" height="8"/>
              <rect x="60" y="72" width="8" height="8"/><rect x="84" y="72" width="8" height="8"/>
              <rect x="60" y="84" width="8" height="8"/><rect x="72" y="84" width="8" height="8"/><rect x="84" y="84" width="8" height="8"/>
              <rect x="45" y="5" width="8" height="8"/><rect x="45" y="17" width="8" height="8"/><rect x="45" y="29" width="8" height="8"/>
              <rect x="5" y="45" width="8" height="8"/><rect x="17" y="45" width="8" height="8"/><rect x="29" y="45" width="8" height="8"/>
              <rect x="45" y="45" width="8" height="8"/><rect x="57" y="45" width="8" height="8"/>
            </svg>
          </div>
          <div class="pix-qr-text">
            <strong>ESCANEIE O QR CODE</strong>
            <p>Abra o app do seu banco, escaneie e pague. O pagamento é aprovado em poucos segundos!</p>
          </div>
        </div>
      </div>

      <!-- Boleto fields -->
      <div class="payment-block" id="pay-boleto-fields" style="display:none">
        <div class="payment-block-title">Informações do Boleto</div>
        <p style="font-size:13px;color:#2a2a2a;margin-bottom:12px;">O boleto será gerado com vencimento em 3 dias úteis.</p>
        <label class="pay-label">CPF/CNPJ</label>
        <input class="pay-input" type="text" placeholder="000.000.000-00"/>
        <label class="pay-label">Vencimento</label>
        <input class="pay-input pay-input-mono" type="text" value="<?php echo date('d/m/Y', strtotime('+3 days')); ?>" readonly/>
      </div>
    </div>

    <!-- Right: order summary -->
    <div class="payment-right">
      <div class="order-summary-box">
        <div class="order-summary-title">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
          Resumo do Pedido
        </div>
        <table class="order-table">
          <thead>
            <tr><th>Produto</th><th>QTD</th><th>TOTAL</th></tr>
          </thead>
          <tbody>
            <?php foreach ($carrinho as $item): ?>
            <tr>
              <td class="order-product-cell">
                <div class="order-thumb" style="background:<?php echo htmlspecialchars($item['capa'] ?? '#555'); ?>;background-size:cover;background-position:center;">
                  <?php echo empty($item['capa']) || strpos($item['capa'], 'assets/') !== 0 ? 'Capa' : ''; ?>
                </div>
                <span><?php echo htmlspecialchars($item['titulo']); ?></span>
              </td>
              <td class="order-qty"><?php echo $item['qty']; ?></td>
              <td class="order-total">R$ <?php echo number_format($item['preco'] * $item['qty'], 2, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr class="order-subtotal"><td colspan="2">SUBTOTAL</td><td>R$ <?php echo number_format(totalCarrinho(), 2, ',', '.'); ?></td></tr>
            <tr class="order-total-row"><td colspan="2">TOTAL</td><td>R$ <?php echo number_format(totalCarrinho(), 2, ',', '.'); ?></td></tr>
          </tfoot>
        </table>
      </div>

      <a href="<?php echo base_url('?page=carrinho'); ?>" class="pay-back-btn">← VOLTAR AO CARRINHO</a>
      <button type="submit" class="pay-finish-btn">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        FINALIZAR PAGAMENTO
      </button>
    </div>
  </form>
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

.payment-layout {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 28px;
  padding: 28px 40px;
  align-items: start;
  max-width: 1200px;
  margin: 0 auto;
}

.payment-section-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--white);
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 20px;
}

.payment-block {
  background: var(--pink);
  border-radius: 10px;
  padding: 18px 20px;
  margin-bottom: 16px;
}
.payment-block-title {
  font-size: 13px;
  font-weight: 700;
  color: #1a1a1a;
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 14px;
}

.pay-label {
  font-size: 11px;
  font-weight: 600;
  color: #2a2a2a;
  display: block;
  margin-bottom: 4px;
  margin-top: 10px;
}
.pay-label:first-of-type { margin-top: 0; }
.pay-input {
  width: 100%;
  background: var(--blue-lt);
  border: none;
  border-radius: 4px;
  height: 34px;
  padding: 0 10px;
  font-size: 12px;
  color: #1a3d5c;
  font-weight: 500;
  transition: background .15s;
}
.pay-input:focus { background: #9dc3ea; }
.pay-input-mono { font-family: monospace; letter-spacing: .1em; }

.pay-methods {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;
}
.pay-method-opt input[type="radio"] { display: none; }
.pay-method-card {
  background: rgba(255,255,255,.35);
  border: 2px solid transparent;
  border-radius: 8px;
  padding: 10px 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
  font-size: 10px;
  font-weight: 700;
  color: #1a1a1a;
  text-align: center;
  cursor: pointer;
  transition: border-color .15s, background .15s;
}
.pay-method-opt input:checked + .pay-method-card {
  border-color: var(--purple);
  background: rgba(255,255,255,.6);
}
.pay-method-card:hover { background: rgba(255,255,255,.5); }

.pix-qr-block {
  margin-top: 16px;
  background: rgba(255,255,255,.45);
  border-radius: 10px;
  padding: 16px;
  display: flex;
  align-items: center;
  gap: 16px;
}
.pix-qr-code {
  width: 90px;
  height: 90px;
  background: var(--white);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: #000;
}
.pix-qr-text strong {
  font-size: 12px;
  font-weight: 700;
  color: #1a1a1a;
  display: block;
  margin-bottom: 6px;
}
.pix-qr-text p {
  font-size: 11px;
  color: #2a2a2a;
  line-height: 1.5;
}

.order-summary-box {
  background: var(--pink);
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 14px;
}
.order-summary-title {
  background: rgba(0,0,0,.08);
  padding: 12px 16px;
  font-size: 14px;
  font-weight: 700;
  color: #1a1a1a;
  display: flex;
  align-items: center;
  gap: 8px;
}
.order-table {
  width: 100%;
  border-collapse: collapse;
}
.order-table thead tr { background: rgba(0,0,0,.06); }
.order-table thead th {
  padding: 10px 14px;
  font-size: 12px;
  font-weight: 700;
  color: #1a1a1a;
  text-align: center;
}
.order-table thead th:first-child { text-align: left; }
.order-table tbody tr { border-bottom: 1px solid rgba(0,0,0,.06); }
.order-table tbody td { padding: 10px 14px; }
.order-product-cell { display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 600; color: #1a1a1a; }
.order-thumb {
  width: 42px;
  height: 36px;
  background: rgba(255,255,255,.6);
  border-radius: 4px;
  font-size: 9px;
  color: #888;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  flex-shrink: 0;
  border: 1px solid rgba(0,0,0,.1);
}
.order-qty, .order-total { text-align: center; font-size: 12px; font-weight: 600; color: #1a1a1a; }
.order-subtotal td, .order-total-row td {
  padding: 10px 14px;
  font-size: 12px;
  font-weight: 700;
  text-align: center;
  color: #1a1a1a;
}
.order-subtotal { background: rgba(0,0,0,.04); }
.order-total-row { background: rgba(0,0,0,.08); }

.pay-back-btn {
  width: 100%;
  background: transparent;
  border: 2px solid var(--white);
  color: var(--white);
  border-radius: 6px;
  padding: 10px;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .04em;
  cursor: pointer;
  margin-bottom: 10px;
  transition: background .15s;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.pay-back-btn:hover { background: rgba(255,255,255,.1); }
.pay-finish-btn {
  width: 100%;
  background: var(--pink);
  color: #1a1a1a;
  border: none;
  border-radius: 6px;
  padding: 12px;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: .04em;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background .15s;
}
.pay-finish-btn:hover { background: #f090cc; }

@media (max-width: 860px) {
  .payment-layout { grid-template-columns: 1fr; padding: 16px; }
  .pay-methods { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .checkout-steps { gap: 2px; }
  .step-line { width: 30px; }
}
</style>

<script>
// Switch payment method visibility
const radios = document.querySelectorAll('input[name="metodo"]');
const cardFields = document.getElementById('pay-card-fields');
const pixFields = document.getElementById('pay-pix-fields');
const boletoFields = document.getElementById('pay-boleto-fields');

radios.forEach(r => {
  r.addEventListener('change', function() {
    const val = this.value;
    cardFields.style.display = (val === 'cartao') ? 'block' : 'none';
    pixFields.style.display = (val === 'pix') ? 'block' : 'none';
    boletoFields.style.display = (val === 'boleto') ? 'block' : 'none';
  });
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>