<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Kernel;
use Yacare\BaseBundle\DataTransformer\EntityToIdTransformer;

/**
 * Campo de entidad con selcción por buscador.
 *
 * @author Ernesto N. Carrea <ernestocarrea@gmail.com>
 * @author Gregwar <g.passault@gmail.com>
 */
class EntityIdType extends AbstractType
{
    protected $managerRegistry;

    public function __construct(RegistryInterface $registry)
    {
        $this->managerRegistry = $registry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->managerRegistry->getManagerForClass($options['class']);
        
        $transformer = new EntityToIdTransformer(
            $em, 
            $options['class'], 
            $options['property'], 
            $options['query_builder'], 
            $options['multiple']);
        $builder->addModelTransformer($transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('class'));
        $resolver->setDefaults(
            array(
                'em' => null, 
                'property' => 'Nombre', 
                'query_builder' => null, 
                'filters' => null, 
                'hidden' => false, 
                'multiple' => false));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (true === $options['hidden']) {
            $view->vars['type'] = 'hidden';
        }
        
        // Obtengo la ruta base desde el nombre de la entidad (class)
        // Por ejemplo, Yacare\CatastroBundle\Entity\Partida -> yacare_catastro_partida_*
        
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', $options['class']);
        
        $this->BundleName = $PartesNombreClase[1];
        if (strlen($this->BundleName) > 6 && substr($this->BundleName, - 6) == 'Bundle') {
            // Quitar la palabra 'Bundle' del nombre del bundle
            $this->BundleName = substr($this->BundleName, 0, strlen($this->BundleName) - 6);
        }
        
        $this->EntityName = $PartesNombreClase[3];
        if (strlen($this->EntityName) > 10 && substr($this->EntityName, - 10) == 'Controller') {
            // Quitar la palabra 'Bundle' del nombre del bundle
            $this->EntityName = substr($this->EntityName, 0, strlen($this->EntityName) - 10);
        }
        
        $view->vars['baseroute'] = strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'entity_id';
    }
    
    // Devuelve el nombre de la ruta para una acción determinada o la base para conformar las rutas
    protected function obtenerRutaBase($action = null)
    {
        if ($action) {
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_' . $action);
        } else {
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName);
        }
    }
}
