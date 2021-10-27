<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/logError.php");
date_default_timezone_set('America/Sao_Paulo');

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
	$result = false;

	extract($_POST);

	try
	{
		$uC = new UsersController();
		$result = $uC->validateUser($email, $pass);
	}
	catch (PDOException $e)
	{
		logError($e, "Login");
		header("Location: ../../index.php?internalLogError=true");
	}

	if (!$result) header("Location: ../../index.php?authError=true");
	else
	{
		session_start();
		setcookie(session_name(), session_id(), time() + 2592000, '/', $_SERVER['SERVER_NAME']);

		$_SESSION['userEmail'] = $email;

		foreach ($result as $key => $value) $_SESSION[$key] = $value;

		header("Location: ../../index.php");
	}
}
else echo "Pego no pulo.";
?>