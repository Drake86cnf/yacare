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
        $PartesNombreClase = \Yacare\BaseBundle\Helper\StringHelper::ObtenerBundleYEntidad(get_class($this));

        if(!isset($this->BundleName)) {
            $this->BundleName = $PartesNombreClase[0];
        }

        if(!isset($this->EntityName)) {
            $this->EntityName = $PartesNombreClase[1];
        }
        
        if(!isset($this->BaseRouteEntityName)) {
            $this->BaseRouteEntityName = $this->EntityName;
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
            return strtolower('yacare_' . $this->BundleName . '_' . $this->BaseRouteEntityName . '_' . $action);
        else
            return strtolower('yacare_' . $this->BundleName . '_' . $this->BaseRouteEntityName);
    }
}
