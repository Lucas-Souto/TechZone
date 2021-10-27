<?php
require(dirname(__DIR__) . "/functions/startSession.php");
require(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/getName.php");
require_once(dirname(__DIR__) . "/functions/logError.php");

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
	$pass = strlen($_POST['pass']) === 0 ? NULL : password_hash($_POST['pass'], PASSWORD_DEFAULT);
	$data = array(
		$_POST['fname'],#Nome
		$_POST['lname'],#Sobrenome
		$_POST['email'],#E-mail
		$pass,#Senha
		$_POST['additional'],#Dados adicionais
		$_SESSION['status']
	);
	$result = false;

	try
	{
		$uC = new UsersController();
		$result = $uC->updateUser($_SESSION['userEmail'], $data);
	}
	catch (PDOException $e)
	{
		logError($e, "MyAccount");
		header("Location: ../../pages/register.php?internalError=true");
	}

	if ($result)
	{
		$_SESSION['userEmail'] = $_POST['email'];
		$_SESSION['fullname'] = getName($_POST['fname'], $_POST['lname']);

		header("Location: ../../index.php");
	}
	else header("Location: ../../pages/register.php?internalError=true");
}
else echo "Pego no pulo.";
?>