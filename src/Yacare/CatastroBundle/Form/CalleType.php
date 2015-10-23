<?php
namespace Yacare\CatastroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para calles.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class CalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('NombreAlternativo', null, array('label' => 'Nombre alternativo'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\CatastroBundle\Entity\Calle'));
    }

    public function getName()
    {
        return 'yacare_catastrobundle_calletype';
    }
}
