<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsociacionRequisitoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TramiteTipo', 'Tapir\FormBundle\Form\Type\EntityHiddenType', array(
                'label' => 'Tipo de trámite', 
                'class' => 'YacareTramitesBundle:TramiteTipo', 
                'required' => true, 
                'attr' => array('readonly' => true), 
                'multiple' => false))
            ->add('Requisito', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Requisito', 
                'class' => 'YacareTramitesBundle:Requisito', 
                'required' => true, 
                'multiple' => false, 
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er) {
                    return $er->createQueryBuilder('i');
                }))
            ->add('Propiedad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'De', 
                'required' => false, 
                'placeholder' => 'n/a', 
                'choices' => array(
                    'Titular' => 'Titular', 
                    'Apoderado' => 'Apoderado', 
                    'Inmueble' => 'Inmueble', 
                    'Titular del inmueble' => 'Inmueble.Titular', 
                    'Reponsable técnico' => 'ReponsableTecnico')))
            ->add('Instancia', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Instancia', 
                'required' => true, 
                'choices' => array(
                    'n/a' => 'na', 
                    'Original' => 'ori', 
                    'Original y copia' => 'cop', 
                    'Copia simple' => 'cos', 
                    'Copia certificada' => 'coc', 
                    'Copia legalizada' => 'col')))
            ->add('Tipo', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'label' => 'Tipo',
                'required' => true,
                'choices' => array(
                    'Fijo' => 0,
                    'Opcional' => 1,
                    'Condicional' => 2,
                    'Condicional y opcional' => 3)))
            ->add('Notas', null, array('label' => 'Notas'))
            ->add('CondicionQue', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Sólo si', 
                'required' => false))
            ->add('CondicionEs', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Es', 
                'required' => false, 
                'placeholder' => 'n/a', 
                'choices' => array(
                    'es igual a' => '==', 
                    'es mayor que' => '>', 
                    'es menor que' => '<', 
                    'es diferente a' => '!=', 
                    'es mayor o igual que' => '>=', 
                    'es menor o igual que' => '<=', 
                    'existe' => 'null', 
                    'no existel' => 'not null', 
                    'es verdadero' => 'true', 
                    'es falso' => 'false', 
                    'está incluido en' => 'in', 
                    'no está incluido en' => 'not in')))
            ->add('CondicionCuanto', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'A', 
                'required' => false))
            ->add('Obs', null, array(
                'label' => 'Explicación de la condición', 
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\AsociacionRequisito'));
    }
}
