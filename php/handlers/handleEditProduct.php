<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/logError.php");

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
	try
	{
		$pC = new ProductsController();
	}
	catch (PDOException $e)
	{
		logError($e, "Edit/Remove Product");
		header("Location: ../../pages/editProduct.php?internalError=true");
	}

	$result = false;
	$dir = "../../" . $_GET['originalPath'];
	
	try
	{
		if ($_POST['action'] == 'edit')
		{
			if (!empty($_FILES['file']['name'])) move_uploaded_file($_FILES['file']['tmp_name'], $dir);

			$desc = strlen($_POST['desc']) === 0 ? "Sem descrição... :(" : $_POST['desc'];
			$data = array(
				[$_POST['name'], PDO::PARAM_STR],
				[$_POST['price'], PDO::PARAM_STR],
				[$desc, PDO::PARAM_STR],
				[NULL, PDO::PARAM_STR],
				[$_POST['quantity'], PDO::PARAM_INT],
				[$_POST['category'], PDO::PARAM_STR]
			);

			$result = $pC->updateProduct($_GET['id'], $data);
		}
		else if ($_POST['action'] == 'delete')
		{
			$result = $pC->deleteProduct($_GET['id']);

			unlink($dir);
		}
	}
	catch (PDOException $e)
	{
		logError($e, "Edit/Remove Product");
		header("Location: ../../pages/editProduct.php?internalError=true");
	}

	if ($result) header("Location: ../../pages/editProduct.php?success=true");
	else
	{
		if (!empty($_FILES['file']['name']) && $_POST['action'] == 'edit') header("Location: ../../pages/editProduct.php?success=true");
		else header("Location: ../../pages/editProduct.php?noChanges=true");
	}
}
else echo "Pego no pulo";
?>