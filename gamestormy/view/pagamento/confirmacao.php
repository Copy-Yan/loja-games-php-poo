<?php
$title = 'Pedido Confirmado - Games Stormy';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/navbar.php';
?>

<main id="page-confirmation" aria-label="Confirmação do pedido">

  <div class="checkout-header">
    <div class="checkout-logo">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
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
      <div class="confirm-order-id"><?php echo htmlspecialchars($numero_pedido); ?></div>
    </div>

    <!-- Order summary table -->
    <div class="confirm-table-wrap">
      <div class="confirm-table-title">Resumo do Pedido</div>
      <table class="confirm-table">
        <thead>
          <tr><th>Produto</th><th>Quantidade</th><th>TOTAL</th></tr>
        </thead>
        <tbody>
          <?php foreach ($itens as $item): ?>
          <tr>
            <td class="confirm-product-cell"><div class="confirm-thumb" style="background:<?php echo htmlspecialchars($item['capa'] ?? '#555'); ?>;background-size:cover;"></div><span><?php echo htmlspecialchars($item['titulo']); ?></span></td>
            <td class="confirm-qty">1</td>
            <td class="confirm-total">R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr class="confirm-total-row">
            <td colspan="2" style="text-align:right;padding-right:16px;color:var(--purple-lt);font-weight:700">TOTAL PAGO</td>
            <td>R$ <?php echo number_format($total, 2, ',', '.'); ?></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <a href="<?php echo base_url(''); ?>" class="confirm-home-btn">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        IR PARA O INÍCIO
      </a>
      <a href="<?php echo base_url('?page=biblioteca'); ?>" class="confirm-home-btn" style="background:var(--purple);">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
        MINHA BIBLIOTECA
      </a>
    </div>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>