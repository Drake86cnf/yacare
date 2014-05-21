<?php
    header("Cache-Control: no-cache, must-revalidate");

    global $YacareCarpetaRaiz;
    $YacareCarpetaRaiz = __DIR__;
    
    if(file_exists($YacareCarpetaRaiz . '/debug.txt')) {
        $YacareModoDesarrollo = true;
    } else {
        $YacareModoDesarrollo = false;
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