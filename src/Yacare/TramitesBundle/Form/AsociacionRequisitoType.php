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
            ->add('TramiteTipo', 'entity_hidden', array(
                'label' => 'Tipo de trámite', 
                'class' => 'YacareTramitesBundle:TramiteTipo', 
                'required' => true, 
                'read_only' => true, 
                'multiple' => false))
            ->add('Requisito', 'entity', array(
                'label' => 'Requisito', 
                'class' => 'YacareTramitesBundle:Requisito', 
                'required' => true, 
                'multiple' => false, 
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er) {
                    return $er->createQueryBuilder('i');
                }))
            ->add('Propiedad', 'choice', array(
                'label' => 'De', 
                'required' => false, 
                'placeholder' => 'n/a', 
                'choices' => array(
                    'Titular' => 'Titular', 
                    'Apoderado' => 'Apoderado', 
                    'Inmueble' => 'Inmueble', 
                    'Inmueble.Titular' => 'Titular del inmueble', 
                    'ReponsableTecnico' => 'Reponsable técnico')))
            ->add('Instancia', 'choice', array(
                'label' => 'Instancia', 
                'required' => true, 
                'choices' => array(
                    'na' => 'n/a', 
                    'ori' => 'Original', 
                    'cop' => 'Original y copia', 
                    'cos' => 'Copia simple', 
                    'coc' => 'Copia certificada', 
                    'col' => 'Copia legalizada')))
            ->add('Tipo', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), array(
                'label' => 'Tipo',
                'required' => true,
                'choices' => array(
                    '0' => 'Fijo',
                    '1' => 'Opcional',
                    '2' => 'Condicional',
                    '3' => 'Condicional y opcional'
                )
            ))
            ->add('Notas', null, array('label' => 'Notas'))
            ->add('CondicionQue', 'text', array('label' => 'Sólo si', 'required' => false))
            ->add('CondicionEs', 'choice', array(
                'label' => 'Es', 
                'required' => false, 
                'placeholder' => 'n/a', 
                'choices' => array(
                    '==' => 'es igual a', 
                    '>' => 'es mayor que', 
                    '<' => 'es menor que', 
                    '!=' => 'es diferente a', 
                    '>=' => 'es mayor o igual que', 
                    '<=' => 'es menor o igual que', 
                    'null' => 'existe', 
                    'not null' => 'no existe', 
                    'true' => 'es verdadero', 
                    'false' => 'es falso', 
                    'in' => 'está incluido en', 
                    'not in' => 'no está incluido en')))
            ->add('CondicionCuanto', 'text', array('label' => 'A', 'required' => false))
            ->add('Obs', null, array('label' => 'Explicación de la condición', 'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\AsociacionRequisito'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_asociacionrequisitoype';
    }
}
