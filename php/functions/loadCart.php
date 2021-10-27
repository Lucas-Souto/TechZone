<?php
require_once(dirname(__DIR__) . "/functions/logError.php");
require_once(dirname(__DIR__) . "/functions/getPath.php");
require_once(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/brMoney.php");
require_once(dirname(dirname(__DIR__)) . "/components/card.php");

$value = 0;

if (isset($_GET['internalError']) && $_GET['internalError'])
{
  echo "<div style='color: red;'>
  <h2>Ops... Algo deu errado!</h2>
  <p>Ocorreu um erro no servidor. Tente novamente mais tarde.</p>
  </div>";
}

try
{
	$sCC = new ShoppingCartController();
}
catch (PDOException $e)
{
	logError($e, "User Cart");
	header("Location: shoppingCart.php?internalError=true");
}

$result = $sCC->getItems($_SESSION['userEmail']);

if ($result)
{
	foreach ($result as $data)
	{
		$quantity = $data['productQuantity'];
		$inStock = $data['quantity'];
		$price = $data['price'];
		$value += $price * $quantity;
		$formatedPrice = brMoney($price);

		createShoppingCard(getPath($data['image']), $data['name'], $formatedPrice, $quantity, $inStock, $data['id']);
	}
}
?>

<div id="final">
	<?php if ($value !== 0): ?>
		<hr />
		<h2>Preço: <?php echo brMoney($value); ?></h2>
	<?php else: ?>
		<h2>Seu carrinho está vazio.</h2>
	<?php endif; ?>
</div>