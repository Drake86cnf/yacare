<?php

namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Kernel;

use Yacare\BaseBundle\DataTransformer\EntityToIdTransformer;

/**
 * Entity identitifer
 *
 * @author Gregwar <g.passault@gmail.com>
 */
class EntityIdType extends AbstractType
{
    protected $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ('2' == Kernel::MAJOR_VERSION && Kernel::MINOR_VERSION < '1') {
            $em = $this->registry->getEntityManager($options['em']);
        } else {
            $em = $this->registry->getManager($options['em']);
        }
        
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', $options['class']);
        
        if(!isset($this->BundleName)) {
            $this->BundleName = $PartesNombreClase[1];
            if(strlen($this->BundleName) > 6 && substr($this->BundleName, -6) == 'Bundle') {
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->BundleName = substr($this->BundleName, 0, strlen($this->BundleName) - 6);
            }
        }

        if(!isset($this->EntityName)) {
            $this->EntityName = $PartesNombreClase[3];
            if(strlen($this->EntityName) > 10 && substr($this->EntityName, -10) == 'Controller') {
                // Quitar la palabra 'Bundle' del nombre del bundle
                $this->EntityName = substr($this->EntityName, 0, strlen($this->EntityName) - 10);
            }
        }

        $builder->addModelTransformer(new EntityToIdTransformer(
            $em,
            $options['class'],
            $options['property'],
            $options['query_builder'],
            $options['multiple']
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'class',
        ));

        $resolver->setDefaults(array(
            'em'            => null,
            'property'      => null,
            'query_builder' => null,
            'hidden'        => true,
            'multiple'      => false
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (true === $options['hidden']) {
            $view->vars['type'] = 'hidden';
        }
        
        $view->vars['baseroute'] = $this->getBaseRoute();
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
    protected function getBaseRoute($action = null) {
        if($action) {
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName . '_' . $action);
        } else {
            return strtolower('yacare_' . $this->BundleName . '_' . $this->EntityName);
        }
    }
}
