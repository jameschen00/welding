<?php
namespace Application\NewsBundle\Tests\Grid\Type;

use Application\CoreBundle\Tests\AbstractGridTest;
use Application\GalleryBundle\Grid\Type\ImageType;

/**
 * Class ImageTypeTest
 */
class ImageTypeTest extends AbstractGridTest
{
    /**
     * {@inheritdoc}
     */
    protected function createGrid($manager)
    {
        return new ImageType($manager);
    }
}