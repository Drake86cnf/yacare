<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class RequisitoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Lugar', null, array(
                'label' => 'Lugar', 
                'attr' => array('placeholder' => 'Lugar físico donde se obtiene o tramita')))
            ->add('Url', null, array(
                'label' => 'Web', 
                'attr' => array('placeholder' => 'Sitio web con información')))
            ->add('Tipo', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'label' => 'Tipo', 
                'required' => true, 
                'choices' => array(
                    'Condición' => 'cond', 
                    'Externo' => 'ext', 
                    'Interno' => 'int')))
            ->add('Departamento', null, array(
                'label' => 'Sector',
                'attr' => array('placeholder' => 'El sector al que pertenece el requisito'), 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.MaterializedPath', 'ASC');
                },
                'choice_label' => 'NombreConSangriaDeEspaciosDuros'))
            ->add('Requiere', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Sub-requisitos', 
                'class' => 'YacareTramitesBundle:Requisito', 
                'required' => false, 
                'choice_label' => 'Nombre', 
                'multiple' => true))
            ->add('Obs', null, array(
                'label' => 'Obs.', 
                'required' => false));            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\Requisito'));
    }
}
