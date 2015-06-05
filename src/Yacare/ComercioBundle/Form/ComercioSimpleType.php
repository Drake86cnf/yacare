<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComercioSimpleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('Nombre', null, array('label' => 'Nombre de fantasía'))
            ->add('Apoderado', 'entity_id', 
            array(
                'label' => 'Apoderado',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required' => false))
            ->add('Local', 'entity_id', 
            array('label' => 'Local','class' => 'Yacare\ComercioBundle\Entity\Local','required' => true))
            ->add('ActividadPrincipal', 'entity_id', 
            array(
                'label' => 'Actividad principal',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('ActividadSecundaria', 'entity_id', 
            array(
                'label' => 'Actividad secundaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('ActividadTerciaria', 'entity_id', 
            array(
                'label' => 'Actividad terciaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_comerciosimpletype';
    }
}
