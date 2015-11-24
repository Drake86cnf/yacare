<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de etiquetas de actas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActaEtiquetaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Nombre', null, array('label' => 'Nombre', 'required' => true))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\ActaEtiqueta'));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_actaetiquetatype';
    }
}
