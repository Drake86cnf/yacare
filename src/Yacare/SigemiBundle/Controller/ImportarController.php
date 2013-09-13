<?php

namespace Yacare\SigemiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yacare\BaseBundle\Helper\StringHelper;

class ImportarController extends Controller
{
    /**
     * @Route("/importar/calles/")
     * @Template()
     */
    public function importarCallesAction()
    {
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        
        $em = $this->getDoctrine()->getManager();

        $tns = '(DESCRIPTION = 
			    (ADDRESS_LIST = 
			        (ADDRESS = 
			          (COMMUNITY = tcp.world)
			          (PROTOCOL = TCP)
			          (Host = 192.168.100.20)
			          (Port = 1521)
			        )
			    )
			    (CONNECT_DATA = (SID = dbmunirg)
			    )
			  )';
  
        $Dbmunirg = new \PDO('oci:charset=UTF8;dbname=' . $tns, 'rgr', '123');
        
        $importar_importados = 0;
        $importar_procesados = 0;
        $log = array();
        foreach($Dbmunirg->query('SELECT CODIGO_CALLE AS id, CALLE AS Nombre FROM TG06405 WHERE TG06403_TG06403_ID=410') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['NOMBRE']);
            
            $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(array(
                'ImportSrc' => 'dbmunirg.TG06405',
                'ImportId' => $Row['ID']
             ));
            
            if(!$entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(array(
                    'Nombre' => $nombreBueno
                ));
            }
            
            if(!$entity) {
                $entity = new \Yacare\CatastroBundle\Entity\Calle();
                $importar_importados++;
            }
            
            $entity->setNombre($nombreBueno);
            $entity->setImportSrc('dbmunirg.TG06405');
            $entity->setImportId($Row['ID']);
            $entity->setNombreOriginal($Row['NOMBRE']);

            $em->persist($entity);
            
            $importar_procesados++;
            $log[] = $nombreBueno;
        }
        
        $em->flush();
        
        return array(
            'importar_importados' => $importar_importados,
            'importar_procesados' => $importar_procesados,
            'log' => $log
            );
    }
}
