<?php
namespace Tapir\BaseBundle\Helper;

class BuscadorDeRelaciones
{
    private $em;

    function __constructor($em)
    {
        $this->em = $em;
    }

    public function CantidadRelaciones($entidad)
    {
        // Para obtener todas las entidades que referencia a las tablas en la DB:
        $NombresEntidades = array();
        $MetadatosEntidades = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($MetadatosEntidades as $MetadatosEntidad) {
            $NombresEntidades[] = $MetadatosEntidad->getName();
        }
        
        $contador = 0;
        
        // Recorro el array con todas las entidades de la aplicación.
        foreach ($NombresEntidades as $NombreEntidad) {
            // Llamo a la rutina de búsqueda y el valor devuelto (el contador) se lo asigno a esta variable $contador.
            $contador += $this->rutinaBusqueda($NombreEntidad, $entidad->getId());
            // $TotalRelaciones += $this->ObtenerCantidadRelaciones($entidad, $id);
            if ($contador >= 5)
                break;
        }
    }

    
    /**
     * Rutina de búsqueda de asociaciones, a partir del objeto de una entidad.
     *
     * Realiza una búsqueda a través de todas aquellas tablas en donde, la entidad del
     * objeto estudiado, tenga relaciones de asociaciones. Identifica y devuelve un
     * contador con la cantidad de asociaciones encontradas.
     *
     * @param array $resultado
     *            de la consulta a la metadata de ORM.
     * @param integer $id
     *            de la entidad a analizar.
     *            
     * @return integer $contador variable con la cantidad de relaciones encontradas para esa entidad.
     */
    protected function rutinaBusqueda($NombreEntidad, $id)
    {
        $Asociaciones = $this->em->getClassMetadata($NombreEntidad)->getAssociationMappings();
        
        $contador = 0;
        $arrayAux = array();
        
        if ($Asociaciones != null) {
            
            // Recorro el array de la relación de la entidad a suprimir.
            foreach ($Asociaciones as $Asociacion) { // Recorro el primer nivel del array devuelto
                                                     // con el mapeado de asociaciones.
                                                     
                // Me aseguro que la entidad objetivo de $varloRes coincida con la ruta de la entidad del objeto a suprimir.
                if ($Asociacion['targetEntity'] == trim($this->CompleteEntityName, '\\') && $Asociacion['isOwningSide']) {
                    
                    switch ($Asociacion['type']) {
                        // Reconozco que es una relación OneToOne.
                        case 1:
                            break;
                        
                        // Reconozco que es una relación ManyToOne.
                        case 2:
                            $arrayAux[] = $this->rutinaManyToOne($Asociacion, $id);
                            break;
                        
                        // Reconozco que es una relación OneToMany.
                        case 4:
                            $arrayAux[] = $this->rutinaOneToMany($Asociacion, $id);
                            break;
                        
                        // Reconozco que es una relación ManyToMany.
                        case 8:
                            $arrayAux[] = $this->rutinaManyToMany($Asociacion, $id);
                            break;
                        
                        default:
                            $contador = 'No posee relaciones';
                            break;
                    }
                    if (count($arrayAux) == 1 && $arrayAux[0] >= 5) {
                        break;
                    } else {
                        foreach ($arrayAux as $aux) {
                            if ($aux >= 5) {
                                break;
                            }
                        }
                    }
                }
            }
            
            /*
             * Evalúo si una entidad referencia, a la entidad del objeto estudiado, en más de una (1)
             * variable, es decir, posee 2 o más variables que referencian (dentro de una entidad) a la entidad
             * del objeto a suprimir.
             */
            if (count($arrayAux) == 1) {
                $contador += $arrayAux[0];
            } else {
                $contadorAux = 0;
                foreach ($arrayAux as $aux) {
                    if ($aux > $contadorAux) {
                        $contadorAux = $aux;
                    }
                }
                $contador += $contadorAux;
            }
            $arrayAux[] = array();
        }
        
        return $contador;
    }

    /**
     * Rutina destinada a la consulta de asociaciones para relaciones de ManyToOne.
     *
     * Rutina simple, en la que sólo obtiene la ruta de la entidad remitente (que referencia a la entidad a suprimir),
     * en el array de asociaciones y busca concordancia entre la ID de la entidad estudiada, con la entidad remitente.
     *
     * @param array $valorRes            
     * @param int $id            
     *
     * @return int $contador
     */
    protected function rutinaManyToOne($valorRes, $id)
    {
        $em = $this->getEm();
        $variableRemitente = $valorRes['fieldName'];
        $rutaRemitente = $valorRes['sourceEntity'];
        $contador = count($em->getRepository($rutaRemitente)->findBy(array(
            $variableRemitente => $id
        ), array(
            'id' => 'ASC'
        ), 5));
        
        return $contador;
    }

    /**
     * Rutina encargada de manejar consulta en relaciones OneTomany.
     *
     * @param array $valorRes            
     * @param int $id            
     *
     * @return int $contador
     */
    protected function rutinaOneToMany($valorRes, $id)
    {
        $em = $this->getEm();
        $variableRemitente = $valorRes['fieldName'];
        $rutaRemitente = $valorRes['sourceEntity'];
        $contador = count($em->getRepository($rutaRemitente)->findBy(array(
            $variableRemitente => $id
        ), array(
            'id' => 'ASC'
        ), 5));
        
        return $contador;
    }

    /**
     * Rutina que se encarga de realizar la consulta para la relación ManyToMany.
     *
     * @param int $id            
     * @param array $valorRes            
     *
     * @return int $contador
     */
    protected function rutinaManyToMany($valorRes, $id)
    {
        $variableRemitente = $valorRes['fieldName'];
        $rutaRemitente = $valorRes['sourceEntity'];
        $contador = count($this->construirDQL($id, $rutaRemitente, $variableRemitente));
        
        return $contador;
    }

    /**
     * Método para construir una sentencia SELECT en formato DQL.
     *
     * Busca, a partir de los parámetros dados, si existe una asociación
     * con el objeto a suprimir.
     *
     * @param int $id
     *            ID de la entidad a suprimir.
     * @param string $rutaRemitente
     *            ruta a la entidad que referencia al objeto a suprimir.
     * @param string $variableRemitente
     *            variable que referencia al objeto de la entidad a suprimir.
     * @return array $res resultado de la consulta.
     */
    public function construirDQL($id, $rutaRemitente, $variableRemitente)
    {
        $em = $this->getEm();
        $res = $em->createQueryBuilder()
            ->select('a, b')
            ->addselect('a.id')
            ->from($rutaRemitente, 'a')
            ->leftJoin('a.' . $variableRemitente, 'b')
            ->where('b.id = :condicion')
            ->setParameter('condicion', $id);
        
        $res = $res->getQuery()
            ->setMaxResults(5)
            ->getResult();
        
        return $res;
    }
}