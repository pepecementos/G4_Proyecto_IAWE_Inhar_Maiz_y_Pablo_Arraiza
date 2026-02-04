<?php
require_once __DIR__ . '/../includes/funciones.php';
$carrito = carrito_listar();
?>
<section class="section">
  <div class="section-head">
    <h2>Carrito de compras</h2>
    <a class="btn" href="index.php?page=tienda">Seguir comprando</a>
    <?php if ($carrito): ?>
      <form method="post" style="display:inline; background:none; border:none; box-shadow:none; padding:0; margin:0;">
        <button class="btn" type="submit" name="vaciar_carrito">Vaciar carrito</button>
      </form>
    <?php endif; ?>
  </div>
  <div class="panel">
    <?php if (!$carrito): ?>
      <p>Tu carrito está vacío.</p>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $total = 0; ?>
          <?php foreach($carrito as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['producto']) ?></td>
              <td><?= number_format($p['precio'], 2) ?> €</td>
              <td><?= (int)$p['cantidad'] ?></td>
              <td><?= number_format($p['precio'] * $p['cantidad'], 2) ?> €</td>
              <td>
                <form method="post" style="display:inline; background:none; border:none; box-shadow:none; padding:0; margin:0;">
                  <input type="hidden" name="quitar_carrito" value="1">
                  <input type="hidden" name="producto" value="<?= htmlspecialchars($p['producto']) ?>">
                  <button class="btn" type="submit">Quitar</button>
                </form>
              </td>
            </tr>
            <?php $total += $p['precio'] * $p['cantidad']; ?>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" style="text-align:right;">Total:</th>
            <th><?= number_format($total, 2) ?> €</th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    <?php endif; ?>
  </div>
</section>
