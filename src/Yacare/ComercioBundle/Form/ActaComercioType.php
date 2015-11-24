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
            ->add('Comercio', 'entity_hidden', array(
                'label' => 'Comercio', 
                'class' => 'Yacare\ComercioBundle\Entity\Comercio', 
                'required' => false))
            ->add('Numero', null, array(
                'label' => 'Numero',
                'attr' => array ('class' => 'tapir-input-160'),
                'required' => true
            ))
            ->add('SubTipo', 'choice', array(
                'choices' => array(
                    'Inspección de rutina' => 'Inspección de rutina',
                    'Inspección con tasa' => 'Inspección con tasa',
                    'Inspección previa' => 'Inspección previa',
                    'Notificación' => 'Notificación', 
                    'Infracción' => 'Infracción', 
                    'Constatación' => 'Constatación', 
                    'Suspensión' => 'Suspensión',
                    'Otra' => 'Otra'
                ), 
                'required' => true,
                'label' => 'Tipo de acta'))
            ->add('Etiquetas', 'entity', array(
                'class' => 'Yacare\ComercioBundle\Entity\ActaEtiqueta',
                'multiple' => true,
                'label' => 'Etiquetas',
                'placeholder' => 'Seleccione una o más etiquetas',
                'required' => false))
            ->add('Fecha', new \Tapir\BaseBundle\Form\Type\FechaType(), array('label' => 'Fecha'))
            ->add('FuncionarioPrincipal', 'entity', array(
                'label' => 'Inspector',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_COMERCIO_INSPECTOR');
                },
                'required' => true))
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\ActaComercio'));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_actacomerciotype';
    }
}
