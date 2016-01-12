<?php
namespace Tapir\BaseBundle\Twig;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TapirExtension extends \Twig_Extension
{
    protected $container;
    
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('tapir_hasanyrole', array($this,'tapir_hasanyrole')),
        	new \Twig_SimpleFunction('tapir_bundleexists', array($this,'tapir_bundleexists'))
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tapir_cuiltesvalida', array($this,'tapir_cuiltesvalida')),
            new \Twig_SimpleFilter('tapir_ruta_existe', array($this,'tapir_ruta_existe')),
            new \Twig_SimpleFilter('tapir_clase', array($this,'tapir_clase'))
        );
    }
    
    public function tapir_bundleexists($bundle){
    	return array_key_exists(
    			$bundle,
    			$this->container->getParameter('kernel.bundles')
    			);
    }
    
    public function tapir_hasanyrole($roles) {
        $Security = $this->container->get('security.authorization_checker');
        if($Security->isGranted('ROLE_IDDQD')) {
            return true;
        } else {
            $RolesArray = explode(',', $roles);
            foreach($RolesArray as $Rol) {
                $Rol = trim($Rol); 
                if($Security->isGranted($Rol)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function tapir_clase($obj) {
        return (new \ReflectionClass($obj))->getShortName();
    }
    
    public function tapir_ruta_existe($nombreRuta) {
        $router = $this->container->get('router');
        return (null === $router->getRouteCollection()->get($nombreRuta)) ? false : true;
    }
    
    public function tapir_cuiltesvalida($Cuilt)
    {
        $CuiltSaneado = str_split(str_replace('-', '', trim($Cuilt)));

        if (count($CuiltSaneado) != 11) {
            return false;
        }

        $result = $CuiltSaneado[0] * 5;
        $result += $CuiltSaneado[1] * 4;
        $result += $CuiltSaneado[2] * 3;
        $result += $CuiltSaneado[3] * 2;
        $result += $CuiltSaneado[4] * 7;
        $result += $CuiltSaneado[5] * 6;
        $result += $CuiltSaneado[6] * 5;
        $result += $CuiltSaneado[7] * 4;
        $result += $CuiltSaneado[8] * 3;
        $result += $CuiltSaneado[9] * 2;

        $div = intval($result / 11);
        $resto = $result - ($div * 11);

        if ($resto == 0) {
            if ($resto == $CuiltSaneado[10]) {
                return true;
            } else {
                return false;
            }
        } elseif ($resto == 1) {
            if ($CuiltSaneado[10] == 9 and $CuiltSaneado[0] == 2 and $CuiltSaneado[1] == 3) {
                return true;
            } elseif ($CuiltSaneado[10] == 4 and $CuiltSaneado[0] == 2 and $CuiltSaneado[1] == 3) {
                return true;
            }
        } elseif ($CuiltSaneado[10] == (11 - $resto)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'tapir_extension';
    }
}
