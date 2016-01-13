<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para persona.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TipoSociedad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array('label' => 'Tipo',
                 'choices' => array(
                     'Persona física' => 0,
                     'Sociedad Anónima' => 1,
                     'Sociedad de Responsabilidad Limitada' => 8,
                     'Sociedad de Hecho' => 3,
                     'Sociedad Colectiva' => 2,
                     'Sociedad en Comandita por Acciones' => 4,
                     'Sociedad de Capital e Industria' => 5,
                     'Sociedad Accidental o en Participación' => 6,
                     'Sociedad en Comandita Simple' => 7,
                     'Cooperativa' => 9,
                     'Asociación Sin Fines de Lucro' => 10,
                     'Entidad Gubernamental' => 11,
                     'Otra persona jurídica' => 99)))
            ->add('Apellido', null, array(
                'label' => 'Apellido',
                'attr' => array('class' => 'tapir-input-maymin')))
            ->add('Nombre', null, array(
                'label' => 'Nombre',
                'attr' => array('class' => 'tapir-input-maymin')))
            ->add('RazonSocial', null, array(
                'label' => 'Razón social',
                'attr' => array('class' => 'tapir-input-maymin')))
            ->add('Documento', 'Yacare\BaseBundle\Form\Type\DocumentoType', array(
                'label' => 'Documento',
                'required' => false))
            ->add('Cuilt',  'Tapir\BaseBundle\Form\Type\CuiltType', array(
                'label' => 'CUIL/CUIT',
                'required' => false))
            ->add('Nib',  null, array(
                'label' => 'Nº de Ingresos Brutos',
                'attr' => array('class' => 'tapir-input-sinespacios tapir-input-320')))
            ->add('Grupos', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Grupos',
                'class' => 'YacareBaseBundle:PersonaGrupo',
                'attr' => array('style' => 'width: 100%'),
                'multiple' => true,
                'required' => false))
            ->add('Domicilio', 'Yacare\BaseBundle\Form\Type\DomicilioType', array(
                'label' => 'Domicilio',
                'required' => false
            ))
            ->add('TelefonoNumero', null, array(
                'label' => 'Teléfonos',
                'attr' => array('class' => 'tapir-input-maymin')))
            ->add('Email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'Correo electrónico',
                'required' => false,
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-minus tapir-input-sinespacios')))
            ->add('FechaNacimiento', 'Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType', array(
                'required' => false,
                'label' => 'Fecha de nacimiento'))
            ->add('Genero', 'Tapir\BaseBundle\Form\Type\GeneroType', array('label' => 'Género', 'required' => true))
            ->add('Pais', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Nacionalidad',
                'placeholder' => 'Sin especificar',
                'class' => 'YacareBaseBundle:Pais',
                'choice_label' => 'NombreYGentilicio',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
