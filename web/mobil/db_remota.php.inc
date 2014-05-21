<?php

    global $YacareDbRemota;

    try {
        $YacareDbRemota = @new PDO('mysql:host=192.168.100.5;dbname=yacare;charset=utf8', 'yacare', 'L1n4j3');
    } catch (Exception $e) {
        // Nada
        echo "<notice>" . $e->getMessage() . "</notice>";
        $YacareDbRemota = null;
    }

    if($YacareDbRemota) {
        $YacareDbRemota->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
