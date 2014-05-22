<?php

    global $YacareDbRemota;

    try {
        if($YacareModoDesarrollo) {
            $YacareDbRemota = @new PDO('mysql:host=127.0.0.1;dbname=yacadev;charset=utf8', 'yacadev', '123456');
        } else {
            $YacareDbRemota = @new PDO('mysql:host=192.168.100.5;dbname=yacare;charset=utf8', 'yacare', 'L1n4j3');
        }
    } catch (Exception $e) {
        // Nada
        echo "<notice>" . $e->getMessage() . "</notice>";
        $YacareDbRemota = null;
    }

    if($YacareDbRemota) {
        $YacareDbRemota->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
