<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para comentarios.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComentarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Obs', null, array(
                'label' => 'Comentario', 
                'attr' => array('maxlength' => '500')))
            ->add('EntidadTipo', 'Symfony\Component\Form\Extension\Core\Type\HiddenType')
            ->add('EntidadId', 'Symfony\Component\Form\Extension\Core\Type\HiddenType');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Comentario'));
    }
}
