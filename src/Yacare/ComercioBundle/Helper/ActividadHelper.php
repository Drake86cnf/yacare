<?php
namespace Yacare\ComercioBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante cambios en las actividades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActividadHelper extends \Yacare\BaseBundle\Helper\AbstractHelper
{

    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($actividad, $args = null)
    {
        if (! $actividad->getId()) {
            /*
             * No tiene id. Como es parte de un árbol, necesito asignar un id manualmente.
             */
            $nuevoId = $this->getDoctrine()
                ->getManager()
                ->createQuery('SELECT MAX(r.id) FROM YacareComercioBundle:Actividad r')
                ->getSingleScalarResult();
            $actividad->setId(++ $nuevoId);
            $metadata = $em->getClassMetaData(get_class($actividad));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        
        /*
         * Quito guiones, espacios y puntos del código
         */
        $codigo = trim(str_replace('-', '', str_replace(' ', '', str_replace('.', '', $actividad->getClamae2014()))));
        $actividad->setClamae2014($codigo);
        
        /*
         * Calculo el ClaE AFIP y el ClaNAE 2010
         */
        $actividad->setClaeAfip(substr($codigo, 0, 6));
        $actividad->setClanae2010(substr($codigo, 0, 5));
        
        /*
         * Busco un ParentNode acorde al código ingresado
         */
        if (strlen($codigo) == 7) {
            // Los códigos finales (de 7 dígitos) dependen de una clase (4 dígitos)
            $codigoPadre = substr($codigo, 0, 4);
            $actividad->setFinal(true);
        } elseif (strlen($codigo) == 4) {
            // Las clases (de 4 dígitos) dependen de un grupo (3 dígitos)
            $codigoPadre = substr($codigo, 0, 3);
        } elseif (strlen($codigo) == 3 && $codigo != 'III') {
            // Los grupos (de 3 dígitos) dependen de una división (2 dígitos)
            $codigoPadre = substr($codigo, 0, 2);
        } elseif (strlen($codigo) == 2 && $codigo != 'II' && $codigo != 'IV') {
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
            $parentNode = $this->em->getRepository('YacareComercioBundle:Actividad')->findOneBy(
                ['Clamae2014' => $codigoPadre, 'ClaeAfip' => $codigoPadre]);
            $actividad->setParentNode($parentNode);
        } else {
            // Seteo el mismo parent, para que acomode el path
            $actividad->setParentNode($actividad->getParentNode());
        }
        
        $Hijos = $this->em->getRepository('YacareComercioBundle:Actividad')->findBy(
            ['ParentNode' => $actividad->getId()]);
        foreach ($Hijos as $Hijo) {
            $Hijo->setParentNode($actividad->getParentNode());
        }
    }
}
