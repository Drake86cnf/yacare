<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\RequerimientosBundle\Entity\Requerimiento;

/**
 * Controlador de requerimientos.
 * 
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
        
        // $em = $this->getEm();
        $UsuarioConectado = $this->get('security.context')
            ->getToken()
            ->getUser();
        
        if (! is_string($UsuarioConectado)) {
            $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
            $NuevaNovedad->setRequerimiento($res['entity']);
            $NuevaNovedad->setUsuario($UsuarioConectado);
            $editForm = $this->createForm(new \Yacare\RequerimientosBundle\Form\NovedadType(), $NuevaNovedad);
            $res['form_novedad'] = $editForm->createView();
        }
        
        return $res;
    }

    /**
     * Cambia el estado del requerimiento y agrega una novedad informando el nuevo estado.
     * 
     * @Route("cambiarestado/{id}")
     * @Template()
     */
    public function cambiarestadoAction(Request $request, $id = null)
    {
        if (! $id) {
            $id = $this->ObtenerVariable($request, 'id');
        }
        
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        }
        
        $NuevoEstado = $this->ObtenerVariable($request, 'nuevoestado');
        
        $em = $this->getEm();
        $UsuarioConectado = $this->get('security.context')
            ->getToken()
            ->getUser();
        
        if (! is_string($UsuarioConectado)) {
            $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
            $NuevaNovedad->setRequerimiento($entity);
            $NuevaNovedad->setUsuario($UsuarioConectado);
            switch ($NuevoEstado) {
                case 0:
                    break;
                case 10:
                    if($entity->getEstado() == 0) {
                        $NuevaNovedad->setNotas("El requerimiento fue iniciado.");
                    } else {
                        $NuevaNovedad->setNotas("El requerimiento fue reiniciado.");
                    }
                    break;
                case 20:
                    $NuevaNovedad->setNotas("El requerimiento fue puesto en espera.");
                    break;
                case 80:
                    $NuevaNovedad->setNotas("El requerimiento fue cancelado.");
                    break;
                case 90:
                    $NuevaNovedad->setNotas("El requerimiento se marcó como terminado.");
                    break;
                case 99:
                    $NuevaNovedad->setNotas("El requerimiento fue cerrado.");
                    break;
                default:
                    $NuevaNovedad->setNotas("El estado del requerimiento ahora es " . \Yacare\RequerimientosBundle\Entity\Requerimiento::getEstadoNombres($NuevoEstado));
                    break;
            }
            $em->persist($NuevaNovedad);
        }
        
        $entity->setEstado($NuevoEstado);
        $em->persist($entity);
        $em->flush();
        
        return $this->redirectToRoute($this->obtenerRutaBase('ver'), $this->ArrastrarVariables($request, array('id' => $id), false));
    }


    /**
     * Intervengo el guardado para asignar el usuario creador y un encargado predeterminado encaso de que no tenga uno.
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        if ((! $entity->getId())) {
            if (! $entity->getUsuario()) {
                $UsuarioConectado = $this->get('security.context')
                    ->getToken()
                    ->getUser();
                $entity->setUsuario($UsuarioConectado);
                $entity->setUsuarioNombre((string) $UsuarioConectado);
                $entity->setUsuarioEmail($UsuarioConectado->getEmail());
            }
            if ($entity->getCategoria() && (! $entity->getEncargado())) {
                $entity->setEncargado($entity->getCategoria()
                    ->getEncargado());
            }
        }
        
        return parent::guardarActionPrePersist($entity, $editForm);
    }

    
    /**
     * Asignar el requerimiento a un encargado.
     * 
     * @Route("asignar/{id}")
     * @Template()
     */
    public function asignarAction(Request $request, $id = null)
    {
        return array();
    }
    

    /**
     * Muestra un pequeño formulario para modificar un dato.
     *
     * @Route("modificardato/{id}")
     * @Template()
     */
    public function modificardatoAction(Request $request, $id)
    {
        // Ver PersonaController->modificardatoAction()
        return array();
    }
}
