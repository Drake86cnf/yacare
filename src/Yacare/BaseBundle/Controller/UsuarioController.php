<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("usuario/")
 */
class UsuarioController extends YacareAbmController
{
    private $PassOriginal = '';
    
    function __construct() {
        $this->BuscarPor = 'NombreVisible';
        $this->FormTypeName = 'Usuario';
        parent::__construct();
    }
    
    
    public function guardarActionPreBind($entity) {
        $this->PassOriginal = $entity->getPasswordEnc();
        return parent::guardarActionPreBind($entity);
    }
    

    public function guardarActionPrePersist($entity)
    {
        // Intervenir la entidad antes de persistir
        if($entity->getPasswordEnc()) {
            // Guardo el password con hash
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $encoded_password = $encoder->encodePassword($entity->getPasswordEnc(), $entity->getSalt());
            $entity->setPassword($encoded_password);
        } else {
            // Si la contraseña está en blanco, dejo la original
            $entity->setPasswordEnc($this->PassOriginal);
        }
        return parent::guardarActionPrePersist($entity);
    }
}
