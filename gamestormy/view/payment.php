<?php
$title = 'Pagamento - Gamestormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';

// Fallbacks para evitar warnings caso algum controller não injete as variáveis.
$usuario = $usuario ?? [];
$carrinho = $carrinho ?? [];
?>

<main id="page-payment" aria-label="Pagamento">

  <div class="checkout-header">
    <div class="checkout-steps">
      <div class="step done"><div class="step-dot"></div><span>Carrinho</span></div>
      <div class="step-line done-line"></div>
      <div class="step active"><div class="step-dot"></div><span>Pagamento</span></div>
      <div class="step-line"></div>
      <div class="step"><div class="step-dot"></div><span>Confirmação</span></div>
    </div>
  </div>

  <form method="POST" action="<?php echo base_url('?page=carrinho&action=checkout'); ?>">
    <div class="payment-layout">

      <!-- Left: buyer + payment method -->
      <div class="payment-left">
        <h2 class="payment-section-title">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          PAGAMENTO
        </h2>

        <!-- Buyer info -->
        <div class="payment-block">
          <label class="pay-label">Nome Completo</label>
          <input class="pay-input" type="text" name="nome" placeholder="Seu nome completo" value="<?php echo htmlspecialchars($usuario['nome_usuario'] ?? ''); ?>" required/>
          <label class="pay-label">E-mail</label>
          <input class="pay-input" type="email" name="email" placeholder="email@exemplo.com" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" required/>
          <label class="pay-label">Telefone</label>
          <input class="pay-input" type="tel" name="telefone" placeholder="(00) 00000-0000"/>
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
          <input class="pay-input pay-input-mono" type="text" name="cartao_numero" placeholder="---- ---- ---- ----" maxlength="19"/>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px">
            <div>
              <label class="pay-label">Nome no Cartão</label>
              <input class="pay-input" type="text" name="cartao_nome" placeholder="Como no cartão"/>
            </div>
            <div>
              <label class="pay-label">Validade</label>
              <input class="pay-input pay-input-mono" type="text" name="cartao_validade" placeholder="MM/AA" maxlength="5"/>
            </div>
            <div>
              <label class="pay-label">CVV</label>
              <input class="pay-input pay-input-mono" type="text" name="cartao_cvv" placeholder="---" maxlength="4"/>
            </div>
          </div>
        </div>

        <!-- PIX fields -->
        <div class="payment-block" id="pay-pix-fields" style="display:none">
          <div class="payment-block-title">Pagamento via PIX</div>
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
          <label class="pay-label">CPF/CNPJ</label>
          <input class="pay-input" type="text" name="boleto_cpf" placeholder="000.000.000-00"/>
          <label class="pay-label">Vencimento</label>
          <input class="pay-input pay-input-mono" type="text" value="<?php echo date('d/m/Y', strtotime('+3 days')); ?>" readonly/>
          <p style="font-size:11px;color:rgba(255,255,255,.5);margin-top:8px;">O boleto será gerado após a confirmação e vence em 3 dias.</p>
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
              <?php 
              $total = 0;
              foreach ($carrinho as $item): 
                $itemTotal = $item['preco'] * $item['qty'];
                $total += $itemTotal;
              ?>
              <tr>
                <td class="order-product-cell">
                  <div class="order-thumb" style="background-image: url(<?php echo htmlspecialchars($item['capa'] ?? '#555'); ?>);background-size:contain;background-position:center; background-repeat: no-repeat;"></div>
                  <span><?php echo htmlspecialchars($item['titulo']); ?></span>
                </td>
                <td class="order-qty"><?php echo $item['qty']; ?></td>
                <td class="order-total">R$ <?php echo number_format($itemTotal, 2, ',', '.'); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr class="order-subtotal"><td colspan="2">SUBTOTAL</td><td>R$ <?php echo number_format($total, 2, ',', '.'); ?></td></tr>
              <tr class="order-total-row"><td colspan="2">TOTAL</td><td>R$ <?php echo number_format($total, 2, ',', '.'); ?></td></tr>
            </tfoot>
          </table>
        </div>

        <a href="<?php echo base_url('?page=carrinho'); ?>" class="pay-back-btn">&#8592; VOLTAR AO CARRINHO</a>
        <button type="submit" class="pay-finish-btn">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          FINALIZAR PAGAMENTO
        </button>
      </div>
    </div>
  </form>
</main>

<script>
  document.querySelectorAll('input[name="metodo"]').forEach(radio => {
    radio.addEventListener('change', function() {
      document.getElementById('pay-card-fields').style.display = (this.value === 'cartao') ? 'block' : 'none';
      document.getElementById('pay-pix-fields').style.display = (this.value === 'pix') ? 'block' : 'none';
      document.getElementById('pay-boleto-fields').style.display = (this.value === 'boleto') ? 'block' : 'none';
    });
  });
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>