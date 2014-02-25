<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

trait ConExportarLista
{
     /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("exportarlista/")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
     */
    public function exportarListaAction(Request $request)
    {
        ini_set('memory_limit', '512M');
        
        $dql = $this->getSelectDql();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);

        $entities = $query->getResult();
        
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->getProperties()->setCreator("Yacaré");
        $phpExcelObject->setActiveSheetIndex(0);
        
        $this->getExportarListaExcel($entities, $phpExcelObject);
        
        $formatoExportar = $request->query->get('fmt');
        switch($formatoExportar) {
            case 'excel5':
                $WriterFormat = 'Excel5';
                $MimeType = 'application/vnd.ms-excel';
                $FileExtension = 'xls';
                break;
            case 'oocalc':
                $WriterFormat = 'OOCalc';
                $MimeType = 'application/vnd.oasis.opendocument.spreadsheet';
                $FileExtension = 'ods';
                break;
            case 'html':
                $WriterFormat = 'HTML';
                $MimeType = 'text/html';
                $FileExtension = 'html';
                break;
            case 'pdf':
                $WriterFormat = 'PDF';
                $MimeType = 'application/pdf';
                $FileExtension = 'pdf';
                break;
            case 'csv':
                $WriterFormat = 'CSV';
                $MimeType = 'text/csv';
                $FileExtension = 'csv';
                break;
            default:
            case 'excel':
            case 'excel2007':
                $WriterFormat = 'Excel2007';
                $MimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                $FileExtension = 'xlsx';
                break;
        }
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, $WriterFormat);
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', $MimeType . '; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=archivo_sin_nombre.'. $FileExtension);
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }
    
    protected function getExportarListaExcel($entities, $phpExcelObject) {
        $i = 0;
        foreach($entities as $entity) {
            $i++;
            $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, (string)$entity);
        }
        
        return $i;
    }
}