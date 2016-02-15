<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de empresas constructoras.
 *
 * @author Alejandro Diaz <alediaz.rc@gmail.com>
 *        
 * @Route("empresaconstructora/")
 */
class EmpresaConstructoraController extends \Tapir\AbmBundle\Controller\AbmController
{
    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->Joins[] = 'JOIN r.Persona p';
        $this->Joins[] = 'JOIN r.RepresentanteTecnico m';
        $this->OrderBy = 'p.NombreVisible';
        $this->BuscarPor = 'p.Nombre , p.DocumentoNumero, m.Nombre';
    }

    /**
     * Obtiene el listado de empresas constructoras con pago al día, sin paginar.
     *
     * @Route("listarhabilitadas/")
     * @Template()
     */
    public function listarhabilitadasAction(Request $request)
    {
        $this->Where = 'r.FechaVencimiento>CURRENT_DATE()';
        $this->Paginar = false;
        
        $res = parent::listarAction($request);
        
        $res['fechalistado'] = new \DateTime();
        
        return $res;
    }
    
    /**
     * Intercepto el prePersist para permitir poner ID manualmente.
     * TODO: quitar una vez que carguen históricos.
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        $metadata = $this->getEm()->getClassMetaData(get_class($entity));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
    }
}
