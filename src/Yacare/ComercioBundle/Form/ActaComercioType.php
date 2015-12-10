<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de actas de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActaComercioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('Talonario', null, array('label' => 'Talonario'))
            ->add('Comercio', 'Tapir\FormBundle\Form\Type\EntityHiddenType', array(
                'label' => 'Comercio', 
                'class' => 'Yacare\ComercioBundle\Entity\Comercio', 
                'required' => false))
            ->add('SubTipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices' => array(
                    'Inspección de rutina' => 'Inspección de rutina',
                    'Inspección con tasa' => 'Inspección con tasa',
                    'Inspección previa' => 'Inspección previa',
                    'Inspección final' => 'Inspección final',
                    'Notificación' => 'Notificación', 
                    'Infracción' => 'Infracción', 
                    'Constatación' => 'Constatación', 
                    'Suspensión' => 'Suspensión',
                    'Clausura preventiva' => 'Clausura preventiva',
                    'Clausura' => 'Clausura',
                    'Levantamiento de clausura' => 'Levantamiento de clausura',
                    'Otra' => 'Otra'
                ), 
                'required' => true,
                'label' => 'Tipo de acta'))
            ->add('Numero', null, array(
                'label' => 'Numero',
                'attr' => array ('class' => 'tapir-input-160'),
                'required' => true
            ))
            ->add('Fecha', 'Tapir\BaseBundle\Form\Type\FechaType', array('label' => 'Fecha'))
            ->add('Hora', null, array(
                'label' => 'Hora',
                'attr' => array('class' => 'tapir-input-120')
            ))
            ->add('FuncionarioPrincipal', 'entity', array(
                'label' => 'Inspector',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_COMERCIO_INSPECTOR');
                },
                'required' => true))
            ->add('OtrosFuncionarios', 'entity', array(
                'multiple' => true,
                'label' => 'Otros funcionarios',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_COMERCIO_INSPECTOR');
                },
                'required' => false))
            ->add('Etiquetas', 'entity', array(
                'class' => 'Yacare\ComercioBundle\Entity\ActaEtiqueta',
                'multiple' => true,
                'label' => 'Etiquetas',
                'placeholder' => 'Seleccione una o más etiquetas',
                'required' => false))
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\ActaComercio'));
    }
}
