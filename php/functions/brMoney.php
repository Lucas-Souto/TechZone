<?php 
function brMoney($value)
{
	return "R$" . number_format($value, 2, ',', '.');
}
?>