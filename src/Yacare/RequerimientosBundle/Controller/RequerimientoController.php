<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
    
    
    function __construct() {
        $this->OrderBy = 'r.createdAt';
        
        $this->ConservarVariables[] = 'filtro_encargado';
        $this->ConservarVariables[] = 'filtro_estado';
        $this->ConservarVariables[] = 'filtro_categoria';
    }


    /**
     * Crear un reclamo sin estar autenticado.
     *
     * @Route("../../pub/requerimiento/anonimo")
     * @Template()
     */
    public function crearanonimoAction() {
        return array();
    }
    
    
    
    /**
     * Listar, con filtros.
     * 
     * @see \Tapir\BaseBundle\Controller\AbmController::listarAction()
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_REQUERIMIENTOS_ADMINISTRADOR')) {
            // Sólo permito filtrar por encargado a los administradores
            $filtro_encargado = $this->ObtenerVariable($request, 'filtro_encargado');
            if ($filtro_encargado == -1) {
                $this->Where .= " AND r.Encargado IS NULL";
            } elseif ($filtro_encargado > 0) {
                $this->Where .= " AND r.Encargado=$filtro_encargado";
            }
        } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_REQUERIMIENTOS_ENCARGADO')) {
            // Los encargados sólo pueden ver los requerimientos que ellos iniciaron o en los que están como encargados
            $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
            $this->Where .= '(r.Encargado=' . $UsuarioConectado->getId() . " OR r.Usuario=" . $UsuarioConectado->getId() . ')';
        } elseif ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // El resto de los usuarios pueden ver sólo los requerimientos que iniciaron ellos
            $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
            $this->Where .= 'r.Usuario=' . $UsuarioConectado->getId();
        } else {
            throw $this->createAccessDeniedException();
        }
        
        $filtro_estado = (int)$this->ObtenerVariable($request, 'filtro_estado');
        switch ($filtro_estado) {
            case 0:
            case null:
            case '':
                // Filtro predeterminado (nuevos, iniciados y en espera)
                $this->Where .= " AND r.Estado<50";
                break;
            case -1:
                // Sin filtro. Mostrar todos
                break;
            default:
                $this->Where .= " AND r.Estado=" . $filtro_estado;
                break;
        }
        
        $filtro_categoria = (int)$this->ObtenerVariable($request, 'filtro_categoria');
        if($filtro_categoria == -1) {
            $this->Where .= " AND r.Categoria IS NULL";
        } elseif($filtro_categoria) {
            $this->Where .= " AND r.Categoria=" . $filtro_categoria;
        }
        
        $res = parent::listarAction($request);
        
        if ($this->get('security.authorization_checker')->isGranted('ROLE_REQUERIMIENTOS_ADMINISTRADOR')) {
            $res['encargados'] = $this->ObtenerEncargados();
        }
        
        $res['categorias'] = $this->ObtenerCategorias();
        
        //echo $this->obtenerComandoSelect();
        //echo $filtro_estado;
        
        return $res;
    }
    
    
    private function ObtenerEncargados()
    {
        return $this->getEm()->getRepository('\Yacare\BaseBundle\Entity\Persona')->ObtenerPorRol('ROLE_REQUERIMIENTOS_ENCARGADO');
    }
    
    
    private function ObtenerCategorias()
    {
        return $this->getEm()->getRepository('\Yacare\RequerimientosBundle\Entity\Categoria')->findAll();
    }
    
   

    /**
     * @Route("ver/{id}")
     * @Template()
     */
    public function verAction(Request $request, $id = null)
    {
        $res = parent::verAction($request, $id);
        
        // $em = $this->getEm();
        $UsuarioConectado = $this->get('security.token_storage')
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
        $UsuarioConectado = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        
        if (! is_string($UsuarioConectado)) {
            $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
            $NuevaNovedad->setRequerimiento($entity);
            $NuevaNovedad->setUsuario($UsuarioConectado);
            $NuevaNovedad->setAutomatica(1);
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
                $UsuarioConectado = $this->get('security.token_storage')
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
     * Rechazar una asignación.
     *
     * @Route("rechazar/{id}")
     * @Template()
     */
    public function rechazarAction(Request $request, $id = null)
    {
        $em = $this->getEm();
        
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        
        $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
        $NuevaNovedad->setRequerimiento($entity);
        $NuevaNovedad->setUsuario($UsuarioConectado);
        
        $editForm = $this->createForm(new \Yacare\RequerimientosBundle\Form\RechazarType(), $NuevaNovedad);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            // Pongo en blanco el encargado.
            $entity->setEncargado(null);
            
            $NuevaNovedad->setNotas('El encargado rechazó la asignación: ' . $NuevaNovedad->getNotas());
            $NuevaNovedad->setAutomatica(0);

            $em->persist($NuevaNovedad);
            $em->persist($entity);
            $em->flush();
            return $this->redirect(
                $this->generateUrl($this->obtenerRutaBase('ver'), $this->ArrastrarVariables($request, array('id' => $id), false)));
        } else {
            $children = $editForm->all();
            foreach ($children as $child) {
                $child->getErrorsAsString();
            }
        
            $errors = $editForm->getErrors(true, true);
        }
        
        if ($errors) {
            foreach ($errors as $error) {
                $this->get('session')
                ->getFlashBag()
                ->add('danger', $error->getMessage());
            }
        } else {
            $errors = null;
        }
        
        return $this->ArrastrarVariables($request,
            array(
                'edit_form' => $editForm->createView(),
                'edit_form_action' => $this->obtenerRutaBase('rechazar'),
                'entity' => $entity,
                'errors' => $errors));
        return array();
    }
    
    
    
    /**
     * Asginar un requerimiento a un encargado.
     *
     * @Route("asignar/{id}")
     * @Template()
     */
    public function asignarAction(Request $request, $id = null)
    {
        $em = $this->getEm();
    
        if ($id) {
            $entity = $this->obtenerEntidadPorId($id);
        }
    
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
    
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
    
        $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
        $NuevaNovedad->setRequerimiento($entity);
        $NuevaNovedad->setUsuario($UsuarioConectado);
    
        $editForm = $this->createForm(new \Yacare\RequerimientosBundle\Form\AsignarType(), $NuevaNovedad);
        $editForm->handleRequest($request);
    
        if ($editForm->isValid()) {
            // Asigno el nuevo encargado.
            $entity->setEncargado($NuevaNovedad->getUsuario());
    
            if($NuevaNovedad->getNotas()) {
                $NuevaNovedad->setAutomatica(0);
            } else {
                $NuevaNovedad->setAutomatica(1);
            }
            $NuevaNovedad->setNotas('El nuevo encargado es ' . $NuevaNovedad->getUsuario() . '. ' . $NuevaNovedad->getNotas());
            $NuevaNovedad->setUsuario($UsuarioConectado);
           
            $em->persist($NuevaNovedad);
            $em->persist($entity);
            $em->flush();
            return $this->redirect(
                $this->generateUrl($this->obtenerRutaBase('ver'), $this->ArrastrarVariables($request, array('id' => $id), false)));
        } else {
            $children = $editForm->all();
            foreach ($children as $child) {
                $child->getErrorsAsString();
            }
    
            $errors = $editForm->getErrors(true, true);
        }
    
        if ($errors) {
            foreach ($errors as $error) {
                $this->get('session')
                ->getFlashBag()
                ->add('danger', $error->getMessage());
            }
        } else {
            $errors = null;
        }
    
        return $this->ArrastrarVariables($request,
            array(
                'edit_form' => $editForm->createView(),
                'edit_form_action' => $this->obtenerRutaBase('asignar'),
                'entity' => $entity,
                'errors' => $errors));
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
