<?php

namespace Yacare\BromatologiaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("vehiculo/")
 */
class VehiculoController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    public function __construct() {
        $this->BundleName = 'Bromatologia';
        $this->EntityName = 'Vehiculo';
        $this->BuscarPor = 'Dominio,Marca';
        parent::__construct();
    }
}
