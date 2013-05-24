<?php
	global $db_local;

	try
	{
		$db_local = new PDO('sqlite:inspeccion.sqlite');
		$db_local->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}	
	catch(Exception $e)
	{
		die($e);
	}
?>
