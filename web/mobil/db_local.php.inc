<?php

    global $YacareDbLocal, $YacareCarpetaRaiz;

    if(file_exists($YacareCarpetaRaiz . '/yacare.sqlite') == false) {
        header('Location: /admin/instalar.php');
        exit;
    }

    try {
        $YacareDbLocal = new PDO('sqlite:' . $YacareCarpetaRaiz . '/yacare.sqlite');
        $YacareDbLocal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try {
            $VersionActual = $YacareDbLocal->query("SELECT ver FROM version")->fetchColumn();
        } catch (Exception $e) {
            header('Location: /admin/instalar.php');
            exit;
        }
    } catch (Exception $e) {
        header('Location: /admin/instalar.php');
        exit;
    }
