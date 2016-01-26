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
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        $em = $this->getEm();

        $this->Where = 'r.Final=1';
        
        $filtro_prefijo = $this->ObtenerVariable($request, 'filtro_prefijo');
        $filtro_buscar = $this->ObtenerVariable($request, 'filtro_buscar');
        
        if ($filtro_prefijo) {
            $this->Where .= " AND r.MaterializedPath LIKE '" . addcslashes($filtro_prefijo, "%_'") . "/%'";
            $Categoria = $em->getRepository('Yacare\ComercioBundle\Entity\Actividad')->findBy([ 'MaterializedPath' => $filtro_prefijo ]);
            if(is_array($Categoria) && count($Categoria) == 1) {
                $Categoria = $Categoria[0];
            } else {
                print_r($Categoria);
            }
        } else {
            $Categoria = null;
        }
        
        $ResultadoBuscar = $this->buscarAction2($request);
        $res = $ResultadoBuscar['res'];
        
        //echo $this->Where;
        //echo $_SERVER['REQUEST_URI'];
        if($filtro_buscar) {
            // Nada
        } elseif($Categoria) {
            $res->Entidades = $em->getRepository('Yacare\ComercioBundle\Entity\Actividad')->findBy([ 'ParentNode' => $Categoria ]);
            if(count($res->Entidades) == 1) {
                // Hay una sola subcategoría... desciendo un nivel más
                $res->Entidades = $em->getRepository('Yacare\ComercioBundle\Entity\Actividad')->findBy([ 'ParentNode' => $res->Entidades[0] ]);
            }
        }
        
        $res->Categoria = $Categoria;
        
        $this->OrderBy = 'MaterializedPath DESC';
        
        $res->Filtros['prefijo'] = $filtro_prefijo;
        
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
}

