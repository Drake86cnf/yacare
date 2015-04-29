<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("requerimiento/")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequerimientoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConBuscar;
    
    /**
     * @Route("ver/{id}")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        $res = parent::verAction($request, $id);
    
        //$em = $this->getEm();
        $UsuarioConectado = $this->get('security.context')->getToken()->getUser();
        
        if( !is_string($UsuarioConectado)) {
            $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
            $NuevaNovedad->setRequerimiento($res['entity']);
            $NuevaNovedad->setUsuario($UsuarioConectado);
            $editForm = $this->createForm(new \Yacare\RequerimientosBundle\Form\NovedadType(), $NuevaNovedad);
            $res['form_novedad'] = $editForm->createView();
        }
    
        return $res;
    }
    
    
   
    
    /**
     * Intervengo el guardado para asignar el usuario creador y un encargado predeterminado encaso de que no tenga uno.
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        if((!$entity->getId())) {
            if(!$entity->getUsuario()) {
                $UsuarioConectado = $this->get('security.context')->getToken()->getUser();
                $entity->setUsuario($UsuarioConectado);
                $entity->setUsuarioNombre((string)$UsuarioConectado);
                $entity->setUsuarioEmail($UsuarioConectado->getEmail());
            }
            if($entity->getCategoria() && (!$entity->getEncargado())) {
                $entity->setEncargado($entity->getCategoria()->getEncargado());
            }
        }
        
        return parent::guardarActionPrePersist($entity, $editForm);
    }
}
