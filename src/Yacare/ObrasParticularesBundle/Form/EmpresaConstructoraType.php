<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de empresa constructora.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EmpresaConstructoraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Persona', 'entity_id', array(
                'label' => 'Empresa',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required' => true))
            ->add('RepresentanteTecnico', 'entity_id', array(
                'label' => 'Representante técnico',
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado',
                'required' => true))
            ->add('FechaVencimiento', 'date', array(
                'years' => range(2000, 2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de vencimiento',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\EmpresaConstructora'));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_empresaconstructoratype';
    }
}
