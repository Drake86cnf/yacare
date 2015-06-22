<?php
namespace Tapir\BaseBundle\Helper;

class BuscadorDeRelaciones
{

    private $em;

    function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Búsqueda de al menos una relación, para el objeto estudiado.
     *
     * @param array $entidadASuprimir            
     * @return boolean
     */
    public function tieneAsociaciones($entidadASuprimir)
    {
        $nombresEntidades = $this->obtenerNombresDeEntidades();
        $hayRelacion = false;
        
        foreach ($nombresEntidades as $nombreEntidad) {
            $asociaciones = $this->em->getClassMetadata($nombreEntidad)->getAssociationMappings();
            if ($asociaciones) {
                foreach ($asociaciones as $asociacion) {
                    if ($asociacion['targetEntity'] == trim(get_class($entidadASuprimir), '\\') && $asociacion['isOwningSide']) {
                        if ($asociacion['type'] == 8) {
                            $hayRelacion = $this->construirDQL($entidadASuprimir, $asociacion['sourceEntity'], $asociacion['fieldName']);
                        } elseif (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($nombreEntidad, 'Tapir\BaseBundle\Entity\Suprimible')) {
                            $hayRelacion = $this->em->getRepository($asociacion['sourceEntity'])->findOneBy(array(
                                $asociacion['fieldName'] => $entidadASuprimir->getId(),
                                'Suprimido' => 0));
                        } else {
                            $hayRelacion = $this->em->getRepository($asociacion['sourceEntity'])->findOneBy(array(
                                $asociacion['fieldName'] => $entidadASuprimir->getId()));
                        }
                    }
                    if ($hayRelacion) {
                        return true;
                    }
                }
            }
        }
        
        return $hayRelacion ? true : false;
    }

    public function buscarAsociaciones($entidadASuprimir)
    {
        $nombresEntidades = $this->obtenerNombresDeEntidades();
        
        $totalRelaciones = 0;
        
        // Recorro el array con todas las entidades de la aplicación.
        foreach ($nombresEntidades as $nombreEntidad) {
            // Llamo a la rutina de búsqueda y el valor devuelto (el contador) se lo asigno a esta variable $totalRelaciones.
            $totalRelaciones += $this->obtenerCantidadRelaciones($nombreEntidad, $entidadASuprimir);
            if ($totalRelaciones >= 5) {
                break;
            }
        }
    }

    /**
     * Rutina de búsqueda de asociaciones, a partir del objeto de una entidad.
     *
     * @param array $nombreEntidad
     *            consulta a la metadata de ORM.
     * @param array $entidadASuprimir
     *            entidad a analizar.
     *            
     * @return integer $contador variable con la cantidad de relaciones encontradas para esa entidad.
     */
    protected function obtenerCantidadRelaciones($nombreEntidad, $entidadASuprimir)
    {
        $asociaciones = $this->em->getClassMetadata($nombreEntidad)->getAssociationMappings();
        
        $totalRelaciones = 0;
        $muchasReferencias = array();
        
        if ($asociaciones != null) {
            
            // Recorro el array de la relación de la entidad a suprimir.
            foreach ($asociaciones as $asociacion) { // Recorro el primer nivel del array devuelto
                                                     // con el mapeado de asociaciones.
                                                     
                // Me aseguro que la entidad objetivo de $varloRes coincida con la ruta de la entidad del objeto a suprimir.
                if ($asociacion['targetEntity'] == trim(get_class($entidadASuprimir), '\\') && $asociacion['isOwningSide']) {
                    
                    switch ($asociacion['type']) {
                        // Reconozco que es una relación OneToOne.
                        case 1:
                            break;
                        
                        // Reconozco que es una relación ManyToOne.
                        case 2:
                            $muchasReferencias[] = $this->rutinaManyToOne($asociacion, $entidadASuprimir->getId());
                            break;
                        
                        // Reconozco que es una relación OneToMany.
                        case 4:
                            $muchasReferencias[] = $this->rutinaOneToMany($asociacion, $entidadASuprimir->getId());
                            break;
                        
                        // Reconozco que es una relación ManyToMany.
                        case 8:
                            $muchasReferencias[] = $this->rutinaManyToMany($asociacion, $entidadASuprimir);
                            break;
                        
                        default:
                            $totalRelaciones = 'No posee relaciones';
                            break;
                    }
                    if (count($muchasReferencias) == 1 && $muchasReferencias[0] >= 5) {
                        break;
                    } else {
                        foreach ($muchasReferencias as $referencia) {
                            if ($referencia >= 5) {
                                break;
                            }
                        }
                    }
                }
            }
            
            /*
             * Evalúo si una entidad tiene dos o más propiedades, que referencien a la
             * entidad del objeto a suprimir. De ser así capturo el valor mayor
             * que se encuentre en el array.
             * Los valores corresponderán a la cantidad de registros que devuelva cada consulta
             * hecha sobre una misma entidad.
             */
            if (count($muchasReferencias) == 1) {
                $totalRelaciones += $muchasReferencias[0];
            } else {
                $posibleValorMayor = 0;
                foreach ($muchasReferencias as $referencia) {
                    if ($referencia > $posibleValorMayor) {
                        $posibleValorMayor = $referencia;
                    }
                }
                $totalRelaciones += $posibleValorMayor;
            }
            $muchasReferencias[] = array();
        }
        
        return $totalRelaciones;
    }

