<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de actas.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('Talonario', null, array('label' => 'Talonario'))
            ->add('Numero', null, array('label' => 'Numero', 'required' => true))
            ->add('Tipo', 'choice', array(
                'choices' => array(
                    0 => 'Notificación', 
                    1 => 'Infracción', 
                    3 => 'Constatación', 
                    3 => 'Inspección', 
                    5 => 'Infración/Suspensión'), 
                'required' => true, 
                'label' => 'Tipo de acta'))
            ->add('Fecha', 'date', array(
                'years' => range(1900, 2099), 
                'input' => 'datetime', 
                'format' => 'dd/MM/yyyy', 
                'widget' => 'single_text', 
                'label' => 'Fecha'))
            ->add('Plazo', null, array('label' => 'El plazo', 'required' => true))
            ->add('Partida', 'entity_id', array(
                'label' => 'La partida asociada', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
                'required' => false))
            ->add('Inspector', 'entity', array(
                'label' => 'Inspector asociado',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function (\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                return $er->ObtenerQueryBuilderPorRol('ROLE_OBRAS_PARTICULARES_INSPECTOR');
                },
                'required' => true))
            /*->add('Persona', 'entity_id', array(
                'label' => 'Persona', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'filters' => array('filtro_grupo' => 1), 
                'required' => false))*/
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            /*->add('FuncionarioPrincipal', 'entity_id', array(
                'label' => 'Funcionario Principal', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'filters' => array('filtro_grupo' => 1), 
                'required' => true))
            ->add('FuncionarioSecundario', 'entity_id', array(
                'label' => 'Funcionario Secundario', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'filters' => array('filtro_grupo' => 1), 
                'required' => false))*/
            ->add('ResponsableNombre', null, array('label' => 'Responsable'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\Acta'));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_actarutinacomerciotype';
    }
}
