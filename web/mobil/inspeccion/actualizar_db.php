<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
	include_once 'db_remota.php.inc';

    try {
        $VersionActual = $db_local->query("SELECT ver FROM version")->fetchColumn();
    } catch (Exception $e) {
        $VersionActual = 0;
    }

    echo "<p>Versión actual de la base de datos: $VersionActual</p>";
    $VersionActual = (int)($VersionActual);
    if($VersionActual == 0) {
        echo '<p>Actualizando base de datos a la versión 1</p>';
        // Iniciar sistema de versiones
        try {
            $db_local->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionDetalle ADD COLUMN ResultadosCantidad INTEGER NOT NULL DEFAULT 0");
            $db_local->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionResultado ADD COLUMN Asignacion_id INTEGER NULL DEFAULT NULL");
        } catch (Exception $e) {
            // Nada
        }

        $db_local->exec("CREATE TABLE version (ver INTEGER)");
        $db_local->exec("INSERT INTO version (ver) VALUES (1)");
        
        $VersionActual = 1;
    }

    if($VersionActual == 1) {
        // Actualización de versión 1 a versión $VersionActual
        $VersionActual = 2;
        echo "<p>Actualizando base de datos a la versión $VersionActual</p>";
        
        $db_local->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionDetalle ADD COLUMN Suprimido INTEGER NOT NULL DEFAULT 0");
        
        $db_local->exec("UPDATE version SET ver=$VersionActual");
        
    }
    
    
    /* if($VersionActual == 2) {
        // Actualización de versión 2 a versión 3
        $VersionActual = 3;
        echo "<p>Actualizando base de datos a la versión $VersionActual</p>";
        
        // ....
        
        $db_local->exec("UPDATE version SET ver=$VersionActual");
        
    } */