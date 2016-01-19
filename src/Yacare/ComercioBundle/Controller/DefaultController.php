<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapir\ChartsBundle\Charts\Chartjs;

/**
 * Controlador de inicio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DefaultController extends \Tapir\BaseBundle\Controller\DefaultController
{
    use \Tapir\AyudaBundle\Controller\ConAyuda;
    
    /**
     * @Route("resumen/")
     * @Template
     */
    public function resumenAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Yacare\ComercioBundle\Helper\Resultados\ResultadoInicioAction($this),
            $request);
        
        $this->ObtenerContadoresYRecientes($res);
        
        $em = $this->getEm();
        
        // Comercios por actividad principal
        $res->Rankings['ComercioActividad'] = $em->createQuery('SELECT a.Nombre, a.Clamae2014, COUNT(c.id) AS cant
        	FROM Yacare\ComercioBundle\Entity\Comercio c
        		LEFT JOIN c.Actividad1 a
        	WHERE c.Actividad1 IS NOT NULL
            GROUP BY c.Actividad1
            ORDER BY cant DESC')->setMaxResults(15)->getResult();
        
        $Graf_ComercioActividad = new Chartjs();
        $Graf_ComercioActividad->RenderTo = 'chart_comercioactividad';
        $Graf_ComercioActividad->ChartType = 'Doughnut';
        $Graf_ComercioActividad
            ->AddOption('scaleShowLabelBackdrop', true)
            ->AddOption('animateRotate', true);
        
        foreach($res->Rankings['ComercioActividad'] as $Porcion) {
            $Graf_ComercioActividad->AddPieValue($Porcion['Nombre'], $Porcion['cant']);
        }
        
        $res->Charts['ComercioActividad'] = $Graf_ComercioActividad;
        
        /// Comercios por estado
        $res->Rankings['ComercioEstado'] = $em->createQuery('SELECT c.Estado, COUNT(c.id) AS cant
        	FROM Yacare\ComercioBundle\Entity\Comercio c
            GROUP BY c.Estado
            ORDER BY cant DESC')->setMaxResults(15)->getResult();
        
        $Graf_ComercioEstado = new Chartjs();
        $Graf_ComercioEstado->RenderTo = 'chart_comercioestado';
        $Graf_ComercioEstado->ChartType = 'Doughnut';
        $Graf_ComercioEstado
            ->AddOption('scaleShowLabelBackdrop', true)
            ->AddOption('animateRotate', true);
        
        foreach($res->Rankings['ComercioEstado'] as $Porcion) {
            $Graf_ComercioEstado->AddPieValue(\Yacare\ComercioBundle\Entity\Comercio::NombreEstado($Porcion['Estado']), $Porcion['cant']);
        }
        
        $res->Charts['ComercioEstado'] = $Graf_ComercioEstado;
        $res->NombresEstados = \Yacare\ComercioBundle\Entity\Comercio::NombresEstados();
        
        return array('res' => $res);
    }
    
    /**
     * @Route("inicio/")
     * @Template
     */
    public function inicioAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Yacare\ComercioBundle\Helper\Resultados\ResultadoInicioAction($this),
            $request);
        
        $this->ObtenerContadoresYRecientes($res);
        
        return array('res' => $res);
    }
    
    
    /**
     * @Route("miniinicio/")
     * @Template
     */
    public function miniinicioAction(Request $request)
    {
        $res = $this->ConstruirResultado(new \Yacare\ComercioBundle\Helper\Resultados\ResultadoInicioAction($this),
            $request);
        
        $this->ObtenerContadoresYRecientes($res);
    
        return array('res' => $res);
    }
    
    public function ObtenerContadoresYRecientes($resultado) {
        $em = $this->getEm();
        
        $resultado->Contadores['Local'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\Local r WHERE r.Suprimido=0')->getSingleScalarResult();
        $resultado->Contadores['Comercio'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\Comercio r WHERE r.Suprimido=0')->getSingleScalarResult();
        $resultado->Contadores['ActaComercio'] = $em->createQuery('SELECT COUNT(r.id) FROM Yacare\ComercioBundle\Entity\ActaComercio r')->getSingleScalarResult();
        
        $resultado->Recientes['Comercio'] = $em->createQuery('SELECT r FROM Yacare\ComercioBundle\Entity\Comercio r
            WHERE r.Suprimido=0 ORDER BY r.RequiereAtencion DESC, r.updatedAt DESC')->setMaxResults(10)->getResult();
        $resultado->Recientes['Local'] = $em->createQuery('SELECT r FROM Yacare\ComercioBundle\Entity\Local r
            WHERE r.Suprimido=0 ORDER BY r.updatedAt DESC')->setMaxResults(10)->getResult();
        
        return $resultado;
    }
    
    
}
