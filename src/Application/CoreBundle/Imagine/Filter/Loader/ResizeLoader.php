<?php
namespace Application\CoreBundle\Imagine\Filter\Loader;

use Application\CoreBundle\Imagine\Filter\Resize;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Exception\InvalidArgumentException;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;

/**
 * Class ResizeLoader
 */
class ResizeLoader implements LoaderInterface
{
    /**
     * @var \Imagine\Image\ImagineInterface
     */
    private $imagine;

    /**
     * @param ImagineInterface $imagine
     */
    public function __construct(ImagineInterface $imagine)
    {
        $this->imagine = $imagine;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ImageInterface $image, array $options = array())
    {
        $width = $options['size'][0];
        $height = $options['size'][1];
        $background = !empty($options['background']) ? $options['background'] : '#fff';
        if (!$width || !$height) {
            throw new InvalidArgumentException('Expected width and height parameters');
        }

        $filter = new Resize($this->imagine, $width, $height, $background);

        return $filter->apply($image);
    }
}