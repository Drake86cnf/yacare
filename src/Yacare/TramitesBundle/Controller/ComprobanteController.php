<?php
namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("comprobante/")
 */
class ComprobanteController extends \Tapir\BaseBundle\Controller\AbmController
{

    public function guardarActionPrePersist($entity, $editForm)
    {
        $res = parent::guardarActionPrePersist($entity, $editForm);
        
        if (! $entity->getComprobanteTipo()) {
            // La propiedad ComprobanteTipo está en blanco... es normal al crear un trámite nuevo
            // Busco el ComprobanteTipo que corresponde a la clase y lo guardo
            $em = $this->getDoctrine()->getManager();
            
            $NombreClase = '\\' . get_class($entity);
            $ComprobanteTipo = $em->getRepository('YacareTramitesBundle:ComprobanteTipo')->findOneBy(array(
                'Clase' => $NombreClase
            ));
            
            $entity->setComprobanteTipo($ComprobanteTipo);
        }
        
        return $res;
    }
}
