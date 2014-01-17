<?php
namespace Application\BannerBundle\Generator;

use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class HtmlGenerator
 */
class HtmlGenerator extends AbstractGenerator
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
     * {@inheritdoc}
     */
    public function generate()
    {
        $image = $this->uploaderHelper->asset($this->banner, 'file');
        $code  = '<a href="' . $this->banner->getUrl() . '">' .
            "\n" . '<img src="' . $image . '" width="' . $this->banner->getPlace()->getWidth() . '" height="' . $this->banner->getPlace()->getHeight() . '" alt="' . $this->banner->getName() . '" border="0" />' .
            "\n" . '</a>';

        return $code;
    }
}
