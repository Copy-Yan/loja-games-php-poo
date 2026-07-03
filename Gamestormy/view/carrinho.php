<?php
$title = 'Meu Carrinho - Gamestormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main id="page-cart" aria-label="Meu Carrinho">

  <!-- Checkout stepper -->
  <div class="checkout-header">

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
      <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 0;text-align:center;color:rgba(255,255,255,.4);gap:12px;">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="opacity:.3"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        <p>Seu carrinho está vazio</p>
        <a href="<?php echo base_url(''); ?>" class="btn-primary" style="margin-top:8px;">Continuar Comprando</a>
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
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $subtotal = 0;
          foreach ($carrinho as $item): 
            $itemTotal = $item['preco'] * $item['qty'];
            $subtotal += $itemTotal;
          ?>
          <tr class="cart-row">
            <td class="cart-product-cell">
              <div class="cart-thumb" style="background-image:url('<?php echo htmlspecialchars($item['capa'] ?? '#555'); ?>'); background-size:contain; background-position:center; background-repeat: no-repeat;">
                <?php echo (strpos($item['capa'] ?? '', 'assets/') === 0) ? '' : htmlspecialchars(substr($item['titulo'], 0, 8)); ?>
              </div>
              <span class="cart-game-name"><?php echo htmlspecialchars($item['titulo']); ?></span>
            </td>
            <td class="cart-price">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
            <td class="cart-qty-cell">
              <form method="POST" action="<?php echo base_url('?page=carrinho&action=updateQty'); ?>" style="display:inline">
                <input type="hidden" name="id_jogo" value="<?php echo $item['id_jogo']; ?>"/>
                <input type="hidden" name="qty" value="<?php echo $item['qty'] - 1; ?>"/>
                <button type="submit" class="qty-btn">&#8722;</button>
              </form>
              <span class="qty-val"><?php echo $item['qty']; ?></span>
              <form method="POST" action="<?php echo base_url('?page=carrinho&action=updateQty'); ?>" style="display:inline">
                <input type="hidden" name="id_jogo" value="<?php echo $item['id_jogo']; ?>"/>
                <input type="hidden" name="qty" value="<?php echo $item['qty'] + 1; ?>"/>
                <button type="submit" class="qty-btn">&#43;</button>
              </form>
            </td>
            <td class="cart-total">R$ <?php echo number_format($itemTotal, 2, ',', '.'); ?></td>
            <td>
              <a href="<?php echo base_url('?page=carrinho&action=remove&id=' . $item['id_jogo']); ?>" style="color:#ff6b6b;font-size:12px;" onclick="return confirm('Remover este item?');">✕</a>
            </td>
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
          <span class="cart-summary-value">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
        </div>
      </div>
    </div>

    <div class="cart-actions">
      <a href="<?php echo base_url(''); ?>" class="cart-btn-secondary">ESCOLHER MAIS PRODUTOS</a>
      <a href="<?php echo base_url('?page=carrinho&action=payment'); ?>" class="cart-btn-primary">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        FECHAR PEDIDO
      </a>
    </div>
    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>