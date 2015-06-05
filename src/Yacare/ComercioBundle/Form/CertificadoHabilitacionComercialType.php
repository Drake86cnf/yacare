<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificadoHabilitacionComercialType extends \Yacare\TramitesBundle\Form\ComprobanteType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('Comercio', new ComercioType(), array('label' => 'Datos del comercio'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial',
                'cascade_validation' => true));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_certificadohabilitacioncomercialtype';
    }
}
