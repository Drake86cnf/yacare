<?php
namespace Yacare\RequerimientosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Yacare\RequerimientosBundle\Entity\Requerimiento;
use Yacare\RequerimientosBundle\Entity\Novedad;

/**
 * Controlador de requerimientos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @Route("requerimiento/")
 */
class RequerimientoController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Tapir\AbmBundle\Controller\ConBuscar;
    use \Yacare\RequerimientosBundle\Controller\ConMailer;
    
    private $vistaMailNuevoRequerimiento = 'YacareRequerimientosBundle:Requerimiento/Mail:requerimiento_nuevo.html.twig';

    function __construct()
    {
        $this->OrderBy = 'r.createdAt';
        
        $this->ConservarVariables[] = 'filtro_encargado';
        $this->ConservarVariables[] = 'filtro_estado';
        $this->ConservarVariables[] = 'filtro_categoria';
    }

    /**
     * Crear un reclamo sin estar autenticado.
     *
     * Muestra un formulario para ingresar el texto del reclamo, la categoría, el nombre de la persona y la dirección
     * de e-mail. Todos los datos son opcionales excepto el texto del reclamo.
     *
     * @Route("anonimo/crear/")
     * @Template()
     */
    public function anonimocrearAction(Request $request)
    {
        $Requerimiento = new \Yacare\RequerimientosBundle\Entity\Requerimiento();
        
        $FormEditar = $this->createForm('Yacare\RequerimientosBundle\Form\RequerimientoAnonimoType', 
            $Requerimiento);
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            if ($Requerimiento->getCategoria() && (! $Requerimiento->getEncargado())) {
                $Requerimiento->setEncargado($Requerimiento->getCategoria()->getEncargado());
            }
            
            $em = $this->getEm();
            $em->persist($Requerimiento);
            $em->flush();
            $this->InformarNovedad($Requerimiento, $this->vistaMailNuevoRequerimiento, 
                $Requerimiento->getSeguimientoNumero());
            
            return $this->redirectToRoute($this->obtenerRutaBase('anonimover_1'),
                array('seg' => $Requerimiento->getSeguimientoNumero()));
        } else {
            $validator = $this->get('validator');
            $Errores = $validator->validate($Requerimiento);
        }
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $Requerimiento;
        $res->AccionGuardar = 'anonimocrear';
        $res->FormularioEditar = $FormEditar->createView();
        $res->Errores = $Errores;
        
        return array('res' => $res);
    }

    /**
     * Consultar el estado un reclamo sin estar autenticado.
     *
     * Se requiere el número de seguimiento. El número de seguimiento está conformado por el ID, un guión y el token.
     *
     * @see \Yacare\RequerimientosBundle\Requerimiento::$Token Requerimiento::$Token
     *
     * @Route("anonimo/ver/")
     * @Route("anonimo/ver/{seg}")
     * @Template()
     */
    public function anonimoverAction(Request $request, $seg = null)
    {
        if (! $seg) {
            $seg = $this->ObtenerVariable($request, 'seg');
        }
        
        if ($seg && strpos($seg, '-') !== false) {
            list ($id, $token) = explode('-', str_replace(array(' ', '.', ',', '/'), array(), $seg), 2);
        } else {
            $id = null;
        }
        
        $res = array('seg' => $seg);
        
        if ($id) {
            $Requerimiento = $this->ObtenerEntidadPorId($id);
            
            if ($Requerimiento->getUsuario() == null && $Requerimiento->getToken() == $token) {
                // Sólo se pueden ver requerimientos de forma anónima si fueron reportados de forma anónima
                // (o sea, si no tienen un usuario asociado) y si proporcionan el token correspondiente.
                
                $res['res'] = $this->ConstruirResultado(
                    new \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction($this), $request);
                $res['res']->Entidad = $Requerimiento;
                
                $AntiguedadEnDias = $Requerimiento->getUpdatedAt()->diff(new \DateTime());
                if ($Requerimiento->getEstado() < 50 || $AntiguedadEnDias->days < 10) {
                    // Sólo se permite publicar novedades si el requerimiento todavía no fue cerrado
                    // o si tuvo actividad en los últimos 10 días.
                    // O sea, los requerimientos cerrados siguen siendo comentables durante 10 días.
                    $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
                    $NuevaNovedad->setAutomatica(0);
                    $NuevaNovedad->setPrivada(0);
                    $NuevaNovedad->setRequerimiento($Requerimiento);
                    $NuevaNovedad->setUsuario(null);
                    
                    $FormularioEditar = $this->createForm('Yacare\RequerimientosBundle\Form\NovedadAnonimaType', 
                        $NuevaNovedad);
                    $FormularioEditar->handleRequest($request);
                    
                    if ($FormularioEditar->isValid()) {
                        $em = $this->getEm();
                        $em->persist($NuevaNovedad);
                        $em->flush();
                    } else {
                        $res['form_novedad'] = $FormularioEditar->createView();
                    }
                }
            }
        }
        return $res;
    }
    
    
    /**
     * Reportar un problema. Ruta estándar de Tapir.
     *
     * @Route("tapirreportarproblema/", name="tapir_reportar_problema")
     * @Template()
     */
    public function tapirreportarproblemaAction(Request $request)
    {
        $request->query->set('catid', 1);
        $request->query->set('form', 'ReportarProblema');
        return $this->editarAction($request);
    }
    
    /**
     * Enviar un comentario. Ruta estándar de Tapir.
     *
     * @Route("tapirenviarcomentario/", name="tapir_enviar_comentario")
     * @Template()
     */
    public function tapirenviarcomentarioAction(Request $request)
    {
        $request->query->set('catid', 1);
        $request->query->set('form', 'ReportarProblema');
        return $this->editarAction($request);
    }


    protected function CrearNuevaEntidad(Request $request) {
        $Entidad = parent::CrearNuevaEntidad($request);
        
        $CategoriaId = $this->ObtenerVariable($request, 'catid');
        if ($CategoriaId > 0) {
            $em = $this->getEm();
            $Categoria = $em->getRepository('\Yacare\RequerimientosBundle\Entity\Categoria')->find($CategoriaId);
            if ($Categoria) {
                $Entidad->setCategoria($Categoria);
            }
        }
        
        $Obs = $this->ObtenerVariable($request, 'obs');
        if($Obs) {
            $Entidad->setObs($Obs);
        }
        
        return $Entidad;
    }
    

    /**
     * Crear un reclamo mediante un asistente.
     *
     * Muestra un asistente que facilita iniciar un requerimiento.
     *
     * @Route("asistente/crear/")
     * @Template()
     */
    public function asistentecrearAction(Request $request)
    {
        $em = $this->getEm();
        $Requerimiento = new \Yacare\RequerimientosBundle\Entity\Requerimiento();
        
        $CategoriaId = $this->ObtenerVariable($request, 'catid');
        if ($CategoriaId > 0) {
            $Categoria = $em->getRepository('\Yacare\RequerimientosBundle\Entity\Categoria')->find($CategoriaId);
            if ($Categoria) {
                $Requerimiento->setCategoria($Categoria);
            }
        } else {
            $Categoria = null;
        }
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        $Requerimiento->setUsuario($UsuarioConectado);
        
        $FormEditar = $this->createForm('Yacare\RequerimientosBundle\Form\RequerimientoType', $Requerimiento);
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            if ($Requerimiento->getCategoria() && (! $Requerimiento->getEncargado())) {
                $Requerimiento->setEncargado($Requerimiento->getCategoria()->getEncargado());
            }
            
            $em->persist($Requerimiento);
            $em->flush();
            $this->InformarNovedad($Requerimiento, $this->vistaMailNuevoRequerimiento);
            
            return $this->redirectToRoute($this->obtenerRutaBase('ver'), 
                $this->ArrastrarVariables($request, array('id' => $Requerimiento->getId()), false));
        } else {
            $validator = $this->get('validator');
            $Errores = $validator->validate($Requerimiento);
        }
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), 
            $request);
        $res->Entidad = $Requerimiento;
        $res->FormularioEditar = $FormEditar->createView();
        $res->AccionGuardar = 'asistentecrear';
        $res->Errores = $Errores;
        $res->Categoria = $Categoria;
        $res->Categorias = $this->ObtenerCategorias();
        
        return array('res' => $res);
    }

    /**
     * Listar, con filtros.
     *
     * @see \Tapir\AbmBundle\Controller\AbmController::listarAction()
     *
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_REQUERIMIENTOS_ADMINISTRADOR')) {
            // Sólo permito filtrar por encargado a los administradores
            $filtro_encargado = $this->ObtenerVariable($request, 'filtro_encargado');
            if ($filtro_encargado == - 1) {
                $this->Where .= " AND r.Encargado IS NULL";
            } elseif ($filtro_encargado > 0) {
                $this->Where .= " AND r.Encargado=$filtro_encargado";
            }
        } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_REQUERIMIENTOS_ENCARGADO')) {
            // Los encargados sólo pueden ver los requerimientos que ellos iniciaron o en los que están como encargados
            $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
            $this->Where .= '(r.Encargado=' . $UsuarioConectado->getId() . " OR r.Usuario=" . $UsuarioConectado->getId() .
                 ')';
        } elseif ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // El resto de los usuarios pueden ver sólo los requerimientos que iniciaron ellos
            $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
            $this->Where .= 'r.Usuario=' . $UsuarioConectado->getId();
        } else {
            throw $this->createAccessDeniedException();
        }
        
        $filtro_estado = (int) $this->ObtenerVariable($request, 'filtro_estado');
        
        switch ($filtro_estado) {
            case 0:
            // no break
            case null:
            case '':
                // Filtro predeterminado (nuevos, iniciados y en espera)
                $this->Where .= " AND r.Estado NOT IN (80, 99)";
                break;
            case - 1:
                // Sin filtro. Mostrar todos
                break;
            default:
                $this->Where .= " AND r.Estado=" . $filtro_estado;
                break;
        }
        
        $filtro_categoria = (int) $this->ObtenerVariable($request, 'filtro_categoria');
        if ($filtro_categoria == - 1) {
            $this->Where .= " AND r.Categoria IS NULL";
        } elseif ($filtro_categoria) {
            $this->Where .= " AND r.Categoria=" . $filtro_categoria;
        }
        
        $res = parent::listarAction($request);
        
        if ($this->get('security.authorization_checker')->isGranted('ROLE_REQUERIMIENTOS_ADMINISTRADOR')) {
            $res['encargados'] = $this->ObtenerEncargados();
        }
        
        $res['categorias'] = $this->ObtenerCategorias();
        
        // echo $this->obtenerComandoSelect();
        // echo $filtro_estado;
        
        return $res;
    }

    /**
     * Obtiene una lista de personas con el rol encargado de requerimientos.
     */
    private function ObtenerEncargados()
    {
        return $this->getEm()->getRepository('\Yacare\BaseBundle\Entity\Persona')->ObtenerPorRol(
            'ROLE_REQUERIMIENTOS_ENCARGADO');
    }

    /**
     * Obtiene una lista de categorías de requerimientos.
     */
    private function ObtenerCategorias()
    {
        return $this->getEm()->getRepository('\Yacare\RequerimientosBundle\Entity\Categoria')->findAll();
    }

    /**
     * Ver un requerimiento, con formulario para publicar una novedad.
     *
     * @Route("ver/")
     * @Template()
     */
    public function verAction(Request $request)
    {
        $res = parent::verAction($request);
        
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        
        if (! is_string($UsuarioConectado)) {
            $AntiguedadEnDias = $res['res']->Entidad->getUpdatedAt()->diff(new \DateTime());
            if ($res['res']->Entidad->getEstado() < 50 || $AntiguedadEnDias->days < 30) {
                // Sólo se permite publicar novedades si el requerimiento todavía no fue cerrado
                // o si tuvo actividad en los últimos 30 días.
                // O sea, los requerimientos cerrados siguen siendo comentables durante 30 días.
                $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
                $NuevaNovedad->setPrivada(1);
                $NuevaNovedad->setRequerimiento($res['res']->Entidad);
                $NuevaNovedad->setUsuario($UsuarioConectado);
                $FormEditar = $this->createForm('Yacare\RequerimientosBundle\Form\NovedadType', $NuevaNovedad);
                $res['form_novedad'] = $FormEditar->createView();
            }
        }
        return $res;
    }

    /**
     * Cambia el estado del requerimiento y agrega una novedad informando el nuevo estado.
     *
     * @Route("cambiarestado/")
     * @Template()
     */
    public function cambiarestadoAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        
        if ($id) {
            $entity = $this->ObtenerEntidadPorId($id);
        }
        $NuevoEstado = $this->ObtenerVariable($request, 'nuevoestado');
        
        $em = $this->getEm();
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        
        if (! is_string($UsuarioConectado)) {
            $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
            $NuevaNovedad->setRequerimiento($entity);
            $NuevaNovedad->setUsuario($UsuarioConectado);
            $NuevaNovedad->setPrivada(0);
            $NuevaNovedad->setAutomatica(1);
            switch ($NuevoEstado) {
                case 0:
                    // no break;
                    break;
                case 10:
                    if ($entity->getEstado() == 0) {
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
                    $NuevaNovedad->setNotas(
                        "El estado del requerimiento ahora es " .
                             \Yacare\RequerimientosBundle\Entity\Requerimiento::getEstadoNombres($NuevoEstado));
                    break;
            }
            $em->persist($NuevaNovedad);
            $this->InformarNovedad($NuevaNovedad);
        }
        
        $entity->setEstado($NuevoEstado);
        $em->persist($entity);
        $em->flush();
        
        return $this->redirectToRoute($this->obtenerRutaBase('ver'), 
            $this->ArrastrarVariables($request, array('id' => $id), false));
    }

    /**
     * Intervengo el guardado para asignar el usuario creador y un encargado predeterminado encaso de que no tenga uno.
     */
    public function guardarActionPrePersist($entity, $FormEditar)
    {
        if ((! $entity->getId())) {
            if (! $entity->getUsuario()) {
                $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
                $entity->setUsuario($UsuarioConectado);
                $entity->setUsuarioNombre((string) $UsuarioConectado);
                $entity->setUsuarioEmail($UsuarioConectado->getEmail());
            }
            if ($entity->getCategoria() && (! $entity->getEncargado())) {
                $entity->setEncargado($entity->getCategoria()->getEncargado());
            }
        }
        return parent::guardarActionPrePersist($entity, $FormEditar);
    }

    /**
     * Rechazar una asignación.
     *
     * @Route("rechazar/")
     * @Template()
     */
    public function rechazarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getEm();
        
        if ($id) {
            $entity = $this->ObtenerEntidadPorId($id);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        
        $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
        $NuevaNovedad->setPrivada(1);
        $NuevaNovedad->setRequerimiento($entity);
        $NuevaNovedad->setUsuario($UsuarioConectado);
        
        $FormEditar = $this->createForm('Yacare\RequerimientosBundle\Form\RechazarType', $NuevaNovedad);
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            // Pongo en blanco el encargado.
            $entity->setEncargado(null);
            
            $NuevaNovedad->setNotas('El encargado rechazó la asignación: ' . $NuevaNovedad->getNotas());
            $NuevaNovedad->setAutomatica(0);
            
            $this->InformarNovedad($NuevaNovedad);
            $em->persist($NuevaNovedad);
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl($this->obtenerRutaBase('ver'), 
                $this->ArrastrarVariables($request, array('id' => $id), false)));
        } else {
            $children = $FormEditar->all();
            foreach ($children as $child) {
                (string) $child->getErrors();
            }
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
        $res->AccionGuardar = 'rechazar';
        $res->Entidad = $entity;
        $res->FormularioEditar = $FormEditar->createView();
        $res->FormularioEliminar = null;
        
        return array('res' => $res);
    }

    /**
     * Asginar un requerimiento a un encargado.
     *
     * @Route("asignar/")
     * @Template()
     */
    public function asignarAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getEm();
        
        if ($id) {
            $entity = $this->ObtenerEntidadPorId($id);
        }
        
        if (! $entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        
        $NuevaNovedad = new \Yacare\RequerimientosBundle\Entity\Novedad();
        $NuevaNovedad->setPrivada(1);
        $NuevaNovedad->setRequerimiento($entity);
        $NuevaNovedad->setUsuario($UsuarioConectado);
        
        $FormEditar = $this->createForm('Yacare\RequerimientosBundle\Form\AsignarType', $NuevaNovedad);
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            // Asigno el nuevo encargado.
            $entity->setEncargado($NuevaNovedad->getUsuario());
            
            if ($NuevaNovedad->getNotas()) {
                $NuevaNovedad->setAutomatica(0);
            } else {
                $NuevaNovedad->setAutomatica(1);
            }
            
            $NuevaNovedad->setNotas(
                'El nuevo encargado es ' . $NuevaNovedad->getUsuario() . '. ' . $NuevaNovedad->getNotas());
            $NuevaNovedad->setUsuario($UsuarioConectado);
            
            $this->InformarNovedad($NuevaNovedad);
            $em->persist($NuevaNovedad);
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl($this->obtenerRutaBase('ver'), 
                $this->ArrastrarVariables($request, array('id' => $id), false)));
        } else {
            $children = $FormEditar->all();
            foreach ($children as $child) {
                (string) $child->getErrors();
            }
            
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
        $res->AccionGuardar = 'asignar';
        $res->Entidad = $entity;
        $res->FormularioEditar = $FormEditar->createView();
        $res->FormularioEliminar = null;
        
        return array('res' => $res);
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
        
        $CategoriaAnterior = $entity->getCategoria();
        
        $campoNombre = $this->ObtenerVariable($request, 'campo_nombre');
        $FormEditarBuilder = $this->createFormBuilder($entity);
        
        $UsuarioConectado = $this->get('security.token_storage')->getToken()->getUser();
        $NuevaNovedad = new Novedad();
        $NuevaNovedad->setPrivada(1);
        $NuevaNovedad->setRequerimiento($entity);
        $NuevaNovedad->setUsuario($UsuarioConectado);
        
        switch ($campoNombre) {
            case 'Categoria':
                $FormEditarBuilder->add($campoNombre, 'entity', array(
                    'label' => 'Categoría', 
                    'placeholder' => 'Sin categoría',
                    'attr' => array('class' => 'tapir-input-320'),
                    'class' => 'YacareRequerimientosBundle:Categoria', 
                    'required' => false));
                $NuevaNovedad->setAutomatica(1);
                break;
        }
        
        $FormEditar = $FormEditarBuilder->getForm();
        $FormEditar->handleRequest($request);
        
        if ($FormEditar->isValid()) {
            switch ($campoNombre) {
                case 'Categoria':
                    if ($entity->getCategoria() != $CategoriaAnterior) {
                        if ($entity->getCategoria()) {
                            if (! $entity->getEncargado() && $entity->getCategoria()->getEncargado()) {
                                $entity->setEncargado(
                                    $entity->getCategoria()->getEncargado());
                                $NuevaNovedad->setNotas(
                                    'El requerimiento fue movido a la categoría ' . $entity->getCategoria() .
                                         '. El encargado es ' . $entity->getEncargado());
                            } else {
                                $NuevaNovedad->setNotas(
                                    'El requerimiento fue movido a la categoría ' . $entity->getCategoria() . '.');
                            }
                        } else {
                            $NuevaNovedad->setNotas('El requerimiento fue movido a "Sin categoría".');
                        }
                        $this->InformarNovedad($NuevaNovedad);
                        $em->persist($NuevaNovedad);
                        $em->persist($entity);
                        $em->flush();
                    }
                    break;
            }
            return $this->redirect($this->generateUrl($this->obtenerRutaBase('ver'), 
                $this->ArrastrarVariables($request, array('id' => $id), false)));
        } else {
            $children = $FormEditar->all();
            foreach ($children as $child) {
                (string) $child->getErrors();
            }
            
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
        $res->FormularioEditar = $FormEditar->createView();
        $res->Errores = $Errores;
        
        return array('res' => $res, 'campo_nombre' => $campoNombre);
    }
}
