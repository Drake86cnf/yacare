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
            ->add('SubTipo', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), array(
                'choices' => array(
                    'Notificación' => 'Notificación', 
                    'Infracción' => 'Infracción', 
                    'Constatación' => 'Constatación', 
                    'Inspección' => 'Inspección', 
                    'Suspensión' => 'Suspensión'), 
                'required' => true, 
                'label' => 'Tipo de acta'))
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
            ->add('ResponsableNombre', null, array(
                'label' => 'Responsable',
                'required' => false
            ))
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
