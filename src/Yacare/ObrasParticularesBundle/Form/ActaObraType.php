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
            ->add('Numero', null, array(
                'label' => 'Número',
                'attr' => array('class' => 'tapir-input-320'),
                'required' => true))
            ->add('SubTipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'placeholder' => 'Seleccione el tipo de acta',
                'choices' => array(
                    'Notificación' => 'Notificación', 
                    'Infracción' => 'Infracción', 
                    'Constatación' => 'Constatación', 
                    'Inspección' => 'Inspección', 
                    'Suspensión' => 'Suspensión'), 
                'required' => true,
                'attr' => array('class' => 'tapir-input-320'),
                'label' => 'Tipo de acta'))
            ->add('Profesional', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Profesional',
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado',
                'required' => false))
            ->add('Fecha', 'Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType', array('label' => 'Fecha'))
            ->add('Partida', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Partida', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
                'required' => true))
            ->add('TipoFaltas', 'entity', array(
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Tipofalta',
                'multiple' => true,
                'label' => 'Faltas',
                'placeholder' => 'Seleccione las faltas',
                'required' => true))
            ->add('TipoConstruccion', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices' => array(
                    'Mixta' => 'Mixta',
                    'Húmeda' => 'Húmeda',
                    'Seca' => 'Seca',
                    'Industrializada de chapa y/o madera' => 'Industrializada de chapa y/o madera'
                ),
                'attr' => array('class' => 'tapir-input-320'),
                'label' => 'Tipo de construcción',
                'required' => true))
            ->add('EstadoAvance', 'choice', array(
                'placeholder' => 'Seleccione el estado de la obra',
                'choices' => array(
                    1 => 'Replanteo y fundaciones',
                    5 => 'Mampostería en planta baja',
                    10 => 'Encadenado superior en planta baja',
                    15 => 'Entrepiso',
                    20 => 'Mampostería en planta alta',
                    25 => 'Encadenado superior en planta alta',
                    30 => 'Estructura de techo',
                    35 => 'Techado'
                ),
                'attr' => array('class' => 'tapir-input-320'),
                'label' => 'Estado de la obra',
                'required' => false))
                // Solución temporal para los tipos de obra Seca.
            ->add('EstadoAvance2', 'choice', array(
                'placeholder' => 'Seleccione el estado de la obra',
                'choices' => array(
                    5 => 'Estructura en planta baja',
                    15 => 'Entrepiso',
                    20 => 'Estructura en planta alta',
                    30 => 'Estructura de techo',
                    35 => 'Techado'
                ),
                'attr' => array('class' => 'tapir-input-320'),
                'mapped' => false,
                'label' => 'Estado de la obra',
                'required' => false))
            // Fin solución temporal
            ->add('FuncionarioPrincipal', 'entity', array(
                'label' => 'Inspector',
                'property' => 'NombreVisible',
                'placeholder' => 'Seleccione al inspector que intervino',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_OBRAS_PARTICULARES_INSPECTOR');
                },
                'required' => true))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ObrasParticularesBundle\Entity\ActaObra'));
    }
}
