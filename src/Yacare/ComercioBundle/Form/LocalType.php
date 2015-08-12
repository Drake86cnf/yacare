<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Partida', 'entity_id', 
                array('label' => 'Partida', 'class' => 'Yacare\CatastroBundle\Entity\Partida', 'required' => true))
            ->add('Tipo', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), 
                array('label' => 'Tipo', 'required' => true, 
                    'choices' => array('Local de ventas' => 'Local de ventas', 'Oficina' => 'Oficina', 
                        'Galpón' => 'Galpón', 'Depósito' => 'Depósito', 'Otro' => 'Otro')))
            ->add('DepositoClase', 'entity', 
                array('label' => 'Tipo de depósito', 'placeholder' => '(sólo para depósitos)', 
                    'class' => 'Yacare\ComercioBundle\Entity\DepositoClase', 'required' => false))
            ->add('Superficie', new \Tapir\BaseBundle\Form\Type\SuperficieType(), 
                array('label' => 'Superficie (m²)'))
            ->add('CestoBasura', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), 
                array('label' => 'Cesto de basura', 'required' => false, 
                    'choices' => array(null => 'Sin información', 0 => 'No', 1 => 'Si')))
            ->add('Canaletas', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), 
                array('required' => false, 'choices' => array(null => 'Sin información', 0 => 'No', 1 => 'Si')))
            ->add('VeredaMunicipal', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), 
                array('required' => false, 'choices' => array(null => 'Sin información', 0 => 'No', 1 => 'Si'))

                )
            ->add('AnchoSalida', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), 
                array('label' => 'Salida de emergencia', 'required' => false, 
                    'attr' => array('help' => "El valor corresponde a la cantidad de anchos de salida (0,55m)"), 
                    'choices' => array(null => 'Sin información', 0 => 'No', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 
                        6 => '6', 99 => '+')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Local'));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_localtype';
    }
}
