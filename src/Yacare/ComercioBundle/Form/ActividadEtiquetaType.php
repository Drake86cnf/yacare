<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para una etiqueta de actividad.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 */
class ActividadEtiquetaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Codigo', null, array(
                'label' => 'Código',
                'attr' => array('class' => 'tapir-input-160'),
                'required' => true))
            ->add('Nombre', null, array(
                'label' => 'Nombre',
                'required' => true))
            ->add('Obs', null, array(
                'label' => 'Obs.',
                'required' => false))
            ;
    }

    public function getName()
    {
        return 'yacare_comerciobundle_actividadetiquetatype';
    }
}
