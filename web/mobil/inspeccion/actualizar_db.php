<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
	include_once 'db_remota.php.inc';

    $db_local->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $VersionActual = $db_local->query("SELECT ver FROM version")->fetchColumn();
    echo "<p>Versión actual de la base de datos: $VersionActual</p>";
    $VersionActual = (int)($VersionActual);
    if($VersionActual == 0) {
        echo '<p>Actualizando base de datos a la versión 1</p>';
        // Iniciar sistema de versiones
        $db_local->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionDetalle ADD COLUMN ResultadosCantidad INTEGER NOT NULL DEFAULT 0");
        $db_local->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionResultado ADD COLUMN Asignacion_id INTEGER NULL DEFAULT NULL");

        $db_local->exec("CREATE TABLE version (ver INTEGER)");
        $db_local->exec("INSERT INTO version (ver) VALUES (1)");
        
        $VersionActual = 1;
    }

    /* if($VersionActual == 1) {
        // Actualización de versión 1 a versión 2
        echo '<p>Actualizando base de datos a la versión 2</p>';
        
        $db_local->exec("UPDATE version SET ver=2");
        $VersionActual = 2;
    } */