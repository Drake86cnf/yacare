<?php

    global $db_remota;

    try {
        $db_remota = @new PDO('mysql:host=192.168.100.5;dbname=yacare;charset=utf8', 'yacare', '123456');
    } catch (Exception $e) {
        // Nada
        echo "<pre>" . $e-message . "</pre>";
        $db_remota = null;
    }

    if($db_remota) {
        $db_remota->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
?>
