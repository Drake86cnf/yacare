<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de rastreadores GPS.
 *
 * @Route("dispositivorastreadorgps/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DispositivoRastreadorGpsController extends DispositivoController
{
    /**
     * @Route("ver/{id}")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        $res = parent::verAction($request, $id);
    
        $em = $this->getEm();
        $res['ultimorastreo'] = $em->getRepository('Yacare\BaseBundle\Entity\DispositivoRastreo')
            ->findBy( array ( 'Dispositivo' => $id ), array('id' => 'DESC'), 1 );
        
        if(count($res['ultimorastreo']) == 1) {
            // Si es un array de un 1 elemento, lo convierto en un elemento plano.
            $res['ultimorastreo'] = $res['ultimorastreo'][0];
        }
    
        return $res;
    }
}
