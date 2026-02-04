<?php
// vistas/tienda.php
require_once __DIR__ . '/../includes/funciones.php';

$items = [
  ["producto"=>"Figura", "categoria"=>"Merch", "precio"=>29.99, "stock"=>12],
  ["producto"=>"Sudadera", "categoria"=>"Ropa", "precio"=>39.90, "stock"=>7],
  ["producto"=>"Manga físico", "categoria"=>"Libros", "precio"=>9.50, "stock"=>25],
  ["producto"=>"Póster", "categoria"=>"Decoración", "precio"=>6.99, "stock"=>40],
];
?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <h1>Tienda</h1>
      <div class="quick">
        <a class="btn" href="index.php?page=inicio<?php echo $usuario?>">Volver</a>
        <a class="btn primary" href="index.php?page=carrito">Abrir carrito</a>
      </div>
    </div>
    <div class="badges">
      <div class="badge"><strong>Pago</strong> (mock)</div>
      <div class="badge"><strong>Envíos</strong> (mock)</div>
      <div class="badge"><strong>Ofertas</strong> (mock)</div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-head">
    <div>
      <h2>Productos destacados</h2>
      <p>Tabla de productos (fácil de conectar a BD)</p>
    </div>
  </div>

  <div class="panel">
    <table class="table" aria-label="Tabla de productos">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Categoría</th>
          <th>Precio</th>
          <th>Stock</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($items as $it): ?>
        <tr>
          <td><?= htmlspecialchars($it["producto"]) ?></td>
          <td><?= htmlspecialchars($it["categoria"]) ?></td>
          <td><?= number_format((float)$it["precio"], 2) ?> €</td>
          <td><?= (int)$it["stock"] ?></td>
          <td>
            <form method="post" style="display:inline; background:none; border:none; box-shadow:none; padding:0; margin:0;">
              <input type="hidden" name="add_carrito" value="1">
              <input type="hidden" name="producto" value="<?= htmlspecialchars($it['producto']) ?>">
              <input type="hidden" name="precio" value="<?= htmlspecialchars($it['precio']) ?>">
              <button class="btn primary" type="submit">Añadir</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div style="margin-top:12px;color:var(--muted);font-size:13px;">
      Consejo: crea una tabla <strong>productos</strong> en MySQL y pinta esta vista con PDO.
    </div>
  </div>
</section>