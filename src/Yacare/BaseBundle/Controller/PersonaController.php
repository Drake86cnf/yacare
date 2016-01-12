<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de personas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("persona/")
 */
class PersonaController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConVer;
    use \Tapir\AbmBundle\Controller\ConBuscar;
    use \Tapir\AbmBundle\Controller\ConEliminar;
    use \Tapir\BaseBundle\Controller\ConPerfil;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        $this->BuscarPor = 'NombreVisible, Username, RazonSocial, DocumentoNumero, Cuilt, Email';
        $this->OrderBy = 'r.NombreVisible';
        $this->ConservarVariables[] = 'filtro_grupo';
        $this->ConservarVariables[] = 'filtro_rol';
        $this->ConservarVariables[] = 'filtro_grupo_invertir';
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_grupo = $this->ObtenerVariable($request, 'filtro_grupo');
        $filtro_grupo_invertir = $this->ObtenerVariable($request, 'filtro_grupo_invertir');
        $filtro_rol = $this->ObtenerVariable($request, 'filtro_rol');
        
        if ($filtro_grupo) {
            $this->Joins[] = "LEFT JOIN r.Grupos g";
            if ($filtro_grupo_invertir) {
                $this->Where .= " AND g.id<>$filtro_grupo";
            } else {
                $this->Where .= " AND g.id=$filtro_grupo";
            }
        }
        if ($filtro_rol) {
            $this->Joins[] = "LEFT JOIN r.UsuarioRoles ur";
            $this->Where .= " AND ur.id=$filtro_rol";
        }
        $ResultadoListar = parent::listarAction($request);
        $res = $ResultadoListar['res'];
        
        // Agrego una lista de grupos y roles al resultado
        $res->PersonasGrupos = $this->ObtenerGrupos();
        $res->PersonasRoles = $this->ObtenerRoles();
        
        return $ResultadoListar;
    }

    /**
     * Devuelve todos los grupos para personas.
     *
     * @return \Yacare\BaseBundle\Entity\PersonaGrupo
     */
    private function ObtenerGrupos()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT r.id, r.Nombre FROM YacareBaseBundle:PersonaGrupo r ORDER BY r.Nombre");
        return $query->getResult();
    }
    
    /**
     * Devuelve todos los roles para personas.
     *
     * @return \Yacare\BaseBundle\Entity\PersonaRol
     */
    private function ObtenerRoles()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT r.id, r.Nombre FROM TapirBaseBundle:PersonaRol r ORDER BY r.Nombre");
        return $query->getResult();
    }

    /**
     * Actualizo el servidor de dominio al editar el perfil de usuario.
     */
    public function editarperfilActionPostPersist($entity, $FormEditar)
    {
        /*
         * if ($entity->getAgenteId()) {
         * // Es un agente municipal, lo actualizo en el LDAP
         * $em = $this->getDoctrine()->getManager();
         * $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($entity->getAgenteId());
         * $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);
         * $ldap->AgregarOActualizarAgente($Agente);
         * $ldap = null;
         * }
         * return;
         */
    }

    /**
     * Actualizo el servidor de dominio al cambiar la contraseña.
     */
    public function cambiarcontrasenaActionPostPersist($entity, $FormEditar)
    {
        /*
         * if ($entity->getAgenteId()) {
         * // Es un agente municipal, lo actualizo en el LDAP
         * $em = $this->getDoctrine()->getManager();
         * $Agente = $em->getRepository('Yacare\RecursosHumanosBundle\Entity\Agente')->find($entity->getAgenteId());
         * $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);
         * $ldap->CambiarContrasena($Agente);
         * $ldap = null;
         * }
         * return;
         */
    }

    /**
     * Muestra un pequeño formulario para modificar un dato.
     *
     * @Route("modificardato/")
     * @Template()
     */
    public function modificardatoAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getEm();
        
        if ($id) {
            $entity = $this->ObtenerEntidadPorId($id);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $campoNombre = $this->ObtenerVariable($request, 'campo_nombre');
        $FormEditarBuilder = $this->createFormBuilder($entity);
        
        switch ($campoNombre) {
            case 'Cuilt':
                $FormEditarBuilder->add($campoNombre, 'Tapir\BaseBundle\Form\Type\CuiltType', 
                    array('label' => 'CUIL/CUIT', 'required' => true));
                break;
            case 'DocumentoNumero':
                $FormEditarBuilder->add($campoNombre, 'Yacare\BaseBundle\Form\Type\DocumentoType', 
                    array('label' => 'Documento'));
                break;
            case 'Domicilio':
                $FormEditarBuilder->add($campoNombre, 'Yacare\BaseBundle\Form\Type\DomicilioType', 
                    array('label' => 'Domicilio', 'required' => true));
                break;
            case 'TelefonoNumero':
                $FormEditarBuilder
                    ->add($campoNombre, null, array('label' => 'Teléfono(s)', 'required' => true))
                    ->add('TelefonoVerificacionNivel', 
                        'Tapir\BaseBundle\Form\Type\VerificacionNivelType', 
                        array('label' => 'Nivel', 'required' => true));
                break;
            case 'Email':
                $FormEditarBuilder
                    ->add($campoNombre, 'Symfony\Component\Form\Extension\Core\Type\TextType', array('label' => 'Correo electrónico', 'required' => true))
                    ->add($campoNombre . 'VerificacionNivel', 'Tapir\BaseBundle\Form\Type\VerificacionNivelType', 
                        array('label' => 'Nivel', 'required' => true));
                break;
            case 'Pais':
                $FormEditarBuilder->add('Pais', 'entity', array(
                    'label' => 'Nacionalidad', 
                    'placeholder' => 'Sin especificar', 
                    'class' => 'YacareBaseBundle:Pais',
                    'attr' => array('class' => 'tapir-input-320'),
                    'required' => false, 
                    'preferred_choices' => $em->getRepository($this->CompleteEntityName)->findById(
                        array(1, 2, 11, 15))));
                break;
            case 'Genero':
                $FormEditarBuilder->add('Genero', 'Tapir\BaseBundle\Form\Type\GeneroType', 
                    array('label' => 'Género', 'required' => true));
                break;
        }
        
        $FormEditar = $FormEditarBuilder->getForm();
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            return $this->redirectToRoute($this->obtenerRutaBase('ver'), 
                $this->ArrastrarVariables($request, array('id' => $id), false));
        } else {
            $Errores = $FormEditar->getErrors(true, true);
        }
        
        if ($Errores) {
            foreach ($Errores as $error) {
                $this->get('session')->getFlashBag()->add('danger', $error->getMessage());
            }
        } else {
            $Errores = null;
        }
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $entity;
        $res->AccionGuardar = 'modificardato';
        $res->FormularioEditar = $FormEditar->createView();
        $res->Errores = $Errores;
        
        return $this->ArrastrarVariables($request, 
            array('campo_nombre' => $campoNombre, 'res' => $res));
    }

    /**
     * Muestra un formulario para desduplicar dos personas (combinar registros duplicados).
     *
     * @Route("desduplicar/{id1}/{id2}")
     * @Template()
     */
    public function desduplicarAction(Request $request, $id1, $id2, $ok = 0)
    {
        if ($id1) {
            $entity1 = $this->ObtenerEntidadPorId($id1);
        }
        
        if ($id2) {
            $entity2 = $this->ObtenerEntidadPorId($id2);
        }
        
        if ($ok) {}
        
        return $this->ArrastrarVariables($request, array('entity1' => $entity1, 'entity2' => $entity2));
    }
}
