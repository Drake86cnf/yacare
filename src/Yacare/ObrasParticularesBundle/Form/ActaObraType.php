<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de actas de obra.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActaObraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Numero', null, array('label' => 'Numero', 'required' => true))
            ->add('SubTipo', 'choice', array(
                'choices' => array(
                    'Notificación' => 'Notificación', 
                    'Infracción' => 'Infracción', 
                    'Constatación' => 'Constatación', 
                    'Inspección' => 'Inspección', 
                    'Suspensión' => 'Suspensión'), 
                'required' => true, 
                'label' => 'Tipo de acta'))
            ->add('Profesional', 'entity_id', array(
                'label' => 'Profesional',
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado',
                'required' => false))
            ->add('Fecha', 'date', array(
                'years' => range(2014, 2099), 
                'input' => 'datetime', 
                'format' => 'dd/MM/yyyy', 
                'widget' => 'choice', 
                'label' => 'Fecha'))
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
                'required' => true))
            ->add('TipoFalta', 'entity', array(
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Tipofalta',
                'label' => 'El tipo de falta',
                'placeholder' => 'Seleccione la falta',
                'required' => true))
            ->add('FuncionarioPrincipal', 'entity', array(
                'label' => 'Inspector',
                'property' => 'NombreVisible',
                'placeholder' => 'Seleccione al inspector que intervino.',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_OBRAS_PARTICULARES_INSPECTOR');
                },
                'required' => true))
            ->add('Plazo', 'choice', array(
                'choices' => array(
                    '1' => '1 día',
                    '5' => '5 días',
                    '10' => '10 días',
                    '30' => '30 días',
                    '60' => '60 días',
                    '90' => '90 días'
                ),
                'label' => 'Plazo'))
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ObrasParticularesBundle\Entity\ActaObra'));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_actaobratype';
    }
}
