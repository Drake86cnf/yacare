<?php

namespace Tapir\AyudaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Trait que agrega el action de ayuda a un controlador.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConAyuda
{
    /**
     * @Route("ayuda/")
     * @Template()
     */
    public function ayudaAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Tapir\AyudaBundle\Helper\Resultados\ResultadoAyudaAction($this),
            $request);
        $res->Seccion = $this->ObtenerVariable($request, 'sec');
    
        return array('res' => $res);
    }
}