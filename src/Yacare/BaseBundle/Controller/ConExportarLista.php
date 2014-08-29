<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

trait ConExportarLista
{

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("listar/exportar/")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
     */
    public function listarExportarAction(Request $request)
    {
        ini_set('memory_limit', '512M');
        
        $dql = $this->obtenerComandoSelect();
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);
        
        $entities = $query->getResult();
        
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->getProperties()
            ->setCreator('Yacaré')
            ->setTitle($this->BundleName . ': ' . $this->obtenerEtiquetaEntidadPlural())
            ->setKeywords($this->BundleName . '  ' . $this->obtenerEtiquetaEntidadPlural())
            ->setDescription('Archivo exportado desde sistema de gestión Yacaré');
        $phpExcelObject->setActiveSheetIndex(0);
        $phpExcelObject->getActiveSheet()->setTitle($this->obtenerEtiquetaEntidadPlural());
        
        $phpExcelObject->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(10);
        $phpExcelObject->getDefaultStyle()
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $phpExcelObject->getDefaultStyle()
            ->getFill()
            ->getStartColor()
            ->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        
        $this->getExportarListaExcel($entities, $phpExcelObject);
        unset($entities);
        
        $formatoExportar = $request->query->get('fmt');
        switch ($formatoExportar) {
            case 'excel5':
                $WriterFormat = 'Excel5';
                $MimeType = 'application/vnd.ms-excel';
                $ArchivoExtension = 'xls';
                break;
            case 'oocalc':
                $WriterFormat = 'OOCalc';
                $MimeType = 'application/vnd.oasis.opendocument.spreadsheet';
                $ArchivoExtension = 'ods';
                break;
            case 'html':
                $WriterFormat = 'HTML';
                $MimeType = 'text/html';
                $ArchivoExtension = 'html';
                break;
            case 'pdf':
                $WriterFormat = 'PDF';
                $MimeType = 'application/pdf';
                $ArchivoExtension = 'pdf';
                break;
            case 'csv':
                $WriterFormat = 'CSV';
                $MimeType = 'text/csv';
                $ArchivoExtension = 'csv';
                break;
            default:
            case 'excel':
            case 'excel2007':
                $WriterFormat = 'Excel2007';
                $MimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                $ArchivoExtension = 'xlsx';
                break;
        }
        
        $NombreArchivo = $this->BundleName . '_' . $this->obtenerEtiquetaEntidadPlural();
        
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, $WriterFormat);
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', $MimeType . '; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $NombreArchivo . '.' . $ArchivoExtension);
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        
        return $response;
    }

    protected function getExportarListaExcel($entities, $phpExcelObject)
    {
        $phpExcelObject->getActiveSheet()
            ->setCellValue('A1', 'Código')
            ->setCellValue('B1', 'Detalle');
        
        $phpExcelObject->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(12);
        $phpExcelObject->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(70);
        
        $phpExcelObject->getActiveSheet()
            ->getStyle('A1:B1')
            ->getFill()
            ->getStartColor()
            ->setARGB(\PHPExcel_Style_Color::COLOR_YELLOW);
        
        $i = 1;
        foreach ($entities as $entity) {
            $i ++;
            $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $entity->getId());
            $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, (string) $entity);
        }
        
        return $i;
    }
}