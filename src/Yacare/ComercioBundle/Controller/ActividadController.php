<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controlador de actividades.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 * 
 * @Route("actividad/")
 */
class ActividadController extends \Tapir\AbmBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConExportarLista;
    use \Tapir\AbmBundle\Controller\ConEliminar;
    use \Tapir\AbmBundle\Controller\ConVer;
    use \Tapir\AbmBundle\Controller\ConBuscar {
        \Tapir\AbmBundle\Controller\ConBuscar::buscarAction as buscarAction2;
    }

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->BuscarPor = 'Nombre,Clamae2014,Incluye,DgrTdf,Clanae2010';
        $this->OrderBy = 'MaterializedPath';
        $this->Paginar = false;
        $this->ConservarVariables[] = 'filtro_prefijo';
        $this->ConservarVariables[] = 'filtro_buscar';
    }
    
    
    /**
     * @Route("listar/")
     * @Template()
     */
    public function listarAction(Request $request)
    {
        $filtro_etiqueta = $this->ObtenerVariable($request, 'filtro_etiqueta');
    
        if ($filtro_etiqueta) {
           $this->Joins[] = " LEFT JOIN r.Etiquetas e";
           $this->Where .= " AND e.id=$filtro_etiqueta";
        }

        $RestuladoListar = parent::listarAction($request);
        $res = $RestuladoListar['res'];

        $Etiquetas = $this->ObtenerEtiquetas();
        $EtiquetasArray = [];
        foreach($Etiquetas as $Etiqueta) {
            $EtiquetasArray[$Etiqueta->getId()] = $Etiqueta->getNombre();
        }
        $res->Filtros['etiqueta'] = new \Tapir\AbmBundle\Helper\Filtro('etiqueta', $filtro_etiqueta, $EtiquetasArray);

        return $RestuladoListar;
    }
    
    
    /**
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        $em = $this->getEm();

        $this->Where = 'r.Final=1';
        
        $filtro_parent = $this->ObtenerVariable($request, 'filtro_parent');
        $filtro_nivel = $this->ObtenerVariable($request, 'filtro_nivel');
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
        
        $ResultadoBuscar = $this->buscarAction2($request);
        $res = $ResultadoBuscar['res'];
        
        //echo $this->Where;
        //echo $_SERVER['REQUEST_URI'];
        if($filtro_buscar) {
            // Nada
        } else {
            $qb = $em->createQueryBuilder();
            $qb->select('a')
                ->from('Yacare\ComercioBundle\Entity\Actividad', 'a')
                ->orderBy('a.Nombre')
            ;
            
            if($filtro_parent) {
                $qb->where('a.ParentNode IN (SELECT b.id FROM Yacare\ComercioBundle\Entity\Actividad b WHERE b.ParentNode = ' . $filtro_parent . ')');
            } else {
                $qb->where('a.ParentNode IN (SELECT b.id FROM Yacare\ComercioBundle\Entity\Actividad b WHERE b.ParentNode IS NULL)');
            }
            
            $res->Entidades = $qb->getQuery()->getResult();
        }
        
        //$this->OrderBy = 'MaterializedPath DESC';
        
        $res->Filtros['parent'] = $filtro_parent;
        $res->Filtros['nivel'] = $filtro_nivel;
        
        return $ResultadoBuscar;
    }
    

    protected function getExportarListaExcel($entities, $phpExcelObject)
    {
        $phpExcelObject->getActiveSheet()
            ->setCellValue('A1', 'ClaMAE 2014')
            ->setCellValue('B1', 'Detalle')
            ->setCellValue('C1', 'CPU')
            ->setCellValue('D1', 'Riesgo')
            ->setCellValue('E1', 'Categoría antigua')
            ->setCellValue('F1', 'Incluye')
            ->setCellValue('G1', 'No incluye')
            ->setCellValue('H1', 'ClaNAE 97')
            ->setCellValue('I1', 'ClaE AFIP RG3537/13')
            ->setCellValue('J1', 'DGR TDF Ley 854/11')
            ->setCellValue('K1', 'Etiquetas')
            ;
            
        $i = 1;
        foreach ($entities as $entity) {
            $i ++;
            
            $NombresEtiquetas = ''; 
            foreach($entity->getEtiquetas() as $Etiqueta) {
                $NombresEtiquetas .= $Etiqueta->getNombre() . ',';
            }
            
            $phpExcelObject->getActiveSheet()
                ->setCellValue('A' . $i, $entity->getClamae2014())
                ->setCellValue('B' . $i, $entity->getNombre())
                ->setCellValue('C' . $i, $entity->getCodigoCpu())
                ->setCellValue('D' . $i, $entity->getNivelRiesgoNombre())
                ->setCellValue('E' . $i, $entity->getCategoriaAntigua() ? $entity->getCategoriaAntigua() : '')
                ->setCellValue('F' . $i, $entity->getIncluye())
                ->setCellValue('G' . $i, $entity->getNoIncluye())
                ->setCellValue('H' . $i, $entity->getClanae1997())
                ->setCellValue('I' . $i, $entity->getClaeAfip())
                ->setCellValue('J' . $i, $entity->getDgrTdf())
                ->setCellValue('K' . $i, $NombresEtiquetas)
                ;
            
            $phpExcelObject->getActiveSheet()->getRowDimension($i)->setRowHeight(12);
            
            $phpExcelObject->getActiveSheet()
                ->getStyle('B' . $i)
                ->getAlignment()
                ->setIndent($entity->getNodeLevel());
            $phpExcelObject->getActiveSheet()
                ->getStyle('B' . $i)
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            if (! $entity->getFinal()) {
                $phpExcelObject->getActiveSheet()
                    ->getStyle('B' . $i)
                    ->getFont()
                    ->setBold(true);
            }
        }
        
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setWidth(70);
        $phpExcelObject->getActiveSheet()->getColumnDimension('J')->setWidth(70);
        
        $phpExcelObject->getActiveSheet()
            ->getStyle('A1:N1')
            ->getFill()
            ->getStartColor()
            ->setARGB(\PHPExcel_Style_Color::COLOR_YELLOW);
        
        $phpExcelObject->getActiveSheet()
            ->getStyle('A2:N' . $i)
            ->getFill()
            ->getStartColor()
            ->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        
        $phpExcelObject->getActiveSheet()
            ->getStyle('A2:A' . $i)
            ->getNumberFormat()
            ->setFormatCode('@');
        $phpExcelObject->getActiveSheet()
            ->getStyle('A2:A' . $i)
            ->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        /* $phpExcelObject->getActiveSheet()
            ->getStyle('J2:J' . $i)
            ->getNumberFormat()
            ->setFormatCode('@');
        $phpExcelObject->getActiveSheet()
            ->getStyle('J2:J' . $i)
            ->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); */
        
        return $i;
    }
    
    protected function ObtenerEtiquetas() {
        return $this->getEm()->getRepository('Yacare\ComercioBundle\Entity\ActividadEtiqueta')->findBy( [ 'Suprimido' => 0] );
    }
}

