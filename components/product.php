<?php
require_once(dirname(__DIR__) . "/php/functions/getPath.php");
require_once(dirname(__DIR__) . "/php/functions/brMoney.php");

if (isset($_GET['id']))
{
  $product = [];

  try
  {
    $pC = new ProductsController();
    $product = $pC->getProductData($_GET['id']);
  }
  catch (PDOException $e)
  {
    logError($e, "View Product");
    header("Location: ../index.php?internalError=true");
  }

  if (empty($product)) header("Location: ../index.php");

  $name = $product['name'];
  $price = brMoney($product['price']);
  $desc = $product['description'];
  $quantity = $product['quantity'];
  $category = $product['category'];
  $image = $product['image'];
  $add = $quantity > 0 ? "({$quantity} em estoque)" : "(Fora de estoque)";
}
else header("Location: ../index.php");
?>

<script type="text/javascript">
  document.title = 'TechZone | <?php echo $name ?>';
</script>

<div id="product-card" class="card">
  <div id="card-content">
    <div id="product-view">
      <h2><?php echo $name . $add; ?></h2>
      <img id="main-img" src="<?php echo getPath($image); ?>" alt="<?php echo $name; ?>" />
    </div>
    <div id="product-buy">
      <h3>Preço: <?php echo $price; ?></h3>
      <form action="../php/handlers/cartHandler.php" method="GET">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
        <input type="hidden" name="action" value="add" />
        <label for="quantity">Quantidade:</label><br />
        <input type="number" <?php echo $quantity > 0 ? "min='1' value='1'" : "value='0'"; ?> id="quantity" name="quantity" /><br /><br />
        <button type="submit" <?php echo $quantity > 0 && isset($_COOKIE[session_name()]) ? "" : 'disabled' ?>>Adicionar ao carrinho</button>
      </form>
    </div>
    <div id="product-description"><?php echo $desc; ?></div>
  </div>
  <?php if (isset($_COOKIE[session_name()]) && $_SESSION['status'] != 'user'):?>
    <a id="manage-button" href="editProduct.php?id=<?php echo $_GET['id']; ?>">Editar</a>
  <?php endif; ?>
</div>