<?php

namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("zona/")
 */
class ZonaController extends \Tapir\BaseBundle\Controller\AbmController
{
    function IniciarVariables() {
        parent::IniciarVariables();

        $this->BuscarPor = 'Codigo, nombre';
        $this->OrderBy = 'nombre';
    }
}
