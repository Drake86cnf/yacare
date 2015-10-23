<?php
namespace Yacare\MunirgBundle\Helper;

use Yacare\MunirgBundle\Helper\Importador;
use Yacare\MunirgBundle\Helper\ResultadoLote;

/**
 * Importador de partidas de actividades de ClaMAE.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorActividades extends Importador {
    function __construct($container, $em) {
        parent::__construct($container, $em);
    }

    protected $ColNumbers = array(
        'Clamae2014' => 1,
        'Nombre' => 2,
        'Categoria' => 7,
        'Exenta' => 8
    );
    
    public function ObtenerRegistros($desde, $cantidad) {
        $res = array();
        
        $i = 0;
        $Archivo = $this->ObtenerArchivo();
        while (($Row = fgetcsv($Archivo)) !== false) {
            if($i >= $desde) {
                $res[] = $Row;
            }
            $i++;
            if($i >= $desde + $cantidad) {
                break;
            }
        }
        fclose($Archivo);

        return $res;
     }
    
    
    public function ObtenerCantidadTotal() {
        $res = 0;
        $Archivo = $this->ObtenerArchivo('rb');
        while(!feof($Archivo)){
            // Tengo que usar fgetcsv en lugar de contar EOL, porque el archivo puede (y suele) contener
            // nuevas líneas dentro de literales encomillados, que no deben ser contados como registros.
            fgetcsv($Archivo);
            $res++;
        }
        fclose($Archivo);
        return $res;
    }
    
    
    public function ImportarRegistro($Row) {
        $resultado = new ResultadoLote();
        
        $Clamae2014 = $Row[$this->ColNumbers['Clamae2014']];
        if(strlen($Clamae2014) >= 6) {
            $resultado->Registros[] = $Row;
            $entity = null;
            if (! $entity) {
                $entity = $this->em->getRepository('YacareComercioBundle:Actividad')
                    ->findOneBy(array('Clamae2014' => $Clamae2014));
            }
            
            if (! $entity) {
                $entity = new \Yacare\ComercioBundle\Entity\Actividad();
                $entity->setClamae2014($Clamae2014);
                $resultado->RegistrosNuevos++;
            } else {
                $resultado->RegistrosActualizados++;
            }
            
            $Exenta = $Row[$this->ColNumbers['Exenta']];
            
            $entity->setNombre($Row[$this->ColNumbers['Nombre']]);
            $entity->setCategoriaAntigua($Row[$this->ColNumbers['Categoria']]);
            $entity->setClanae2010(substr($Clamae2014, 0, 6));
            
            if($Exenta) {
                //echo $Clamae2014 . ' - ' . $entity->getNombre() . "\n";
            }
            
            $this->em->persist($entity);
            $this->em->flush();
        } else {
            $resultado->RegistrosIgnorados++;
        }
        
        return $resultado;
    }
    
    protected function ObtenerArchivo($params = 'r') {
        return fopen('Nomenclador.csv', $params);
    }
}