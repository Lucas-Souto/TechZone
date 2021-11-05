<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/logError.php");

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
	$result = false;
	$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$fileName = date("Y.m.d-H.i.s") . '.' . $extension;
	$dir = "../../imgs/products/";
	$htmlPath = "imgs/products/" . $fileName;

	$desc = strlen($_POST['desc']) === 0 ? "Sem descrição... :(" : $_POST['desc'];
	$data = array(
		[$_POST['name'], PDO::PARAM_STR],
		[$_POST['price'], PDO::PARAM_STR],
		[$desc, PDO::PARAM_STR],
		[$htmlPath, PDO::PARAM_STR],
		[$_POST['quantity'], PDO::PARAM_INT],
		[$_POST['category'], PDO::PARAM_STR]
	);

	try
	{
		$pC = new ProductsController();
		$result = $pC->insertNewProduct($data);

		move_uploaded_file($_FILES['file']['tmp_name'], $dir . $fileName);
	}
	catch (PDOException $e)
	{
		logError($e, "Register Product");
		header("Location: ../../pages/registerProduct.php?internalError=true");
	}

	if ($result) header("Location: ../../pages/registerProduct.php?success=true");
	else header("Location: ../../pages/registerProduct.php?internalError=true");
}
else echo "Pego no pulo.";
?>