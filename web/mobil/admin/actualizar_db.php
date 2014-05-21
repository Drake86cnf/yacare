<?php
    require_once '../global.php.inc';
    
    require_once '../db_local.php.inc';
    require_once 'db_remota.php.inc';

    try {
        $VersionActual = $YacareDbLocal->query("SELECT ver FROM version")->fetchColumn();
    } catch (Exception $e) {
        header('Location: /admin/instalar.php');
        exit;
    }

    echo "<p>Versión actual de la base de datos: $VersionActual</p>";
    $VersionActual = (int)($VersionActual);
    if($VersionActual == 0) {
        echo '<p>Actualizando base de datos a la versión 1</p>';
        // Iniciar sistema de versiones
        try {
            $YacareDbLocal->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionDetalle ADD COLUMN ResultadosCantidad INTEGER NOT NULL DEFAULT 0");
            $YacareDbLocal->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionResultado ADD COLUMN Asignacion_id INTEGER NULL DEFAULT NULL");
        } catch (Exception $e) {
            // Nada
        }

        $YacareDbLocal->exec("CREATE TABLE version (ver INTEGER)");
        $YacareDbLocal->exec("INSERT INTO version (ver) VALUES (1)");
        
        $VersionActual = 1;
    }

    if($VersionActual == 1) {
        // Actualización de versión 1 a versión $VersionActual
        $VersionActual = 2;
        echo "<p>Actualizando base de datos a la versión $VersionActual</p>";
        
        $YacareDbLocal->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionDetalle ADD COLUMN Suprimido INTEGER NOT NULL DEFAULT 0");
        
        $YacareDbLocal->exec("UPDATE version SET ver=$VersionActual");
    }
    
    
    /* if($VersionActual == 2) {
        // Actualización de versión 2 a versión 3
        $VersionActual = 3;
        echo "<p>Actualizando base de datos a la versión $VersionActual</p>";
        
        // ....
        
        $YacareDbLocal->exec("UPDATE version SET ver=$VersionActual");
        
    } */