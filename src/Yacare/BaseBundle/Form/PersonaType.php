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
            ->add('Apellido', null, array('label' => 'Apellido'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('TipoSociedad', 'choice', array('label' => 'Tipo',
                 'choices' => array(
                     0 => 'Persona física',
                     '1' => 'Sociedad Anónima',
                     '8' => 'Sociedad de Responsabilidad Limitada',
                     '3' => 'Sociedad de Hecho',
                     '2' => 'Sociedad Colectiva',
                     '4' => 'Sociedad en Comandita por Acciones',
                     '5' => 'Sociedad de Capital e Industria',
                     '6' => 'Sociedad Accidental o en Participación',
                     '7' => 'Sociedad en Comandita Simple',
                     '9' => 'Cooperativa',
                     '10' => 'Asociación Sin Fines de Lucro')
            ))
            ->add('RazonSocial', null, array('label' => 'Razón social'))
            ->add('Documento', new \Yacare\BaseBundle\Form\Type\DocumentoType(), array('label' => 'Documento'))
            ->add('Cuilt',  new \Tapir\BaseBundle\Form\Type\CuiltType(), array('label' => 'CUIL/CUIT'))
            ->add('Nib',  null, array('label' => 'Ingresos Brutos'))
            ->add('Grupos', 'entity', array(
                'label' => 'Grupos',
                'class' => 'YacareBaseBundle:PersonaGrupo',
                'attr' => array('style' => 'width: 100%'),
                'multiple' => true,
                'required' => false))
            ->add('UsuarioRoles', 'entity', array(
                'label' => 'Roles',
                'class' => 'TapirBaseBundle:PersonaRol',
                'attr' => array('style' => 'width: 100%'),
                'multiple' => true,
                'required' => false))
            ->add('Domicilio', new \Yacare\BaseBundle\Form\Type\DomicilioType(), array('label' => 'Domicilio'))
            ->add('TelefonoNumero', null, array('label' => 'Teléfonos'))
            ->add('Email', 'email', array('label' => 'Correo electrónico', 'required' => false))
            ->add('FechaNacimiento', new \Tapir\BaseBundle\Form\Type\FechaNacimientoType(), array(
                'required' => false,
                'label' => 'Fecha de nacimiento'))
            ->add('Genero', new \Tapir\BaseBundle\Form\Type\GeneroType(), array('label' => 'Género', 'required' => true))
            ->add('Pais', 'entity', array(
                'label' => 'Nacionalidad',
                'placeholder' => 'Sin especificar',
                'class' => 'YacareBaseBundle:Pais',
                'property' => 'NombreYGentilicio',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }

    public function getName()
    {
        return 'yacare_basebundle_personatype';
    }
}
