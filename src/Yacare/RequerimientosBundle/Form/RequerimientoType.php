<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequerimientoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Categoria', null, array(
                'label' => 'Categoría',
                'attr' => array ('help' => 'Si no sabe cual seleccionar, puede dejarla en blanco para que el administrador asigne una.'),
                'required' => false))
            ->add('Notas', null, array(
                'label' => 'Descripción',
                'required' => true))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento','cascade_validation' => true));
    }

    public function getName()
    {
        return 'yacare_requerimientosbundle_requerimientotype';
    }
}
