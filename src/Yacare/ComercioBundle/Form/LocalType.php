<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Formulario para un local.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 */
class LocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Partida', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Partida',
                'class' => 'Yacare\CatastroBundle\Entity\Partida',
                'required' => true))
            ->add('SubDomicilio', null, array(
                'label' => 'Identificación',
                'attr' => array('class' => 'tapir-input-240 tapir-input-maymin')))
            ->add('Tipo', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'label' => 'Tipo',
                'required' => true,
                'choices' => array(
                    'Local comercial' => 'Local comercial',
                    'Depósito' => 'Depósito',
                    'Otro' => 'Otro')))
            ->add('DepositoClase', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Tipo de depósito',
                'placeholder' => '(sólo para depósitos)',
                'class' => 'Yacare\ComercioBundle\Entity\DepositoClase',
                'required' => false))
            ->add('Superficie', 'Tapir\BaseBundle\Form\Type\SuperficieType', array(
                'label' => 'Superficie total (m²)'))
            ->add('SuperficieDeposito', 'Tapir\BaseBundle\Form\Type\SuperficieType', array(
                'label' => 'Depósito (m²)',
                'required' => false,
                'attr' => array('help' => 'Indicar cuántos metros cuadrados de la superficie 
                    total están dedicados a depósito.')))
            ->add('Obs', null, array(
                'label' => 'Observaciones',
                'attr' => array('class' => 'tapir-input-maymin')))
            ->add('CestoBasura', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'label' => 'Cesto de basura',
                'required' => false,
                'choices' => array(
                    'Sin información' => -1 ,
                    'No' => 0,
                    'Sí' => 1)))
            ->add('Canaletas', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'required' => false,
                'choices' => array(
                    'Sin información' => -1 ,
                    'No' => 0,
                    'Sí' => 1)))
            ->add('VeredaMunicipal', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'required' => false,
                'choices' => array(
                    'Sin información' => -1 ,
                    'No' => 0,
                    'Sí' => 1)))
            ->add('AnchoSalida', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'label' => 'Salida de emergencia',
                'required' => false,
                'attr' => array(
                    'help' => "El valor corresponde a la cantidad de anchos (de 90 cm) que suman todas las salidas 
                        de emergencia."),
                'choices' => array(
                    'Sin información' => -1 ,
                    'No' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    'Más de 6' => 99)));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Local'));
    }
}
