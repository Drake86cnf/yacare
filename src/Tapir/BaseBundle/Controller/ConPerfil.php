<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Trait para agregar al controlador de usuarios, para agregarle funciones de manejo de perfil.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConPerfil
{
    /**
     * @Route("editarperfil/", name="usuario_editarperfil")
     * @Route("editarperfil/", name="usuario_editarperfil_actual")
     * @Template()
     */
    public function editarperfilAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $entidadUsuario = $this->container->getParameter('tapir_usuarios_entidad');

        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $entity = $em->getRepository($entidadUsuario)->find($id);
            $user = null;
        } else {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entity = $em->getRepository($entidadUsuario)->find($user->getId());
        }

        if ($entity->getUsername()) {
            $FormEditar = $this->createForm('Yacare\BaseBundle\Form\PersonaPerfilType', $entity);
        } else {
            $FormEditar = $this->createForm('Yacare\BaseBundle\Form\PersonaPerfilCrearType', $entity);
        }

        if ($request->getMethod() === 'POST') {
            $FormEditar->handleRequest($request);

            if ($FormEditar->isValid()) {
                if ($entity->getPasswordEnc()) {
                    // Genero una nueva sal
                    $entity->setSalt(md5(uniqid(null, true)));
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($entity);
                    $encoded_password = $encoder->encodePassword($entity->getPasswordEnc(), $entity->getSalt());
                    $entity->setPassword($encoded_password);
                } else {
                    $entity->setPassword();
                }

                $em->persist($entity);
                $em->flush();

                $this->editarperfilActionPostPersist($entity, $FormEditar);

                $this->addFlash('success', 'Los cambios en "' . $entity . '" fueron guardados.');
                $Errores = null;
            } else {
                $validator = $this->get('validator');
                $Errores = $validator->validate($entity);
            }

            if ($Errores) {
                foreach ($Errores as $error) {
                    $this->addFlash('danger', $error->getMessage());
                }
                
                $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), $request);
                $res->Entidad = $entity;
                $res->FormularioEditar = $FormEditar->createView();
                $res->AccionGuardar = 'usuario_editarperfil';
                $res->Errores = $Errores;

                $res = $this->ArrastrarVariables($request, array(
                    'entity' => $entity,
                    'errors' => $Errores,
                    'create' => $id ? false : true,
                    'edit_form' => $FormEditar->createView(),
                    'res' => $res
                ));

                return $this->render('YacareBaseBundle:Persona:editarperfil.html.twig', $res);
            } else {
                if ($user) {
                    $em->refresh($user);
                }
            }
        }
        
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), $request);
        $res->Entidad = $entity;
        $res->FormularioEditar = $FormEditar->createView();
        $res->AccionGuardar = 'usuario_editarperfil';
        
        return $this->ArrastrarVariables($request, array(
            'entity' => $entity,
            'edit_form_action' => 'usuario_editarperfil',
            'edit_form' => $FormEditar->createView(),
            'res' => $res
        ));
    }

    /**
     * @Route("cambiarcontrasena/", name="usuario_cambiarcontrasena")
     * @Route("cambiarcontrasena/", name="usuario_cambiarcontrasena_actual")
     * @Template()
     */
    public function cambiarcontrasenaAction(Request $request)
    {
        $id = $this->ObtenerVariable($request, 'id');
        $terminado = 0;
        $entidadUsuario = $this->container->getParameter('tapir_usuarios_entidad');

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $entity = $em->getRepository($entidadUsuario)->find($id);
        } else {
            $entity = $em->getRepository($entidadUsuario)->find($user->getId());
        }

        if ($entity->getId() == $user->getId()) {
            // Es el usuario conectado, muestro "cambiar contraseña"
            $FormEditar = $this->createForm('Yacare\BaseBundle\Form\PersonaCambiarContrasenaType', $entity);
        } else {
            // Es para otro usuario, muestro "crear contraseña"
            $FormEditar = $this->createForm('Yacare\BaseBundle\Form\PersonaCrearContrasenaType', $entity);
        }
        $FormEditar->handleRequest($request);

        if ($FormEditar->isValid()) {
            // TODO: hay que validar que haya puesto la contraseña actual.
            //$factory = $this->get('security.encoder_factory');

            // Guardo el password con hash
            if ($entity->getPasswordEnc()) {
                // Genero una nueva sal
                $entity->setSalt(md5(uniqid(null, true)));

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $encoded_password = $encoder->encodePassword($entity->getPasswordEnc(), $entity->getSalt());
                $entity->setPassword($encoded_password);
            } else {
                $entity->setPassword();
            }

            $Terminado = 1;
            $em->persist($entity);
            $em->flush();
            
            if (isset($user)) {
                $em->refresh($user);
            }
            
            $Errores = null;

            $this->cambiarcontrasenaActionPostPersist($entity, $FormEditar);
        } else {
            $validator = $this->get('validator');
            $Errores = $validator->validate($entity);
            $Terminado = 0;
        }

        if ($Errores) {
            foreach ($Errores as $error) {
                $this->addFlash('danger', $error->getMessage());
            }
        }

        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this), $request);
        $res->Entidad = $entity;
        $res->Errores = $Errores;
        $res->FormularioEditar = $FormEditar->createView();
        $res->AccionGuardar = 'usuario_cambiarcontrasena';
        $res->Terminado = $Terminado;
        
        return array('res' => $res);
    }

    /**
     * Función para que las clases derivadas puedan intervenir la entidad después de guardar el perfil.
     */
    public function editarperfilActionPostPersist($entity, $editForm)
    {
        return;
    }

    /**
     * Función para que las clases derivadas puedan intervenir la entidad después de cambiar la contraseña.
     */
    public function cambiarcontrasenaActionPostPersist($entity, $editForm)
    {
        return;
    }
}
