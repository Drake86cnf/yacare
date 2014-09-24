<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("actividad/")
 */
class ActividadController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConExportarLista;
    use \Tapir\BaseBundle\Controller\ConEliminar;
    use \Tapir\BaseBundle\Controller\ConBuscar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        
        $this->BuscarPor = 'nombre,Clamae2014';
        $this->OrderBy = 'MaterializedPath';
        $this->Paginar = false;
    }

    protected function getExportarListaExcel($entities, $phpExcelObject)
    {
        $phpExcelObject->getActiveSheet()
            ->setCellValue('A1', 'ClaMAE 2014')
            ->setCellValue('B1', 'Detalle')
            ->setCellValue('C1', 'CPU')
            ->setCellValue('D1', 'Categoría antigua')
            ->setCellValue('E1', 'Exenta')
            ->setCellValue('F1', 'DBeH')
            ->setCellValue('G1', 'DEyMA')
            ->setCellValue('H1', 'Ley 105')
            ->setCellValue('I1', 'Incluye')
            ->setCellValue('J1', 'No incluye')
            ->setCellValue('K1', 'ClaNAE 97')
            ->setCellValue('L1', 'ClaNAE 2010')
            ->setCellValue('M1', 'ClaE AFIP RG3537/13')
            ->setCellValue('N1', 'DGR TDF Ley 854/11');
        
        $i = 1;
        foreach ($entities as $entity) {
            $i ++;
            
            $phpExcelObject->getActiveSheet()
                ->setCellValue('A' . $i, $entity->getClamae2014())
                ->setCellValue('B' . $i, $entity->getNombre())
                ->setCellValue('C' . $i, $entity->getCodigoCpu())
                ->setCellValue('D' . $i, $entity->getCategoriaAntigua() ? $entity->getCategoriaAntigua() : '')
                ->setCellValue('E' . $i, $entity->getExento() ? 'Sí' : '')
                ->setCellValue('F' . $i, $entity->getRequiereDeyma() ? 'Sí' : '')
                ->setCellValue('G' . $i, $entity->getRequiereDbeh() ? 'Sí' : '')
                ->setCellValue('H' . $i, $entity->getLey105() ? 'Sí' : '')
                ->setCellValue('I' . $i, $entity->getIncluye())
                ->setCellValue('J' . $i, $entity->getNoIncluye())
                ->setCellValue('K' . $i, $entity->getClanae1997())
                ->setCellValue('L' . $i, $entity->getClanae2010())
                ->setCellValue('M' . $i, $entity->getClaeAfip())
                ->setCellValue('N' . $i, $entity->getDgrTdf());
            
            $phpExcelObject->getActiveSheet()
                ->getRowDimension($i)
                ->setRowHeight(12);
            
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
        
        $phpExcelObject->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(12);
        $phpExcelObject->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(70);
        
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
        
        $phpExcelObject->getActiveSheet()
            ->getStyle('K2:K' . $i)
            ->getNumberFormat()
            ->setFormatCode('@');
        $phpExcelObject->getActiveSheet()
            ->getStyle('K2:K' . $i)
            ->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        return $i;
    }

    public function guardarActionPrePersist($entity, $editForm)
    {
        if (! $entity->getId()) {
            /*
             * No tiene id. Como es parte de un árbol, necesito asignar un id manualmente.
             */
            $nuevoId = $this->getDoctrine()
                ->getManager()
                ->createQuery('SELECT MAX(r.id) FROM YacareComercioBundle:Actividad r')
                ->getSingleScalarResult();
            $entity->setId(++ $nuevoId);
            $metadata = $em->getClassMetaData(get_class($entity));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        
        /*
         * Quito guiones, espacios y puntos del código
         */
        $codigo = trim(str_replace('-', '', str_replace(' ', '', str_replace('.', '', $entity->getClamae2014()))));
        $entity->setClamae2014($codigo);
        
        /*
         * Calculo el ClaE AFIP y el ClaNAE 2010
         */
        $entity->setClaeAfip(substr($codigo, 0, 6));
        $entity->setClanae2010(substr($codigo, 0, 5));
        
        /*
         * Busco un ParentNode acorde al código ingresado
         */
        if (strlen($codigo) == 7) {
            // Los códigos finales (de 7 dígitos) dependen de una clase (4 dígitos)
            $codigoPadre = substr($codigo, 0, 4);
            $entity->setFinal(true);
        } else 
            if (strlen($codigo) == 4) {
                // Las clases (de 4 dígitos) dependen de un grupo (3 dígitos)
                $codigoPadre = substr($codigo, 0, 3);
            } else 
                if (strlen($codigo) == 3) {
                    // Los grupos (de 3 dígitos) dependen de una división (2 dígitos)
                    $codigoPadre = substr($codigo, 0, 2);
                } else 
                    if (strlen($codigo) == 2) {
                        // Las divisiones (de 2 dígitos) dependen de una categoría (1 letra)
                        // Esta estructura es fija del ClaNAE 2010
                        $codigo = (int) ($codigo);
                        if ($codigo <= 4) {
                            $codigoPadre = 'A';
                        } else 
                            if ($codigo <= 9) {
                                $codigoPadre = 'B';
                            } else 
                                if ($codigo <= 34) {
                                    $codigoPadre = 'C';
                                } else 
                                    if ($codigo <= 35) {
                                        $codigoPadre = 'D';
                                    } else 
                                        if ($codigo <= 40) {
                                            $codigoPadre = 'E';
                                        } else 
                                            if ($codigo <= 44) {
                                                $codigoPadre = 'F';
                                            } else 
                                                if ($codigo <= 48) {
                                                    $codigoPadre = 'G';
                                                } else 
                                                    if ($codigo <= 54) {
                                                        $codigoPadre = 'H';
                                                    } else 
                                                        if ($codigo <= 57) {
                                                            $codigoPadre = 'I';
                                                        } else 
                                                            if ($codigo <= 63) {
                                                                $codigoPadre = 'J';
                                                            } else 
                                                                if ($codigo <= 67) {
                                                                    $codigoPadre = 'K';
                                                                } else 
                                                                    if ($codigo <= 68) {
                                                                        $codigoPadre = 'L';
                                                                    } else 
                                                                        if ($codigo <= 76) {
                                                                            $codigoPadre = 'M';
                                                                        } else 
                                                                            if ($codigo <= 83) {
                                                                                $codigoPadre = 'N';
                                                                            } else 
                                                                                if ($codigo <= 84) {
                                                                                    $codigoPadre = 'O';
                                                                                } else 
                                                                                    if ($codigo <= 85) {
                                                                                        $codigoPadre = 'P';
                                                                                    } else 
                                                                                        if ($codigo <= 89) {
                                                                                            $codigoPadre = 'Q';
                                                                                        } else 
                                                                                            if ($codigo <= 93) {
                                                                                                $codigoPadre = 'R';
                                                                                            } else 
                                                                                                if ($codigo <= 96) {
                                                                                                    $codigoPadre = 'S';
                                                                                                } else 
                                                                                                    if ($codigo <= 98) {
                                                                                                        $codigoPadre = 'T';
                                                                                                    } else 
                                                                                                        if ($codigo <= 99) {
                                                                                                            $codigoPadre = 'U';
                                                                                                        }
                    }
        
        if ($codigoPadre) {
            $em = $this->getDoctrine()->getManager();
            $parentNode = $em->getRepository('YacareComercioBundle:Actividad')->findOneBy(array(
                'Clamae2014' => $codigoPadre
            ));
            $entity->setParentNode($parentNode);
        }
        
        return null;
    }

    /**
     * @Route("buscarresultados/")
     * @Template()
     */
    public function buscarresultadosAction(Request $request)
    {
        $this->Where = 'r.Final=1';
        
        $this->Paginar = false;
        $this->Limit = 500;
        return $this->listarAction($request);
        
        //return parent::buscarresultadosAction($request);
    }

    /**
     * @Route("recalcular/")
     * @Template("YacareComercioBundle:Actividad:listar.html.twig")
     */
    public function recalcularAction(Request $request)
    {
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        /* $em->getConnection()->beginTransaction(); */
        $items = $em->getRepository('YacareComercioBundle:Actividad')->findAll();
        foreach ($items as $item) {
            $item->setParentNode($item->getParentNode());
            $em->persist($item);
            $em->flush();
        }
        
        /* $em->getConnection()->commit(); */
        
        return parent::listarAction($request);
    }
}
