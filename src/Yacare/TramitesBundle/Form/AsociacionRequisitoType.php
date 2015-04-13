<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AsociacionRequisitoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('TramiteTipo', 'entity', 
            array(
                'label' => 'Tipo de trámite',
                'class' => 'YacareTramitesBundle:TramiteTipo',
                'required' => true,
                'read_only' => true,
                'multiple' => false))
            ->add('Requisito', 'entity', 
            array(
                'label' => 'Requisito',
                'class' => 'YacareTramitesBundle:Requisito',
                'required' => true,
                'multiple' => false,
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er)
                {
                    return $er->createQueryBuilder('i');
                }))
            ->add('Propiedad', 'choice', 
            array(
                'label' => 'De',
                'required' => false,
                'placeholder' => 'n/a',
                'choices' => array(
                    'Titular' => 'Titular',
                    'Apoderado' => 'Apoderado',
                    'Inmueble' => 'Inmueble',
                    'Inmueble.Titular' => 'Titular del inmueble',
                    'ReponsableTecnico' => 'Reponsable técnico')))
            ->add('Instancia', 'choice', 
            array(
                'label' => 'Instancia',
                'required' => true,
                'choices' => array(
                    'na' => 'n/a',
                    'ori' => 'Original',
                    'cop' => 'Original y copia',
                    'cos' => 'Copia simple',
                    'coc' => 'Copia certificada',
                    'col' => 'Copia legalizada')))
            ->add('Opcional', 'checkbox', 
            array('label' => 'Opcional','required' => false))
            ->add('Notas', null, array('label' => 'Notas'))
            ->add('CondicionQue', 'text', 
            array('label' => 'Sólo si','required' => false))
            ->add('CondicionEs', 'choice', 
            array(
                'label' => 'Es',
                'required' => false,
                'placeholder' => 'n/a',
                'choices' => array(
                    '==' => 'igual',
                    '>' => 'mayor',
                    '<' => 'menor',
                    '!=' => 'diferente',
                    '>=' => 'mayor o igual',
                    '<=' => 'menor o igual',
                    'notnull' => 'existe',
                    'null' => 'no existe',
                    'true' => 'verdadero',
                    'false' => 'falso',
                    'in' => 'incluido en',
                    'notin' => 'no incluido en')))
            ->add('CondicionCuanto', 'text', 
            array('label' => 'A','required' => false))
            ->add('Obs', null, 
            array('label' => 'Explicación de la condición','required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\TramitesBundle\Entity\AsociacionRequisito'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_asociacionrequisitoype';
    }
}
