<?php
namespace Yacare\TramitesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("estadorequisito/")
 */
class EstadoRequisitoController extends \Tapir\AbmBundle\Controller\AbmController
{
    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->ConservarVariables = array('parent_id');
        $this->Paginar = false;
    }

    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $parent_id = $this->ObtenerVariable($request, 'parent_id');
        
        if ($parent_id) {
            $em = $this->getEm();
            // $parent_id = $request->query->get('parent_id');
            $Tramite = $em->getReference('YacareTramitesBundle:Tramite', $parent_id);
            
            $this->Where .= " AND r.Tramite=$parent_id";
        }
        
        $res = parent::listarAction($request);
        
        if ($parent_id) {
            $res['parent'] = $Tramite;
        }
        
        return $res;
    }


    protected function guardarActionAfterSuccess(Request $request, $entity)
    {
        // Redirecciono al trámite original en el bundle al cual corresponde el trámite
        
        // get_class() devuelve Yacare\TalBundle\Entity\TalEntidad
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class($entity->getTramite()));
        
        $BundleName = $PartesNombreClase[1];
        if (strlen($BundleName) > 6 && substr($BundleName, - 6) == 'Bundle') {
            // Quitar la palabra 'Bundle' del nombre del bundle
            $BundleName = substr($BundleName, 0, strlen($BundleName) - 6);
        }
        
        $EntityName = $PartesNombreClase[3];
        if (strlen($EntityName) > 10 && substr($EntityName, - 10) == 'Controller') {
            // Quitar la palabra 'Controller' del nombre del controlador
            $EntityName = substr($EntityName, 0, strlen($EntityName) - 10);
        }
        
        return $this->redirectToRoute('yacare_' . strtolower($BundleName) . '_' . strtolower($EntityName) . '_ver', 
            $this->ArrastrarVariables($request, array('id' => $entity->getTramite()->getId()), false));
    }
}
