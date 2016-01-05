<?php
namespace Yacare\MunirgBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapir\BaseBundle\Helper\StringHelper;
use Yacare\MunirgBundle\Helper\Importador\ImportadorCalles;
use Yacare\MunirgBundle\Helper\Importador\ImportadorPartidas;
use Yacare\MunirgBundle\Helper\Importador\ImportadorPersonas;
use Yacare\MunirgBundle\Helper\Importador\ImportadorActividades;

/**
 * Controlador para importar datos de otras DB, a la DB de Yacaré.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 * 
 * @Route("importar/")
 */
class ImportarController extends \Tapir\BaseBundle\Controller\BaseController
{
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAOracle;

    /**
     * @Route("partidas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPartidasAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorPartidas($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'partidas', 
                    'url' => 'importarpartidas', 
                    'resultado' => $resultado, 
                    'cantidad' => $cantidad));
        } else {
            return $this->ArrastrarVariables($request, array('importando' => 'partidas', 'url' => 'importarpartidas'));
        }
    }

    /**
     * @Route("calles/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarCallesAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorCalles($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'calles', 
                    'cantidad' => $cantidad, 
                    'url' => 'importarcalles', 
                    'resultado' => $resultado));
        } else {
            return $this->ArrastrarVariables($request, array('importando' => 'calles', 'url' => 'importarcalles'));
        }
    }

    /**
     * @Route("actividades/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarActividadesAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorActividades($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'actividades', 
                    'url' => 'importaractividades', 
                    'resultado' => $resultado, 
                    'cantidad' => $cantidad));
        } else {
            return $this->ArrastrarVariables($request, 
                array('importando' => 'actividades', 'url' => 'importaractividades'));
        }
    }

    /**
     * @Route("personas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPersonasAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if ($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorPersonas($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
            
            return $this->ArrastrarVariables($request, 
                array(
                    'importando' => 'personas', 
                    'url' => 'importarpersonas', 
                    'resultado' => $resultado, 
                    'cantidad' => $cantidad));
        } else {
            return $this->ArrastrarVariables($request, array('importando' => 'personas', 'url' => 'importarpersonas'));
        }
    }
}
