<?php

namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\CatastroBundle\Entity\Partida;
use Yacare\CatastroBundle\Form\PartidaType;

/**
 * @Route("partida/")
 */
class PartidaController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    function __construct() {
        $this->BundleName = 'Catastro';
        $this->EntityName = 'Partida';
        $this->UsePaginator = true;
        parent::__construct();
    }
}
