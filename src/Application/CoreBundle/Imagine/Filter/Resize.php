<?php
namespace Application\CoreBundle\Imagine\Filter;

use Imagine\Exception\InvalidArgumentException;
use Imagine\Filter\FilterInterface;
use Imagine\Image\Box;
use Imagine\Image\Color;
use Imagine\Image\ImagineInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

/**
 * Filter for resizing an image relative to its existing dimensions.
 */
class Resize implements FilterInterface
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var string
     */
    private $backgroud;

    /**
     * @var \Imagine\Image\ImagineInterface
     */
    private $imagine;

    /**
     * @param int    $width
     * @param int    $height
     * @param string $backgroud
     */
    public function __construct(ImagineInterface $imagine, $width, $height, $backgroud)
    {
        $this->imagine = $imagine;
        $this->width = $width;
        $this->height = $height;
        $this->backgroud = $backgroud;
    }

    /**
     * {@inheritDoc}
     */
    public function apply(ImageInterface $image)
    {
        $size = $image->getSize();

        //calculate width, height, offset
        $kWidth = $size->getWidth() / $this->width;
        $kHeight = $size->getHeight() / $this->height;
        $k = max(array($kWidth, $kHeight));

        $k < 1 && $k = 1;

        $dWidth = intval(floor($size->getWidth() / $k));
        $dHeight = intval(floor($size->getHeight() / $k));

        $offsetX = intval(($this->width - $dWidth) / 2);
        $offsetY = intval(($this->height - $dHeight) / 2);

        $canvas = $this->imagine->create(new Box($this->width, $this->height), new Color($this->backgroud));
        $image->resize(new Box($dWidth, $dHeight));

        return $canvas->paste($image, new Point($offsetX, $offsetY));
    }
}
