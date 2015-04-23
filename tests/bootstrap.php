<?php

    //require_once 'tests/AutoLoader.php';
    //AutoLoader::registerDirectory('tests');
    
	//$_SERVER['KERNEL_DIR'] = __DIR__;
    
	require_once 'vendor/autoload.php';

    require_once 'tests/Tapir/PruebaUnitaria.php';
    require_once 'tests/Tapir/PruebaFuncional.php';
    
    require_once 'tests/Tapir/BaseBundle/Entity/GenericEntityTest.php';
    
    require_once 'tests/Tapir/BaseBundle/Controller/BaseControllerTest.php';
    require_once 'tests/Tapir/BaseBundle/Controller/AbmControllerTest.php';
    
    require_once 'var/bootstrap.php.cache';