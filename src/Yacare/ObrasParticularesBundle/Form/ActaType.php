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
            ->add('Talonario', null, array('label' => 'Talonario'))
            ->add('Numero', null, array(
                'label' => 'Numero', 
                'required' => true))
            ->add('SubTipo', 'choice', array(
                'choices' => array(
                    'Anulada' => 'Anulada', 
                    'Constatación' => 'Constatación', 
                    'Infracción' => 'Infracción', 
                    'Inspección' => 'Inspección', 
                    'Notificación' => 'Notificación'), 
                'required' => true, 
                'label' => 'Tipo de acta'))
            ->add('Fecha', 'date', array(
                'years' => range(1900, 2099), 
                'input' => 'datetime', 
                'format' => 'dd/MM/yyyy', 
                'widget' => 'single_text', 
                'label' => 'Fecha'))
            ->add('Comercio', 'entity_id', array(
                'label' => 'Comercio', 
                'class' => 'Yacare\ComercioBundle\Entity\Comercio', 
                'required' => false))
            ->add('Persona', 'entity_id', array(
                'label' => 'Persona', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'filters' => array('filtro_grupo' => 1), 
                'required' => false))
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ->add('FuncionarioPrincipal', 'entity_id', array(
                'label' => 'Funcionario Principal', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'filters' => array('filtro_grupo' => 1), 
                'required' => true))
            ->add('FuncionarioSecundario', 'entity_id', array(
                'label' => 'Funcionario Secundario', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'filters' => array('filtro_grupo' => 1), 
                'required' => false))
            ->add('ResponsableNombre', null, array('label' => 'Responsable'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\ActaRutinaComercio'));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_actarutinacomerciotype';
    }
}
