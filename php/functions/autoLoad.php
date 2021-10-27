<?php
spl_autoload_register(function($className)
{
	require_once(dirname(__DIR__) . "/classes/{$className}.php");
});
?>