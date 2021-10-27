<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");
require(dirname(__DIR__) . "/functions/startSession.php");
require_once(dirname(__DIR__) . "/functions/logError.php");

if ($_SERVER["REQUEST_METHOD"] === "GET")
{
	if (!isset($_COOKIE[session_name()])) header("Location: ../index.php");

	try
	{
		$sCC = new ShoppingCartController();
	}
	catch (PDOException $e)
	{
		logError($e, "Shopping Cart");
		header("Location: ../../pages/shoppingCart.php?internalError=true");
	}

	$result = false;
	$data = array(
		[$_SESSION['userEmail'], PDO::PARAM_STR],
		[$_GET['id'], PDO::PARAM_INT],
		[$_GET['quantity'], PDO::PARAM_INT]
	);
	$action = $_GET['action'] == 'edit' && $_GET['quantity'] == 0 ? 'delete' : $_GET['action'];

	try
	{
		switch ($action)
		{
			case "add": $result = $sCC->insertNewItem($data); break;
			case "edit": $result = $sCC->updateItem($_SESSION['userEmail'], $_GET['id'], $_GET['quantity']); break;
			case "delete": $result = $sCC->deleteItem($_SESSION['userEmail'], $_GET['id']); break;
		}
	}
	catch (PDOException $e)
	{
		logError($e, "Shopping Cart");
		header("Location: ../../pages/shoppingCart.php?internalError=true");
	}

	if ($result) header("Location: ../../pages/shoppingCart.php");
	else header("Location: ../../pages/shoppingCart.php?internalError=true");
}
else echo "Pego no pulo.";
?>