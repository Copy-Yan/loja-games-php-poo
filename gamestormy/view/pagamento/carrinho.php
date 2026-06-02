<?php
$title = 'Meu Carrinho - Games Stormy';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/navbar.php';

$subtotal = totalCarrinho();
$total = $subtotal;
?>

<main id="page-cart" aria-label="Meu Carrinho">

  <!-- Checkout stepper -->
  <div class="checkout-header">
    <div class="checkout-logo">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
    </div>
    <div class="checkout-steps">
      <div class="step active" id="step-cart">
        <div class="step-dot"></div>
        <span>Carrinho</span>
      </div>
      <div class="step-line"></div>
      <div class="step" id="step-pay">
        <div class="step-dot"></div>
        <span>Pagamento</span>
      </div>
      <div class="step-line"></div>
      <div class="step" id="step-confirm">
        <div class="step-dot"></div>
        <span>Confirmação</span>
      </div>
    </div>
  </div>

  <div style="padding:28px 40px">
    <h1 class="cart-title">Meu Carrinho</h1>

    <?php if (empty($carrinho)): ?>
      <div style="text-align:center;padding:60px 20px;color:rgba(255,255,255,.5);">
        <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" style="opacity:.3;margin-bottom:16px"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        <p style="font-size:16px;margin-bottom:16px;">Seu carrinho está vazio</p>
        <a href="<?php echo base_url(''); ?>" class="btn-primary">Explorar Jogos</a>
      </div>
    <?php else: ?>

    <div class="cart-table-wrap">
      <table class="cart-table">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($carrinho as $item): 
            $itemTotal = $item['preco'] * $item['qty'];
          ?>
          <tr class="cart-row">
            <td class="cart-product-cell">
              <div class="cart-thumb" style="background:<?php echo htmlspecialchars($item['capa'] ?? '#555'); ?>;background-size:cover;background-position:center;"></div>
              <span class="cart-game-name"><?php echo htmlspecialchars($item['titulo']); ?></span>
            </td>
            <td class="cart-price">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
            <td class="cart-qty-cell">
              <span class="qty-val"><?php echo $item['qty']; ?></span>
            </td>
            <td class="cart-total">R$ <?php echo number_format($itemTotal, 2, ',', '.'); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- Subtotal -->
      <div class="cart-summary">
        <div class="cart-summary-row">
          <span class="cart-summary-label">SUBTOTAL</span>
          <span class="cart-summary-value">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
        </div>
        <div class="cart-summary-row cart-summary-total">
          <span class="cart-summary-label">TOTAL</span>
          <span class="cart-summary-value">R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
        </div>
      </div>
    </div>

    <div class="cart-actions">
      <a href="<?php echo base_url(''); ?>" class="cart-btn-secondary">ESCOLHER MAIS PRODUTOS</a>
      <?php if (authCheck()): ?>
        <a href="<?php echo base_url('?page=pagamento&action=checkout'); ?>" class="cart-btn-primary">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
          FECHAR PEDIDO
        </a>
      <?php else: ?>
        <a href="<?php echo base_url('?page=usuario&action=login'); ?>" class="cart-btn-primary">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
          FAÇA LOGIN PARA CONTINUAR
        </a>
      <?php endif; ?>
    </div>

    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>