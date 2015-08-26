<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComercioDatosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Nombre', null, array(
                'label' => 'Nombre de fantasía'))
            ->add('ExpedienteNumero', new \Yacare\AdministracionBundle\Form\Type\ExpedienteType(), array(
                'label' => 'Expediente', 
                'required' => false))
            ->add('Apoderado', 'entity_id', array(
                'label' => 'Apoderado', 
                'property' => 'NombreVisible', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_comerciodatostype';
    }
}
