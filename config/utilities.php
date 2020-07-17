<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/errors.php');

function tableExists($pdo, $table) {
	try {
		$result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
	} catch (Exception $e) {
		return FALSE;
	}
	return $result !== FALSE;
}

function error_exists($error)
{
	foreach ($GLOBALS['errors'] as $err => $msg)
	{
		// echo $msg;
		if ($err = $error)
			return($msg);
	}
	return (false);
}
