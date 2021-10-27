<?php
require_once(dirname(__DIR__) . "/functions/logError.php");
require_once(dirname(__DIR__) . "/functions/getPath.php");
require_once(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/brMoney.php");
require_once(dirname(dirname(__DIR__)) . "/components/card.php");

try
{
	$pC = new ProductsController();
}
catch (PDOException $e)
{
	logError($e, "Load Products");
}

$products = $pC->getProducts();

if ($products)
{
	foreach ($products as $product)
	{
		$price = brMoney($product['price']);
		createCard(getPath($product['image']), $product['name'], $price, $product['id']);
	}	
}
?>