<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador base abstracto para derivar todos los controladores de Yacaré.
 * 
 * Controlador abstracto con funciones básicas que se heredan en todos los controladores de la aplicación.
 * 
 * @abstract
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class YacareBaseController extends Controller
{
    protected $BundleName;
    protected $EntityName;
    protected $BaseRouteEntityName;
    protected $ConservarVariables;
    
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
        
        if(!isset($this->ConservarVariables)) {
            $this->ConservarVariables = array('filtro_buscar', 'page');
        }
    }

    /**
     * Arrastra variables entre acciones.
     * 
     * Obtiene un array con las variables necesarias para pasar de una acción a
     * otra dentro del controlador actual.
     * Por ejemplo, en la secuencia listar -> editar -> guardar -> listar, la
     * variable "page" que determina el número de página actual en el listado
     * debe ser conservada (arrastrada) entre acciones.
     * 
     * @param string $valorInicial
     * @param bool $incluirDelSistema
     * @return string El array con todas las variables necesarias para pasar a
     * una acción.
     */
    protected function ArrastrarVariables($valorInicial = null, $incluirDelSistema = true) {
        if(!$valorInicial)
            $valorInicial = array();
        
        $request = $this->getRequest();

        if($incluirDelSistema) {
            $valorInicial['bundlename']  = strtolower('yacare_' . $this->BundleName);
            $valorInicial['entityname'] = strtolower($this->EntityName);
            $valorInicial['entitylabel'] = $this->getEntityLabel();
            $valorInicial['entitylabelplural'] = $this->getEntityLabelPlural();
            $valorInicial['baseroute'] = $this->getBaseRoute();
            if(isset($this->Paginar)) {
                $valorInicial['paginar'] = $this->Paginar;
            }
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
        
        if(!isset($valorInicial['arrastre'])) {
            $valorInicial['arrastre'][''] = '';
        }
        
        return $valorInicial;
    }
    
    /**
     * Devuelve el nombre de la ruta para una acción o la base para conformar
     * las rutas de este controlador.
     * 
     * Por ejemplo, para la acción "guardar", devuelve
     * "yacare_bundle_entidad_guardar" (donde "bundle" y "entidad" tienen sus
     * respectivos valores para el controlador actual).
     * 
     * @param string $action La acción para la cual obtener la ruta.
     * @return string El nombre de la ruta para la acción solicitada o el nombre de la ruta base para este controlador.
     */
    public function getBaseRoute($action = null) {
        if($action)
            return strtolower('yacare_' . $this->BundleName . '_' . $this->BaseRouteEntityName . '_' . $action);
        else
            return strtolower('yacare_' . $this->BundleName . '_' . $this->BaseRouteEntityName);
    }
    
    
    /**
     * Obtiene el nombre visible de la clase de entidad (etiqueta).
     * 
     * El nombre visible o etiqueta es el nombre que se muestra al usuario en
     * pantalla para una clase de entidad, y que puede ser diferente del nombre
     * de la clase en el código fuente.
     * Por ejemplo, para la entidad "Tramite", el nombre visible es "Trámite"
     * (con tilde). Además, puede haber controladores que usan una entidad con
     * un nombre visible diferente, por ejemplo la entidad "Persona" se puede
     * usar con el nombre visible "Usuario".
     * 
     * @see getEntityLabelPlural()
     * @return string El nombre visible de la clase de entidad.
     */
    public function getEntityLabel() {
        if(isset($this->EntityLabel)) {
            return $this->EntityLabel;
        } else {
            return \Yacare\BaseBundle\Helper\StringHelper::ProperCase($this->EntityName);
        }
    }
    
    /**
     * Obtiene el nombre visible en plural.
     * 
     * En caso de no estar definido, pluraliza mediante un algoritmo el valor
     * obtenido de getEntityLabel().
     * 
     * @see getEntityLabel()
     * @return string El nombre visible de la clase de entidad en plural.
     */
    public function getEntityLabelPlural() {
        if(isset($this->EntityLabelPlural)) {
            return $this->EntityLabelPlural;
        } else {
            $res = $this->getEntityLabel();
            if(strpos('aeiouy', substr($res, -1)) === FALSE) {
                return $this->getEntityLabel() . 'es';
            } else {
                return $this->getEntityLabel() . 's';
            }
        }
    }
}
