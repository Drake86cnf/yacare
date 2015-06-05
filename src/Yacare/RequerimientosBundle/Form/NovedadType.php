<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class NovedadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Notas', null, array(
                'label' => 'Descripción',
                'required' => true))
            ->add('Usuario', 'entity_hidden', array(
                'class' => 'Yacare\BaseBundle\Entity\Persona'
            ))
            ->add('Requerimiento', 'entity_hidden', array(
                'class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\RequerimientosBundle\Entity\Novedad','cascade_validation' => true));
    }

    public function getName()
    {
        return 'yacare_requerimientosbundle_novedadtype';
    }
}
