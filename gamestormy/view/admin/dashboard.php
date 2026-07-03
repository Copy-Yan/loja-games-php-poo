<?php
$title = 'Painel Admin - Gamestormy';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/navbar.php';
?>

<?php
$jogos = $jogos ?? [];
?>

<main class="container page-section" aria-label="Painel Administrativo">
  <h1 class="page-title">🛠️ Painel Administrativo</h1>

  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:32px;">
    <a href="<?php echo base_url('?page=admin&action=jogos'); ?>" style="background:var(--purple);border-radius:12px;padding:24px;text-align:center;transition:transform .15s;display:block;">
      <div style="font-size:32px;margin-bottom:8px;">🎮</div>
      <div style="font-weight:700;font-size:16px;">Gerenciar Jogos</div>
      <div style="font-size:13px;color:rgba(255,255,255,.6);margin-top:4px;"><?php echo count($jogos); ?> jogos cadastrados</div>
    </a>
    <a href="<?php echo base_url('?page=admin&action=addJogo'); ?>" style="background:var(--green);border-radius:12px;padding:24px;text-align:center;transition:transform .15s;display:block;">
      <div style="font-size:32px;margin-bottom:8px;">➕</div>
      <div style="font-weight:700;font-size:16px;">Adicionar Jogo</div>
      <div style="font-size:13px;color:rgba(255,255,255,.6);margin-top:4px;">Cadastrar novo título</div>
    </a>
  </div>

  <h2 class="section-title">Jogos Recentes</h2>
  <div style="background:rgba(255,255,255,.04);border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,.08);">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
      <thead>
        <tr style="background:rgba(255,255,255,.06);">
          <th style="padding:12px 16px;text-align:left;font-weight:600;">ID</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Capa</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Título</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Preço</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Tag</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (array_slice($jogos, 0, 10) as $j): ?>
        <tr style="border-top:1px solid rgba(255,255,255,.06);">
          <td style="padding:10px 16px;"><?php echo $j['id_jogo']; ?></td>
          <td style="padding:10px 16px;">
            <div style="width:40px;height:40px;border-radius:6px;background:<?php echo (strpos($j['capa'] ?? '', 'assets/') === 0) ? 'url(' . base_url($j['capa']) . ')' : htmlspecialchars($j['capa'] ?? '#3d3d3d'); ?>;background-size:cover;background-position:center;"></div>
          </td>
          <td style="padding:10px 16px;font-weight:600;"><?php echo htmlspecialchars($j['titulo']); ?></td>
          <td style="padding:10px 16px;color:var(--green);font-weight:600;">R$ <?php echo number_format($j['preco'], 2, ',', '.'); ?></td>
          <td style="padding:10px 16px;"><span style="background:rgba(255,255,255,.1);padding:2px 8px;border-radius:4px;font-size:11px;"><?php echo htmlspecialchars($j['tag']); ?></span></td>
          <td style="padding:10px 16px;">
            <a href="<?php echo base_url('?page=admin&action=editJogo&id=' . $j['id_jogo']); ?>" style="color:var(--blue-lt);font-size:12px;margin-right:10px;">Editar</a>
            <a href="<?php echo base_url('?page=admin&action=deleteJogo&id=' . $j['id_jogo']); ?>" style="color:#ff6b6b;font-size:12px;" onclick="return confirm('Remover este jogo?');">Remover</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>