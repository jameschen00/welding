<?php
namespace Application\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Image type for form
 */
class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'image_path' => 'src'
        ));
    }

    /**
     * Pass the image URL to the view
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('image_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $imageUrl = $accessor->getValue($parentData, $options['image_path']);
                $size     = null;
                if ($imageUrl) {
                    $size = getimagesize($imageUrl)[3];
                }
            } else {
                $imageUrl = null;
                $size     = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['image_url'] = $imageUrl;
            $view->vars['size']      = $size;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'image';
    }
}
