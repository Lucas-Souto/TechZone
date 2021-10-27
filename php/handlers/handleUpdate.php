<?php
require(dirname(__DIR__) . "/functions/startSession.php");
require(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/logError.php");

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
	try
	{
		$uC = new UsersController();
	}
	catch (PDOException $e)
	{
		logError($e, "Edit user");
		header("Location: ../../pages/editUser.php?internalError=true");
	}

	$result = false;

	try
	{
		if ($_POST["action"] === "edit")
		{
			$password = strlen($_POST["pass"]) === 0 ? NULL : password_hash($_POST["pass"], PASSWORD_DEFAULT);
			$cpf = strlen($_POST["cpf"]) === 0 ? NULL : $_POST["cpf"];
			
			$newEmail = strlen($_POST["new-email"]) === 0 ? $_POST["email"] : $_POST["new-email"];
			$data = array(
				$newEmail,
				$cpf,
				$password,
				$_POST["status"]
			);

			$result = $uC->updateUserForAdmin($_POST["email"], $data);
		}
		else if ($_POST["action"] === "delete") $result = $uC->deleteUser($_POST["email"]);
	}
	catch (PDOException $e)
	{
		logError($e, "Edit user");
		header("Location: ../../pages/editUser.php?internalError=true");
	}
	
	if ($result) header("Location: ../../pages/editUser.php?success=true");
	else header("Location: ../../pages/editUser.php?noChanges=true");
}
else echo "Pego no pulo.";
?>