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
            //->add('Nombre', null, array('label' => 'Nombre del acta', 'required' => true))
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
            ->add('Fecha', 'date', array(
                'years' => range(1900, 2099), 
                'input' => 'datetime', 
                'format' => 'dd/MM/yyyy', 
                'widget' => 'single_text', 
                'label' => 'Fecha'))
            ->add('Plazo', null, array('label' => 'Plazo', 'required' => true))
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
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
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ->add('ResponsableNombre', null, array('label' => 'Responsable', 'required' => false))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\ActaObra'));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_actaobratype';
    }
}
