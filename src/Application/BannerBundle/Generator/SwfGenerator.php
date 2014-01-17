<?php
namespace Application\BannerBundle\Generator;

use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class SwfGenerator
 */
class SwfGenerator extends AbstractGenerator
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
        $flash = $this->uploaderHelper->asset($this->banner, 'file');

        return '<embed src="' . $flash . '?url=' . $this->banner->getUrl() . '" quality="high" bgcolor="#FFFFFF"  wmode="transparent" width="' . $this->banner->getPlace()->getWidth() . '" height="' . $this->banner->getPlace()->getHeight() . '" align="" type="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" />';
    }
}
