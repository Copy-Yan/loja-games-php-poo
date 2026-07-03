<?php
$title = 'Gerenciar Jogos - Gamestormy';
$jogos = $jogos ?? [];
$error = $error ?? '';


require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/navbar.php';
?>

<main class="container page-section" aria-label="Gerenciar Jogos">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 class="page-title">🎮 Gerenciar Jogos</h1>
    <a href="<?php echo base_url('?page=admin&action=addJogo'); ?>" class="btn-primary">➕ Adicionar Novo Jogo</a>
  </div>

  <?php $flash = flash('success'); if ($flash): ?><div class="alert alert-success"><?php echo $flash; ?></div><?php endif; ?>

  <div style="background:rgba(255,255,255,.04);border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,.08);">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
      <thead>
        <tr style="background:rgba(255,255,255,.06);">
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Capa</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Título</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Preço</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Lançamento</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Tag</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Nota</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($jogos as $j): ?>
        <tr style="border-top:1px solid rgba(255,255,255,.06);">
          <td style="padding:10px 16px;">
            <?php 
            $bgStyle = '#3d3d3d';
            $capa = trim((string)($j['capa'] ?? ''));
            $capaUrl = '';

            if ($capa !== '') {
                if (preg_match('/^https?:\/\//i', $capa)) {
                    $capaUrl = $capa;
                } else {
                    $normalized = $capa;
                    $normalized = ltrim($normalized, './');
                    $normalized = ltrim($normalized, '/');

                    if (str_starts_with($normalized, 'assets/') || str_starts_with($normalized, 'uploads/')) {
                        $capaUrl = function_exists('base_url') ? base_url($normalized) : $normalized;
                    }
                }
            }

            if ($capaUrl) {
                $bgStyle = 'url(' . $capaUrl . ')';
            } elseif ($capa) {
                $bgStyle = htmlspecialchars($capa);
            }
            ?>
            <div style="width:50px;height:50px;border-radius:6px;background:<?php echo $bgStyle; ?>;background-size:cover;background-position:center;"></div>
          </td>
          <td style="padding:10px 16px;font-weight:600;"><?php echo htmlspecialchars($j['titulo']); ?></td>
          <td style="padding:10px 16px;color:var(--green);font-weight:600;">R$ <?php echo number_format($j['preco'], 2, ',', '.'); ?></td>
          <td style="padding:10px 16px;"><?php echo date('d/m/Y', strtotime($j['data_lancamento'])); ?></td>
          <td style="padding:10px 16px;"><span style="background:rgba(255,255,255,.1);padding:2px 8px;border-radius:4px;font-size:11px;"><?php echo htmlspecialchars($j['tag']); ?></span></td>
          <td style="padding:10px 16px;">⭐ <?php echo $j['nota']; ?></td>
          <td style="padding:10px 16px;">
            <a href="<?php echo base_url('?page=jogo&id=' . $j['id_jogo']); ?>" style="color:var(--blue-lt);font-size:12px;margin-right:10px;">Ver</a>
            <a href="<?php echo base_url('?page=admin&action=deleteJogo&id=' . $j['id_jogo']); ?>" style="color:#ff6b6b;font-size:12px;" onclick="return confirm('Remover este jogo permanentemente?');">Remover</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>