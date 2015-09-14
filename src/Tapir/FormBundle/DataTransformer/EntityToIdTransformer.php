<?php
namespace Tapir\FormBundle\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\NoResultException;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * TODO: Obsoleto. Usar AjaxEntityTransformer
 *
 * @author Gregwar <g.passault@gmail.com>
 */
class EntityToIdTransformer implements DataTransformerInterface
{
    protected $registry;
    protected $class;
    protected $property;
    protected $queryBuilder;
    protected $multiple;
    protected $unitOfWork;

    //public function __construct(EntityManager $em, $class, $property, $queryBuilder, $multiple)
    public function __construct(ManagerRegistry $registry, $class, $multiple, $property, $queryBuilder)
    {
        if (! (null === $queryBuilder || $queryBuilder instanceof QueryBuilder || $queryBuilder instanceof \Closure)) {
            throw new UnexpectedTypeException($queryBuilder, 'Doctrine\ORM\QueryBuilder or \Closure');
        }

        if (null == $class) {
            throw new UnexpectedTypeException($class, 'string');
        }

        $this->repo = $registry->getManager()->getRepository($class);

        $this->registry = $registry;
        $this->unitOfWork = $this->registry->getManager()->getUnitOfWork();
        $this->class = $class;
        $this->queryBuilder = $queryBuilder;
        $this->multiple = $multiple;

        if ($property) {
            $this->property = $property;
        }
    }

    public function transform($data)
    {
        if (null === $data) {
            return null;
        }

        if (! $this->multiple) {
            return $this->transformSingleEntity($data);
        }

        $return = array();

        foreach ($data as $element) {
            $return[] = $this->transformSingleEntity($element);
        }

        return implode(', ', $return);
    }

    protected function splitData($data)
    {
        return explode(',', $data);
    }

    protected function transformSingleEntity($data)
    {
        if (! $this->unitOfWork->isInIdentityMap($data)) {
            throw new FormException('Entities passed to the choice field must be managed');
        }

        if ($this->property) {
            // Devuelve "id: propiedad"
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            return current($this->unitOfWork->getEntityIdentifier($data)) . ': ' .
                 $propertyAccessor->getValue($data, $this->property);
        }

        // Devuelve "id: " . __toString()
        return current($this->unitOfWork->getEntityIdentifier($data) . ': ' . (string) $data);
    }

    public function reverseTransform($data)
    {
        if (! $data) {
            return null;
        }

        if (! $this->multiple) {
            return $this->reverseTransformSingleEntity($data);
        }

        $return = array();

        foreach ($this->splitData($data) as $element) {
            $return[] = $this->reverseTransformSingleEntity($element);
        }

        return $return;
    }

    protected function reverseTransformSingleEntity($data)
    {
        $em = $this->registry->getManager();
        $class = $this->class;
        $repository = $em->getRepository($class);

        if (strpos($data, ': ') !== false) {
            $data = substr($data, 0, strpos($data, ': '));
        }

        if ($qb = $this->queryBuilder) {
            if ($qb instanceof \Closure) {
                $qb = $qb($repository, $data);
            }

            try {
                $result = $qb->getQuery()->getSingleResult();
            } catch (NoResultException $e) {
                $result = null;
            }
        } else {
            // if ($this->property) {
            // $result = $repository->findOneBy(array($this->property => $data));
            // } else {
            $result = $repository->find($data);
            // }
        }

        if (! $result) {
            throw new TransformationFailedException('No se encuentra la entidad');
        }

        return $result;
    }
}