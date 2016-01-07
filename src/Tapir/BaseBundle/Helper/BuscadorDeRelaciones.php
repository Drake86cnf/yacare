<?php
namespace Tapir\BaseBundle\Helper;

/**
 * Distintos métodos de búsquedas de asociaciones de acuerdo a la necesidad.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
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
     * @param  array   $entidadASuprimir entidad a estudiar.
     * @return boolean si tiene asociaciones o no.
     */
    public function TieneAsociaciones($entidadASuprimir)
    {
        $NombresEntidades = $this->ObtenerNombresDeEntidades();
        
        if (($IdMismoElemento = array_search(get_class($entidadASuprimir), $NombresEntidades)) !== false) {
            unset($NombresEntidades[$IdMismoElemento]);
        }
        
        foreach ($NombresEntidades as $NombreEntidad) {
            $Asociaciones = $this->em->getClassMetadata($NombreEntidad)->getAssociationMappings();
            if ($Asociaciones) {
                foreach ($Asociaciones as $asociacion) {
                    if ($asociacion['targetEntity'] == trim(get_class($entidadASuprimir), '\\') &&
                         $asociacion['isOwningSide']) {
                        
                        if ($asociacion['type'] == 8) {
                            $Relaciones = $this->ObtenerRelacionesDesdeEntidad($entidadASuprimir, 
                                $asociacion['sourceEntity'], $asociacion['fieldName']);
                        } elseif (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($asociacion['sourceEntity'], 
                            'Tapir\BaseBundle\Entity\Suprimible')) {
                            $Relaciones = $this->em->getRepository($asociacion['sourceEntity'])->findOneBy(
                                array($asociacion['fieldName'] => $entidadASuprimir->getId(), 'Suprimido' => 0));
                        } else {
                            $Relaciones = $this->em->getRepository($asociacion['sourceEntity'])->findOneBy(
                                array($asociacion['fieldName'] => $entidadASuprimir->getId()));
                        }
                    }
                    if ($Relaciones && count($Relaciones) > 0) {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }

    /**
     * Busca las entidades relacionadas con esta.
     *
     * @return array Las entidades relacionadas con la entidadAEstudiar.
     */
    public function BuscarAsociaciones($entidadAEstudiar)
    {
        $ClaseEntidad = trim(get_class($entidadAEstudiar), '\\');
        $NombresEntidades = $this->ObtenerNombresDeEntidades();
        $res = array();
        
        foreach ($NombresEntidades as $NombreEntidad) {
            $Asociaciones = $this->em->getClassMetadata($NombreEntidad)->getAssociationMappings();
            if ($Asociaciones) {
                foreach ($Asociaciones as $asociacion) {
                    if ($asociacion['targetEntity'] == $ClaseEntidad && $asociacion['isOwningSide']) {
                        if ($asociacion['type'] == 8) {
                            $Relaciones = $this->ObtenerRelacionesDesdeEntidad($entidadAEstudiar, 
                                $asociacion['sourceEntity'], $asociacion['fieldName']);
                        } elseif (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($asociacion['sourceEntity'], 
                            'Tapir\BaseBundle\Entity\Suprimible')) {
                            $Relaciones = $this->em->getRepository($asociacion['sourceEntity'])->findBy(
                                array($asociacion['fieldName'] => $entidadAEstudiar->getId(), 'Suprimido' => 0), null, 5);
                        } elseif($asociacion['sourceEntity'] != $ClaseEntidad) {
                            $Relaciones = $this->em->getRepository($asociacion['sourceEntity'])->findBy(
                                array($asociacion['fieldName'] => $entidadAEstudiar->getId()), null, 5);
                        } else {
                            $Relaciones = null;
                        }
                        if ($Relaciones && count($Relaciones) > 0) {
                            $res = array_merge($res, $Relaciones);
                        }
                    }
                }
            }
        }
        
        return $res;
    }

    public function old_buscarAsociaciones($entidadASuprimir)
    {
        $nombresEntidades = $this->ObtenerNombresDeEntidades();
        $totalRelaciones = 0;
        
        // Recorro el array con todas las entidades de la aplicación.
        foreach ($nombresEntidades as $nombreEntidad) {
            // Llamo a la rutina de búsqueda y el valor devuelto (el contador) se lo asigno a esta variable
            // $totalRelaciones.
            $totalRelaciones += $this->obtenerCantidadRelaciones($nombreEntidad, $entidadASuprimir);
            if ($totalRelaciones >= 5) {
                break;
            }
        }
    }

    /**
     * Rutina de búsqueda de asociaciones, a partir del objeto de una entidad.
     *
     * @param  array    $nombreEntidad    Consulta a la metadata de ORM.
     * @param  array    $entidadASuprimir Entidad a analizar.
     * @return integer  $contador         Variable con la cantidad de relaciones encontradas para esa entidad.
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
                                                     
                // Me aseguro que la entidad objetivo de $varloRes coincida con la ruta de la entidad del objeto a
                                                     // suprimir.
                if ($asociacion['targetEntity'] == trim(get_class($entidadASuprimir), '\\') &&
                     $asociacion['isOwningSide']) {
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
                            $muchasReferencias[] = $this->RutinaManyToMany($asociacion, $entidadASuprimir);
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
     * @param  array $asociacion      array de metadatos de la entidad estudiada.
     * @param  int   $id              ID de la entidad.
     * @return int   $totalRelaciones cantidad de asociaciones ManyToOne de la entidad estudiada.
     */
    protected function rutinaManyToOne($asociacion, $id)
    {
        $variableRemitente = $asociacion['fieldName'];
        $rutaRemitente = $asociacion['sourceEntity'];
        $totalRelaciones = count(
            $this->em->getRepository($rutaRemitente)->findBy(array($variableRemitente => $id), array('id' => 'ASC'), 5));
        
        return $totalRelaciones;
    }

    /**
     * Rutina encargada de manejar consulta en relaciones OneTomany.
     *
     * @param  array $asociacion      array de metadatos de la entidad estudiada.
     * @param  int   $id              ID de la entidad.
     * @return int   $totalRelaciones cantidad de asociaciones OneToMany de la entidad estudiada.
     */
    protected function rutinaOneToMany($asociacion, $id)
    {
        $variableRemitente = $asociacion['fieldName'];
        $rutaRemitente = $asociacion['sourceEntity'];
        $totalRelaciones = count(
            $this->em->getRepository($rutaRemitente)->findBy(array($variableRemitente => $id), array('id' => 'ASC'), 5));
        
        return $totalRelaciones;
    }

    /**
     * Rutina que se encarga de realizar la consulta para la relación ManyToMany.
     *            
     * @param  array $asociacion      array de metadatos de la entidad estudiada.
     * @param  int   $id              ID de la entidad.
     * @return int   $totalRelaciones cantidad de asociaciones ManyToMany de la entidad estudiada.
     */
    protected function RutinaManyToMany($asociacion, $entidadASuprimir)
    {
        $variableRemitente = $asociacion['fieldName'];
        $rutaRemitente = $asociacion['sourceEntity'];
        $totalRelaciones = count(
            $this->ObtenerRelacionesDesdeEntidad($entidadASuprimir, $rutaRemitente, $variableRemitente));
        
        return $totalRelaciones;
    }

    /**
     * Devuelve un array con los nombres de todas las entidades de la aplicación.
     *
     * @return array $nombresEntidades Nombres de las entidades en DB.
     */
    protected function ObtenerNombresDeEntidades()
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
     * Buscar las relaciones de una entidad con esta.
     *
     * @param  array  $entidadASuprimir          Entidad a suprimir.
     * @param  string $rutaEntidadCandidata      Ruta a la entidad que referencia al objeto a suprimir.
     * @param  string $propiedadEntidadCandidata Variable que referencia al objeto de la entidad a suprimir.
     * @return array  $hayRelacion               Resultado de la consulta.
     */
    public function ObtenerRelacionesDesdeEntidad($entidadASuprimir, $rutaEntidadCandidata, $propiedadEntidadCandidata)
    {
        $ConsultaRelaciones = $this->em->createQueryBuilder()
            ->
        // ->select('a, b')
        // ->addselect('a.id')
        select('a')
            ->from($rutaEntidadCandidata, 'a')
            ->leftJoin('a.' . $propiedadEntidadCandidata, 'b')
            ->where('b.id = :id_candidato');
        if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($rutaEntidadCandidata, 'Tapir\BaseBundle\Entity\Suprimible')) {
            $ConsultaRelaciones->andwhere('a.Suprimido = :no_es_suprimido')->setParameters(
                array('id_candidato' => $entidadASuprimir->getId(), 'no_es_suprimido' => 0));
        } else {
            $ConsultaRelaciones->setParameter('id_candidato', $entidadASuprimir->getId());
        }
        
        return $ConsultaRelaciones->getQuery()->setMaxResults(5)->getResult();
    }
}
