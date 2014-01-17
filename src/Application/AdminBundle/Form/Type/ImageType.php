<?php
namespace Application\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Image type for form
 */
class ImageType extends AbstractType
{
    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    /**
     * @param UploaderHelper $imageHelper
     */
    public function setUploaderHelper(UploaderHelper $imageHelper)
    {
        $this->uploaderHelper = $imageHelper;
    }

    /**
     * Pass the image URL to the view
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     *
     * @return array
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $parentData = $form->getParent()->getData();

        if (null !== $parentData) {
            $imageUrl = $this->uploaderHelper->asset($parentData, $form->getName());
        } else {
            $imageUrl = null;
        }
        // set an "image_url" variable that will be available when rendering this field
        $view->vars['image_url'] = $imageUrl;

        return $options;
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
