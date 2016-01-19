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

    public function guardarActionPrePersist($entity, $editForm)
    {
        $em = $this->getEm();
        
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
        } elseif (strlen($codigo) == 4) {
            // Las clases (de 4 dígitos) dependen de un grupo (3 dígitos)
            $codigoPadre = substr($codigo, 0, 3);
        } elseif (strlen($codigo) == 3) {
            // Los grupos (de 3 dígitos) dependen de una división (2 dígitos)
            $codigoPadre = substr($codigo, 0, 2);
        } elseif (strlen($codigo) == 2) {
            // Las divisiones (de 2 dígitos) dependen de una categoría (1 letra)
            // Esta estructura es fija del ClaNAE 2010
            $codigo = (int) ($codigo);
            if ($codigo <= 4) {
                $codigoPadre = 'A';
            } elseif ($codigo <= 9) {
                $codigoPadre = 'B';
            } elseif ($codigo <= 34) {
                $codigoPadre = 'C';
            } elseif ($codigo <= 35) {
                $codigoPadre = 'D';
            } elseif ($codigo <= 40) {
                $codigoPadre = 'E';
            } elseif ($codigo <= 44) {
                $codigoPadre = 'F';
            } elseif ($codigo <= 48) {
                $codigoPadre = 'G';
            } elseif ($codigo <= 54) {
                $codigoPadre = 'H';
            } elseif ($codigo <= 57) {
                $codigoPadre = 'I';
            } elseif ($codigo <= 63) {
                $codigoPadre = 'J';
            } elseif ($codigo <= 67) {
                $codigoPadre = 'K';
            } elseif ($codigo <= 68) {
                $codigoPadre = 'L';
            } elseif ($codigo <= 76) {
                $codigoPadre = 'M';
            } elseif ($codigo <= 83) {
                $codigoPadre = 'N';
            } elseif ($codigo <= 84) {
                $codigoPadre = 'O';
            } elseif ($codigo <= 85) {
                $codigoPadre = 'P';
            } elseif ($codigo <= 89) {
                $codigoPadre = 'Q';
            } elseif ($codigo <= 93) {
                $codigoPadre = 'R';
            } elseif ($codigo <= 96) {
                $codigoPadre = 'S';
            } elseif ($codigo <= 98) {
                $codigoPadre = 'T';
            } elseif ($codigo <= 99) {
                $codigoPadre = 'U';
            } else {
                $codigoPadre = '';
            }
        } else {
            $codigoPadre = '';
        }
        
        if ($codigoPadre) {
            $em = $this->getDoctrine()->getManager();
            $parentNode = $em->getRepository('YacareComercioBundle:Actividad')->findOneBy(
                array('Clamae2014' => $codigoPadre));
            $entity->setParentNode($parentNode);
        }
        
        $hijos = $em->getRepository('YacareComercioBundle:Actividad')->findBy(array('ParentNode' => $entity->getId()));
        return parent::guardarActionPrePersist($entity, $editForm);
    }

    /**
     * @Route("buscar/")
     * @Template()
     */
    public function buscarAction(Request $request)
    {
        $this->Where = 'r.Final=1';
        $this->OrderBy = 'MaterializedPath DESC';
        
        return $this->buscarAction2($request);
    }
}

