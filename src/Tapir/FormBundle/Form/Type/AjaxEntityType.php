<?php
namespace Tapir\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Tapir\FormBundle\DataTransformer\EntityToIdTextTransformer;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class AjaxEntityType extends AbstractType
{
    protected $registry;
    protected $router;

    public function __construct(ManagerRegistry $registry, RouterInterface $router)
    {
        $this->registry = $registry;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityToIdTextTransformer($this->registry, $options['class'], $options['multiple'],
            $options['property']);
        $builder->addViewTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $value = $view->vars['value'];
        $url = $options['url'];
        $useController = $options['use_controller'];
        $multiple = $options['multiple'];
        if ($value) {
            if ($multiple) {
                // build id string
                $ids = array();
                foreach ($value as $entity) {
                    $ids[] = $entity['id'];
                }
                $view->vars['value'] = implode(',', $ids);
            } else {
                $view->vars['value'] = $value['id'];
            }
            $view->vars['attr']['data-initial'] = json_encode($value);
        }
        if ($useController || $url) {
            $cssclass = 'tapir-ajax-entity';
            if (isset($view->vars['attr']['class'])) {
                $cssclass = $view->vars['attr']['class'] . ' ' . $cssclass;
            }
            $view->vars['attr']['class'] = $cssclass . ($multiple ? ' multiple' : '');
            if ($useController) {
                if (null === $this->registry) {
                    throw new MissingOptionsException(
                        'Debe configurar el servicio "tapir_form.form_types.ajax_entity_controller".');
                }
                if (! $options['property'] && ! $options['repo_method']) {
                    throw new MissingOptionsException('Debe proporcionar el nombre de una propiedad o un método.');
                }
                if ($options['repo_method']) {
                    $view->vars['attr']['data-method'] = $options['repo_method'];
                } else {
                    $view->vars['attr']['data-property'] = $options['property'];
                }
                $view->vars['attr']['data-entity'] = $options['class'];
                $url = $this->router->generate('tapir_ajax_entity');
            }
            $view->vars['attr']['data-ajax-url'] = $url;
        }
        $view->vars['attr']['data-placeholder'] = $options['placeholder'];
        $extraData = $options['extra_data'];
        $serializer = new Serializer(array(), array(new JsonEncoder()));
        $view->vars['attr']['data-extra-data'] = $serializer->serialize($extraData, 'json');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('class'));
        $resolver->setDefaults(
            array(
                'use_controller' => true,
                'url' => null,
                'placeholder' => '',
                'repo_method' => null,
                'property' => 'Nombre',
                'multiple' => false,
                'extra_data' => array()));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'tapir_ajax_entity';
    }
}