    /**
     * Rutina destinada a la consulta de asociaciones para relaciones de ManyToOne.
     *
     * @param array $asociacion            
     * @param int $id            
     *
     * @return int $totalRelaciones
     */
    protected function rutinaManyToOne($asociacion, $id)
    {
        $variableRemitente = $asociacion['fieldName'];
        $rutaRemitente = $asociacion['sourceEntity'];
        $totalRelaciones = count($this->em->getRepository($rutaRemitente)->findBy(array(
            $variableRemitente => $id), array(
            'id' => 'ASC'), 5));
        
        return $totalRelaciones;
    }

    /**
     * Rutina encargada de manejar consulta en relaciones OneTomany.
     *
     * @param array $asociacion            
     * @param int $id            
     *
     * @return int $totalRelaciones
     */
    protected function rutinaOneToMany($asociacion, $id)
    {
        $variableRemitente = $asociacion['fieldName'];
        $rutaRemitente = $asociacion['sourceEntity'];
        $totalRelaciones = count($this->em->getRepository($rutaRemitente)->findBy(array(
            $variableRemitente => $id), array(
            'id' => 'ASC'), 5));
        
        return $totalRelaciones;
    }

    /**
     * Rutina que se encarga de realizar la consulta para la relación ManyToMany.
     *
     * @param int $id            
     * @param array $asociacion            
     *
     * @return int $totalRelaciones
     */
    protected function rutinaManyToMany($asociacion, $entidadASuprimir)
    {
        $variableRemitente = $asociacion['fieldName'];
        $rutaRemitente = $asociacion['sourceEntity'];
        $totalRelaciones = count($this->construirDQL($entidadASuprimir, $rutaRemitente, $variableRemitente));
        
        return $totalRelaciones;
    }

    /**
     * Devuelve un array con los nombres de todas las entidades de la aplicación.
     *
     * @return array $nombresEntidades
     */
    protected function obtenerNombresDeEntidades()
    {
        // Para obtener todas las entidades que referencia a las tablas en la DB:
        $nombresEntidades = array();
        $metadatosEntidades = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($metadatosEntidades as $metadatosEntidad) {
            $nombresEntidades[] = $metadatosEntidad->getName();
        }
        
        return $nombresEntidades;
    }

    /**
     * Método con sentencia SELECT para asociaciones ManyToMany.
     *
     * @param int $id
     *            de la entidad a suprimir.
     * @param string $rutaEntidadCandidata
     *            ruta a la entidad que referencia al objeto a suprimir.
     * @param string $propiedadEntidadCandidata
     *            variable que referencia al objeto de la entidad a suprimir.
     * @return array $hayRelacion resultado de la consulta.
     */
    public function construirDQL($entidadASuprimir, $rutaEntidadCandidata, $propiedadEntidadCandidata)
    {
        $hayRelacion = $this->em->createQueryBuilder()
            ->select('a, b')
            ->addselect('a.id')
            ->from($rutaEntidadCandidata, 'a')
            ->leftJoin('a.' . $propiedadEntidadCandidata, 'b')
            ->where('b.id = :id_candidato');
        if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($rutaEntidadCandidata, 'Tapir\BaseBundle\Entity\Suprimible')) {
            $hayRelacion->andwhere('a.Suprimido = :no_es_suprimido')->setParameters(array(
                'id_candidato' => $entidadASuprimir->getId(),
                'no_es_suprimido' => 0));
        } else {
            $hayRelacion->setParameter(array(
                'id_candidato' => $entidadASuprimir->getId()));
        }
        
        $hayRelacion = $hayRelacion->getQuery()
            ->setMaxResults(1)
            ->getResult();
        
        return $hayRelacion;
    }
}