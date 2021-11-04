<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/logError.php");

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
	$hasStatus = isset($_POST['status']);
	$status = $hasStatus ? $_POST['status'] : 'user';
	$location = $hasStatus ? "pages/registerAdmin.php" : "pages/register.php";
	$data = array(
		$_POST['fname'],#Nome
		$_POST['lname'],#Sobrenome
		$_POST['email'],#E-mail
		$_POST['cpf'],#CPF
		password_hash($_POST['pass'], PASSWORD_DEFAULT),#Senha
		$_POST['additional'],#Dados adicionais
		$status#Status
	);
	$result = false;

	try
	{
		$uC = new UsersController();
		$result = $uC->insertNewUser($data);
	}
	catch (PDOException $e)
	{
		logError($e, "Register");
		header("Location: ../../{$location}?internalError=true");
	}

	if ($result)
	{
		if ($hasStatus) header("Location: ../../{$location}?success=true");
		else
		{
			session_start();
			setcookie(session_name(), session_id(), time() + 2592000, '/', $_SERVER['SERVER_NAME']);

			$_SESSION['userEmail'] = $_POST['email'];
			$_SESSION['status'] = 'user';

			header("Location: ../../index.php");
		}
	}
	else header("Location: ../../{$location}?internalError=true");
}
else echo "Pego no pulo.";
?>