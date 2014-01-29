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

        $width = $place->getWidth();
        $width && $width = 'width="' . ($width . ($place->isWidthPercent() ? '%' : 'px')) . '"';

        $height = $place->getHeight();
        $height && $height = 'height="' . ($height . ($place->isHeightPercent() ? '%' : 'px')) . '"';

        $code = '<a href="' . $this->banner->getUrl() . '">' .
            "\n" . '<img src="' . $image . '" ' . ($width?$width:'') . ' ' . ($height?$height:'') . ' alt="' . $this->banner->getName() . '" border="0" />' .
            "\n" . '</a>';

        return $code;
    }
}
