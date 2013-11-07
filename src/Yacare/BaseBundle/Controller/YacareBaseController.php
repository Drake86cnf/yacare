<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class YacareBaseController extends Controller
{
    function __construct() {
        // get_class() devuelve Yacare\TalBundle\Controller\TalControlador
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class($this));

        if(!isset($this->BundleName)) {
            $this->BundleName = $PartesNombreClase[1];
            if(strlen($this->BundleName) > 6 && substr($this->BundleName, -6) == 'Bundle') {
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->BundleName = substr($this->BundleName, 0, strlen($this->BundleName) - 6);
            }
        }

        if(!isset($this->EntityName)) {
            $this->EntityName = $PartesNombreClase[3];
            if(strlen($this->EntityName) > 10 && substr($this->EntityName, -10) == 'Controller') {
                // Quitar la palabra 'Controller' del nombre del controlador
                $this->EntityName = substr($this->EntityName, 0, strlen($this->EntityName) - 10);
            }
        }
        
        if(!isset($this->ConservarVariables))
            $this->ConservarVariables = array('filtro_buscar', 'page');
    }



    protected function ArrastrarVariables($valorInicial = null, $incluirDelSistema = true) {
        if(!$valorInicial)
            $valorInicial = array();
        
        $request = $this->getRequest();

        if($incluirDelSistema) {
            $valorInicial['bundlename']  = strtolower('yacare_' . $this->BundleName);
            $valorInicial['entityname'] = strtolower($this->EntityName);
            $valorInicial['baseroute'] = $this->getBaseRoute();
            if(isset($this->Paginar))
                $valorInicial['paginar'] = $this->Paginar;
        }
        
        if($this->ConservarVariables) {
            foreach($this->ConservarVariables as $vr) {
                if(!isset($valorInicial[$vr])) {
                    $val = $request->query->get($vr);
                    if($val) {
                        $valorInicial[$vr] = $val;
                        $valorInicial['arrastre'][$vr] = $request->query->get($vr);
                    }
                }
            }
        }

        $val = $request->query->get('page');
        if($val) {
            $valorInicial['arrastre']['page'] = $val;
        }
        
        if(!isset($valorInicial['arrastre']))
            $valorInicial['arrastre'][''] = '';
        
        return $valorInicial;
    }
    
    // Devuelve el nombre de la ruta para una acción determinada o la base para conformar las rutas
    protected function getBaseRoute($action = null) {
        if($action)
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_' . $action);
        else
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName);
    }
}
