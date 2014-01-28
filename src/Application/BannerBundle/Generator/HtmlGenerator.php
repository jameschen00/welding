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
        $place = $this->banner->getPlace();
        $widthDimensions = $place->isWidthPercent() ? '%' : 'px';
        $heightDimensions = $place->isHeightPercent() ? '%' : 'px';

        $code = '<a href="' . $this->banner->getUrl() . '">' .
            "\n" . '<img src="' . $image . '" width="' . $place->getWidth() . $widthDimensions . '" height="' . $place->getHeight() . $heightDimensions . '" alt="' . $this->banner->getName() . '" border="0" />' .
            "\n" . '</a>';

        return $code;
    }
}
