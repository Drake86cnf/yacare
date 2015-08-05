<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TramiteHabilitacionComercialType extends \Yacare\TramitesBundle\Form\TramiteType
{
	use \Yacare\TramitesBundle\Entity\ConTitular;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('Comercio', new ComercioSimpleType(), 
            array('label' => 'Datos del comercio'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial',
                'cascade_validation' => true));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitehabilitacioncomercialtype';
    }
}
