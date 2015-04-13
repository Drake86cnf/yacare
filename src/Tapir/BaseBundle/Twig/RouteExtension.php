<?php
namespace Tapir\BaseBundle\Twig;

/**
 * Extensión de Twig que implementa una función para saber si una ruta existe.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
class RouteExtension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tapir_rutaexiste', 
                array($this,'tapir_rutaexiste')));
    }

    function tapir_rutaexiste($name)
    {
        // I assume that you have a link to the container in your twig extension class
        $router = $this->container->get('router');
        return (null === $router->getRouteCollection()->get($name)) ? false : true;
    }

    public function getName()
    {
        return 'acme_extension';
    }
}
