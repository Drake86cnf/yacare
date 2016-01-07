<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de inspección de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class InspeccionComercioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Partida', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Partida', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
                'required' => true))
            ->add('TitularNombre', null, array(
                'label' => 'Propietario'))
            ->add('Actividades', 'Yacare\ComercioBundle\Form\Type\ActividadesType', array(
                'label' => 'Actividades ClaMAE 2014'))
            ->add('ActividadNombre', null, array(
                'label' => 'Actividades'))
            ->add('NumeroSolicitud', null, array(
                'label' => 'Nº de solicitud'))
            ->add('ExpedienteNumero', null, array(
                'label' => 'Nº de expediente'))
            ->add('Obs','Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                'label' => 'Obs.'))
            ->add('EstadoTramite', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Instancia del trámite', 
                'required' => true, 
                'choices' => array(
                    'Catastro y Planeamiento Urbano' => 'Catastro y Planeamiento', 
                    'Obras Particulares (Inspección)' => 'Obras Particulares-Inspeccion Tecnica', 
                    'Obras Particulares (Pendiente)' => 'Pendiente-ObrasParticulares')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\InspeccionComercio'));
    }
}
