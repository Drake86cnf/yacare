<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de usuarios.
 *
 * @Route("usuario/")
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class UsuarioController extends AbmController
{
    private $PassOriginal = '';

    function IniciarVariables()
    {
        parent::IniciarVariables();
        $this->CompleteEntityName = $this->container->getParameter('tapir_usuarios_entidad');
        
        $PartesNombreClase = \Tapir\BaseBundle\Helper\StringHelper::ObtenerBundleYEntidad(get_class($this));
        $this->BundleName = $PartesNombreClase[0];
        $this->EntityName = $PartesNombreClase[1];
        
        $this->EntityLabel = 'Usuario';
        $this->BaseRouteEntityName = 'Usuario';
        $this->BuscarPor = 'NombreVisible, Username';
        $this->FormTypeName = 'Usuario';
    }

    /**
     * Guarda una copia de la contraseña original antes de persistir la entidad.
     */
    public function guardarActionPreBind($entity)
    {
        $this->PassOriginal = $entity->getPasswordEnc();
        return parent::guardarActionPreBind($entity);
    }

    /**
     * Interviene antes de persistir la entidad de modo de permitir que al editar
     * si se deja la contraseña en blanco se conserva la contraseña actual.
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        // Intervenir la entidad antes de persistir
        if ($entity->getPasswordEnc()) {
            // Guardo el password con hash
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $encoded_password = $encoder->encodePassword($entity->getPasswordEnc(), $entity->getSalt());
            $entity->setPassword($encoded_password);
        } else {
            // Si la contraseña está en blanco, dejo la original
            $entity->setPasswordEnc($this->PassOriginal);
        }
        
        return parent::guardarActionPrePersist($entity, $editForm);
    }
}
