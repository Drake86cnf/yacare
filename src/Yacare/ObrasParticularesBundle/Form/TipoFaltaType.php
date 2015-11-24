<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de tipo de faltas.
 *
 * @author Ezequiel Riquelme <rezequiel.tdfa@gmail.com>
 */
class TipoFaltaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Nombre', null, array('label' => 'Nombre', 'required' => true))
            ->add('FaltaCompromiso', null, array('label' => 'Compromiso', 'required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ObrasParticularesBundle\Entity\TipoFalta'));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_tipofaltatype';
    }
}
