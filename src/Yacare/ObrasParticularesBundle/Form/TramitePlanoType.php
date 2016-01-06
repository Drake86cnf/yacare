<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Formulario de movimiento de previas.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class TramitePlanoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, array(
                'label' => 'Número',
                'attr' => array('readonly' => true)))
            ->add('Partida', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Partida', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
                'required' =>true))
            ->add('Profesional', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Profesional',
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado',
                'required' => true))
            ->add('Obs', TextareaType::class, array(
                'label' => 'Observaciones', 
                'required' => false))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\TramitePlano'));
    }
}
