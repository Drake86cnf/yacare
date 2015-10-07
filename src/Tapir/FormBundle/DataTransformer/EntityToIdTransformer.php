<?php
namespace Tapir\FormBundle\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Transforma una o más entidades en una cadena de id separados por coma.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EntityToIdTransformer implements DataTransformerInterface
{
    protected $repo;
    protected $multiple;
    protected $property;

    public function __construct(ManagerRegistry $registry, $class, $multiple, $property)
    {
        $this->repo = $registry->getManager()->getRepository($class);
        $this->multiple = $multiple;
        $this->property = $property;
    }

    public function transform($value)
    {
        if ($value === null) {
            return '';
        }

        if (is_array($value) || $value instanceof Collection) {
            $ret = array();
            foreach ($value as $entity) {
                $ret[] = $entity->getId();
            }
            return implode(',', $ret);
        } elseif (is_object($value)) {
            return $value->getId();
        }
        return null;
    }

    public function reverseTransform($value)
    {
        if (! $value) {
            return $this->multiple ? array() : null;
        }
        if ($this->multiple) {
            $ids = explode(',', $value);
            $ids = array_unique($ids);
            $qb = $this->repo->createQueryBuilder('entity');
            $qb->where('entity.id IN (:ids)')->setParameter('ids', $ids);
            return new ArrayCollection($qb->getQuery()->execute());
        }
        $entity = $this->repo->find($value);
        if (! $entity) {
            throw new TransformationFailedException(
                sprintf('No existe la endidad "%s" con id "%s".', $this->repo->getClassName(), $value));
        }
        return $entity;
    }

    protected function getText($object)
    {
        if (! $this->property || ! class_exists('Symfony\Component\PropertyAccess\PropertyAccess')) {
            return (string) $object;
        }
        $accessor = PropertyAccess::createPropertyAccessor();
        return $accessor->getValue($object, $this->property);
    }
}
