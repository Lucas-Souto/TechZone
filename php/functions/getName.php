<?php
function getName($name, $surname)
{
	$name = rtrim(ltrim($name));
	$surname = rtrim(ltrim($surname));

	return ucwords(strtolower($name . ' ' . $surname));
}
?>