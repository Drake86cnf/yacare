<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de actas de obra.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class ActaObraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Numero', null, array('label' => 'Numero', 'required' => true))
            ->add('SubTipo', 'choice', array(
                'placeholder' => 'Seleccione el tipo de acta.',
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
            ->add('TipoFaltas', 'entity', array(
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Tipofalta',
                'multiple' => true,
                'label' => 'El tipo de falta',
                'placeholder' => 'Seleccione la falta',
                'required' => true))
            ->add('TipoConstruccion', 'choice', array(
                'placeholder' => 'Seleccione el tipo de la obra',
                'choices' => array(
                    'Húmeda' => 'Húmeda',
                    'Seca' => 'Seca',
                    'Mixta' => 'Mixta',
                    'Industrializada en chapa y/o madera' => 'Industrializada en chapa y/o madera'
                ),
                'label' => 'Tipo de construcción',
                'required' => true))
            ->add('EstadoAvance', 'choice', array(
                'placeholder' => 'Seleccione el estado de la obra',
                'choices' => array(
                    1 => 'Replanteo y fundaciones',
                    5 => 'Mampostería en planta baja',
                    6 => 'Estructura en planta baja',
                    10 => 'Encadenado superior en planta baja',
                    15 => 'Entrepiso',
                    20 => 'Mampostería en planta alta',
                    25 => 'Encadenado superior en planta alta',
                    30 => 'Estructura de techo',
                    35 => 'Techado'
                ),
                'label' => 'Estado de avance de la obra',
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
            ->add('Obs', null, array('label' => 'Observaciones'))
            /*->add('Plazo', 'choice', array(
                'choices' => array(
                    '1' => '1 día',
                    '5' => '5 días',
                    '10' => '10 días',
                    '30' => '30 días',
                    '60' => '60 días',
                    '90' => '90 días'
                ),
                'label' => 'Plazo'))*/
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
