<?php
namespace Tapir\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tapir\FormBundle\DataTransformer\EntityToIdTransformer;

/**
 * Campo de entidad oculta.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EntityHiddenType extends AbstractType
{
    protected $managerRegistry;

    public function __construct(RegistryInterface $registry)
    {
        $this->managerRegistry = $registry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->managerRegistry->getManagerForClass($options['class']);

        $transformer = new EntityToIdTransformer($em, $options['class'], $options['property'], $options['query_builder'],
            $options['multiple']);
        $builder->addModelTransformer($transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('class'));
        $resolver->setDefaults(array(
            'em' => null,
            'choice_label' => 'Nombre',
            'query_builder' => null,
            'filters' => null,
            'hidden' => false,
            'multiple' => false));
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'entity_hidden';
    }
}
