<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario simple para un comercio.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComercioSimpleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Nombre', null, array(
                'label' => 'Nombre de fantasía'))
            ->add('ExpedienteNumero', 'Yacare\AdministracionBundle\Form\Type\ExpedienteType', array(
                'label' => 'Expediente',
                'required' => false))
            ->add('ActoAdministrativoNumero', 'Yacare\AdministracionBundle\Form\Type\ActoAdministrativoType', array(
                'label' => 'Acto administrativo',
                'required' => false
            ))
            ->add('PosicionArchivo', null, array(
                'label' => 'Posición en archivo',
                'required' => false
            ))
            ->add('Apoderado', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Apoderado',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'property' => 'NombreVisible',
                'required' => false))
            ->add('Local', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Local',
                'class' => 'Yacare\ComercioBundle\Entity\Local',
                'required' => false))
            ->add('Actividad1', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 1',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad2', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 2',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad3', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 3',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad4', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 4',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad5', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 5',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad6', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 6',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }
}
