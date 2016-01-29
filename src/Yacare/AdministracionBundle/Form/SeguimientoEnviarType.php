<?php
namespace Yacare\AdministracionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de seguimiento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class SeguimientoEnviarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('DepartamentoDestino', null, array('label' => 'Destino', 'required' => true))
            ->add('Nombre', null, array('label' => 'Comentario', 'required' => false, 'attr' => [ 'placeholder' => 'Comentario opcional']))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\AdministracionBundle\Entity\Seguimiento'));
    }
}
