<?php
namespace Application\GalleryBundle\Tests\Grid\Type;

use Application\CoreBundle\Tests\AbstractGridTest;
use Application\GalleryBundle\Grid\Type\SectionType;

/**
 * Class SectionTypeTest
 */
class SectionTypeTest extends AbstractGridTest
{
    /**
     * {@inheritdoc}
     */
    protected function createGrid($manager)
    {
        return new SectionType($manager);
    }
}
