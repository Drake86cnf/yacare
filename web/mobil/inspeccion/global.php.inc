<?php
    include_once 'debug.php.inc';

	session_start();
	$hab = $_SESSION['habilitado'];
	if ($hab!=1) {
		header('Location: index.php');
	}
	
	$mac = trim(@file_get_contents('/sys/class/net/wlan0/address'));
	if(!$mac)
		$mac = trim(@file_get_contents('/sys/class/net/eth0/address'));
	if(!$mac)
		$mac = trim(@file_get_contents('/sys/class/net/wls1/address'));
	
	if($mac)
		$mac = strtoupper(str_replace(':', '', $mac));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="es-ar" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Yacaré - Inspección</title>
<link href="global.css" rel="stylesheet" />
</head>
