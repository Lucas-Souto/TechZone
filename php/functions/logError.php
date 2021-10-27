<?php
function logError($e, $type)
{
	$message = $e->getMessage();
	$errorSTR = "------------------------- Cought Exception: PDOException({$type}) -------------------------";
	$errorSTR .= "\nMessage: " . $message . "\nTrace:\n" . $e->getTraceAsString() . "\n\n";
	$file = fopen(dirname(dirname(__DIR__)) . "/log.txt", "a");

	fwrite($file, $errorSTR);
	fclose($file);
}
?>