<?php
$title = 'Pedido Confirmado - Games Stormy';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/navbar.php';
?>

<main id="page-confirmation" aria-label="Confirmação do pedido">

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

    <?php if ($success): ?>
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
        <div class="confirm-order-id">#<?php echo str_pad($pedidoId ?? rand(10000, 99999), 5, '0', STR_PAD_LEFT); ?></div>
      </div>

      <!-- Order summary table -->
      <div class="confirm-table-wrap">
        <div class="confirm-table-title">Resumo do Pedido</div>
        <table class="confirm-table">
          <thead>
            <tr><th>Produto</th><th>Quantidade</th><th>TOTAL</th></tr>
          </thead>
          <tbody>
            <?php 
            // Recuperar itens do pedido do banco
            $pdo = getDB();
            $stmt = $pdo->prepare("SELECT p.*, j.titulo, j.capa FROM Pedido_itens p JOIN Jogos j ON p.id_jogo = j.id_jogo WHERE p.id_pedido = ?");
            $stmt->execute([$pedidoId ?? 0]);
            $itens = $stmt->fetchAll();
            $total = 0;
            foreach ($itens as $item): 
              $total += $item['preco_unitario'];
            ?>
            <tr>
              <td class="confirm-product-cell">
                <div class="confirm-thumb" style="background:<?php echo htmlspecialchars($item['capa'] ?? '#555'); ?>;background-size:cover;background-position:center;"></div>
                <span><?php echo htmlspecialchars($item['titulo']); ?></span>
              </td>
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
        <a href="<?php echo base_url('?page=biblioteca'); ?>" class="confirm-home-btn" style="background:var(--purple);">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3v4M8 3v4M2 11h20"/></svg>
          VER BIBLIOTECA
        </a>
        <a href="<?php echo base_url(''); ?>" class="confirm-home-btn">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
          IR PARA O INÍCIO
        </a>
      </div>

    <?php else: ?>
      <!-- Erro no checkout -->
      <div style="text-align:center;padding:40px 0;">
        <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="#ff6b6b" stroke-width="1.5" style="margin-bottom:16px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <h2 style="font-size:22px;font-weight:700;color:#ff6b6b;margin-bottom:12px;">Erro no Pedido</h2>
        <p style="color:rgba(255,255,255,.6);font-size:14px;margin-bottom:20px;"><?php echo htmlspecialchars($erro ?? 'Ocorreu um erro ao processar seu pedido. Tente novamente.'); ?></p>
        <a href="<?php echo base_url('?page=carrinho&action=payment'); ?>" class="btn-primary">Tentar Novamente</a>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>